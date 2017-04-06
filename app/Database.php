<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Config;

class Database extends Model
{
    //
    public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = ['name', 'driver', 'host', 'port', 'database', 'username',
            'password', 'table', 'uid_column', 'student_type'];

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
      return $this->belongsToMany('App\Attribute')->withPivot(['column']);
    }

    public function run_update()
    {
      //Run the update with the information provided
      Config::set('database.connections.newConnect', $this->set_database_array());

      \DB::connection('newConnect');
    }

    public function test()
    {
      //Tests the connection of a database
      config(['database.connections.newConnect' => $this->set_database_array()]);
      //\DB::purge('mysql'); //Disconnect from current
      //dd(config('database.connections.newConnect'));

      $second = \DB::connection('newConnect');
      $second->select("SELECT * FROM USFviewOrientationDatafeed"); //Attempt to connect

      foreach($this->attributes as $attribute)
      {
        //DB::
      }
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
      $settings['username'] = $this->username;
      $settings['password'] = $this->password;

      return $settings;
    }
}
