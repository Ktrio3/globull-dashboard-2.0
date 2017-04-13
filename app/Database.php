<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Config;

class Database extends Model
{
    //
    public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = ['name', 'driver', 'host', 'port', 'database', 'username_database',
            'password_database', 'table', 'uid_column', 'student_type'];

    private $mysql_Config_default = [
        'driver' => 'mysql',
        'host' => '',
        'port' => '',
        'database' => '',
        'username' => '',
        'password' => '',
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'prefix' => '',
        'strict' => true,
        'engine' => null
    ];

    private $sqlsrv_Config_default = [
        'driver' => 'sqlsrv',
        'host' => '',
        'database' => '',
        'username' => '',
        'password' => '',
        'charset' => 'utf8',
        'prefix' => '',
    ];

    public function attributes()
    {
      return $this->belongsToMany('App\Attribute')->withPivot(['column', 'message_column']);
    }

    public function student_type()
    {
      return $this->belongsTo('App\StudentType', 'student_type');
    }

    public function run_update($semester)
    {
      ini_set('max_execution_time', 300); //300 seconds = 5 minutes
      //Grab all the students in the semester given
      $type = $this->student_type;
      $uids = Student::where('admit_semester', $semester)->whereHas('student_types', function($query) use($type){
        $query->where('student_types.id', $type);
      })->pluck("UID");

      //Run the update with the information provided
      config(['database.connections.newConnect' => $this->set_database_array()]);

      $secondDB = \DB::connection('newConnect');

      //Grab all the information about each student -- do this in chunks
      //Foreach student, add updated attribute info
      $students_info = $secondDB->table($this->attributes['table'])->whereIn($this->uid_column, $uids)->get();

      foreach($students_info as $student_info)
      {
        $student = Student::where('UID', $student_info->{$this->uid_column})->first();

        foreach($this->attributes()->get() as $attribute)
        {
          $value = $student_info->{$attribute->pivot->column};

          if($attribute->is_info)
          {
            //Fill with the given value
            $status = Status::where('code', $attribute->code . "-fillable")->first();

            if($attribute->pivot->message_column != "" && $attribute->pivot->message_column != null)
              $student->statuses()->attach($status->id, ['value' => $value, 'message' => $student_info->{$attribute->pivot->message_column}]);
            else
              $student->statuses()->attach($status->id, ['value' => $value]);
          }
          else
          {
            //Check that status exists, then attach
            $status = Status::where('code', $value)
                ->where('attribute_id', $attribute->id)->first();

            if(!$status)
              return ['error' => "Could not find status " . $value . " for attribute " . $attribute->code];

            if($attribute->pivot->message_column != "" && $attribute->pivot->message_column != null)
            {
              $student->statuses()->attach($status->id, ['message' => $student_info->{$attribute->pivot->message_column}]);
            }
            else
              $student->statuses()->attach($status->id);
          }
        }
        $student->save();
      }

      return [];
    }

    public function test()
    {
      //Tests the connection of a database
      config(['database.connections.newConnect' => $this->set_database_array()]);
      //\DB::purge('mysql'); //Disconnect from current
      //dd(config('database.connections.newConnect'));

      $secondDB = \DB::connection('newConnect');

      //Query we need for testing. Non-testing removes limit and adds where
      //$second->table($this->attributes['table'])->whereIn($this->uid_column, [])->get(); //Production

      $fail = false;

      try {
          $results = $secondDB->table($this->attributes['table'])->limit(1)->get();
      } catch (\Exception $e) {
          print_r('Check the connection info provided. If error continues, contact developer: ' . $e->getMessage() . "<br/><br/>");
          $fail = true;
      }

      foreach($this->attributes()->get() as $attribute)
      {
        if(!isset($results[0][$attribute->pivot->column]))
        {
          $fail = true;
          print_r("Could not find " . $attribute->name . " using " . $attribute->pivot->column . "<br/><br/>");
        }

        if($attribute->pivot->message_column != "" && !isset($results[0][$attribute->pivot->column]))
        {
          $fail = true;
          print_r("Could not find " . $attribute->name . " message using " . $attribute->pivot->message_column . "<br/><br/>");
        }
      }

      if(!$fail)
        print_r("All tests passed!");
    }

    private function set_database_array()
    {
      if($this->driver == 'mysql')
      {
        $settings = $this->mysql_Config_default;
        //Add Mysql specific stuff
        $settings['port'] = $this->port;
      }
      else if($this->driver == 'sqlsrv')
      {
        $settings = $this->sqlsrv_Config_default;
        //Add sqlsrv specifc stuff
      }

      //Add common attributes
      $settings['host'] = $this->host;
      $settings['database'] = $this->database;
      $settings['username'] = $this->username_database;
      $settings['password'] = $this->password_database;

      return $settings;
    }
}
