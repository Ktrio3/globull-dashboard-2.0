<?php

namespace App\Http\Controllers;

use App\StudentType;
use App\Student;
use App\Status;
use App\Attribute;
use Illuminate\Http\Request;
use Excel;

class UploadController extends Controller
{
    /**
     * Instantiate a new UserController instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return view('admin.upload');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function preview()
    {
      return view('admin.preview');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function do_preview(Request $request)
    {
      $student = new Student;
      $status = 'Previewing Type(s): ';

      foreach($request->get('student_types') as $type)
      {
        $newType = StudentType::where('id', $type)->first();
        $status .= $newType->name . ', ';
        $student->student_types->add($newType);
      }

      //Replace last comma with period
      $status[-2] = '.';

      session(['status' => $status]);

      return view('student.student', ['student' => $student]);
    }

    public function upload(Request $request)
    {
      if($request->file('sheet')->isValid())
      {
        $path = $request->sheet->path();

        Excel::load($path, function($reader) {
          // ->all() is a wrapper for ->get() and will work the same
          $results = $reader->all();
          //$reader->dd();

          $results = $reader->toObject();

          //Loop through each row
          foreach($results as $result)
          {
            //Find the student associated
            $uid = $result->uid;

            if($uid == null)
            {
              //If uid failed, try netid
              $netid = $result->netid;

              if($netid == null)
              {
                //NOTE: Need to throw an error here
                var_dump("No way to identify student");
              }

              //Process using netid, UID is required to create
              $student = Student::where('netid', $netid)->first(['netid' => $netid]);
            }
            else
            {
              //Process using UID
              $student = Student::where('UID', $uid)->firstOrCreate(['UID' => $uid]);
            }

            //NOTE: Need to do something about new students! //
            //NOTE: Need to do something about student types! //
            //NOTE: Need to do something about status messages! //
            //NOTE: Need to do something about "info" statuses

            //Loop through each column, and set student statuses
            foreach($result as $key => $value)
            {
              //Skip special headers for now
              if($key == 'uid')
              {
                $student->uid = $value;
                continue;
              }

              if($key == 'netid')
              {
                $student->netid = $value;
                continue;
              }

              if($key == 'admit_sem')
              {
                $student->admit_semester = $value;
                continue;
              }

              if($key == 'types')
              {
                //Types should be split, and cleared if necessary
                $value = str_replace(', ', ',', $value);
                $types = explode(',', $value);
                $studentType = [];
                $clear = false;
                foreach($types as $type)
                {
                  if($type == "CLR")
                  {
                    $clear = true;
                  }
                  else
                    $studentType[] = StudentType::where('code', $type)->value('id');
                }
                $studentType[] = StudentType::where('code', 'ALL')->value('id');

                if($clear)
                  $student->student_types()->sync($studentType); //Removes other types
                else
                  $student->student_types()->attach($studentType); //Adds these types
                continue;
              };

              //Check if this is a message. If so, skip. Messages handled after status found.
              if(strpos($key, '_message') !== FALSE) continue;

              //The package adds blank for some reason
              if($key == '') continue;

              //Find this status
              $attribute = Attribute::where('code', $key)->firstOrFail();

              if($attribute == null)
              {
                //NOTE: Error. Bad attribute found.
                print_r("Oh no! $key"); die();
              }

              //If this is a fillable status, fill it!
              if($attribute->is_info == 1)
              {
                $status = Status::where('code', $attribute->code . '-fillable')->where('attribute_id', $attribute->id)->firstOrFail();
              }
              else
                $status = Status::where('code', $value)->where('attribute_id', $attribute->id)->firstOrFail();

              if($status == null)
              {
                //NOTE: Error. Bad status found.
                print_r("Oh no! $key"); die();
              }

              if($result->get($key . '_message') != null)
              {
                if($attribute->is_info == 1)
                  $sync = [$status->id => ['value' => $value, 'message' => $result->get($key . '_message')]];
                else
                  $sync = [$status->id => ['message' => $result->get($key . '_message')]];

              }
              else
              {
                if($attribute->is_info == 1)
                  $sync = [$status->id => ['value' => $value]];
                else
                  $sync = [$status->id];
              }

              //If there is a curret status, remove it
              $removeStatuses = $student->statuses()->where('attribute_id', $attribute->id)->pluck('statuses.id')->toArray();
              if(!empty($removeStatuses))
                $student->statuses()->detach($removeStatuses);

              if(!$student->student_types()->exists())
              {
                //Student was just created. Add the ALL student type
                $newType = StudentType::where('code', 'ALL')->firstOrFail();
                $student->student_types()->attach($newType);
              }

              //Add the new status
              $student->statuses()->sync($sync, false);
              $student->save();

            }
          }
        });
      }

      return view('admin.admin');
    }
}
