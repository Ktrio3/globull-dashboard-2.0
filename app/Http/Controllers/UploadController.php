<?php

namespace App\Http\Controllers;

use App\StudentType;
use App\Student;
use App\Status;
use App\Attribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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

    public function export()
    {
      return view('admin.student-export');
    }

    public function doExport(Request $request)
    {
      // May need longer than 30 seconds for large excel files
      ini_set('max_execution_time', 300); //300 seconds = 5 minutes

      if($request->get('filter') == 0)
      {
        $data = $this->getAll();
      }

      return view('admin.student-export');
    }

    private function getAll()
    {
      $final = [];
      $keys = Attribute::orderBy('code')->pluck('code')->toArray();

      Student::with(['statuses.attribute', 'student_types'])->chunk(100, function ($students) use($keys, $final) {
          foreach ($students as $student) {
              //
            $value = [];

            $value['UID'] = $student->UID;
            $value['netid'] = $student->netid;
            $value['admit_semester'] = $student->admit_semester;

            foreach($keys as $key)
            {
              $value[$key] = ''; //The export library is dumb; if keys are present, still places by order...
            }

            foreach($student->statuses as $status)
            {
              if($status->attribute->is_info)
                $value[$status->attribute->code] = $status->pivot->value;
              else
                $value[$status->attribute->code] = $status->code;
            }

            $final[] = $value;
          }
      });

      $this->exportStudents($final);
    }

    private function exportStudents($array)
    {
      Excel::create('export_student', function($excel) use($array) {
        // Set the title
        //$excel->setTitle('Our new awesome title');
        // Chain the setters
        //$excel->setCreator('Maatwebsite')
        //      ->setCompany('Maatwebsite');

        // Call them separately
        //$excel->setDescription('A demonstration to change the file properties');

        // Our first sheet
        $excel->sheet('students', function($sheet) use($array) {
          $sheet->fromArray($array);
        });

      })->export('xlsx');
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
      $pos = strrpos($status, ',');

      if($pos !== false)
      {
        $status = substr_replace($status, '.', $pos, strlen(','));
      }

      session(['status' => $status]);

      return view('admin.student-view', ['student' => $student]);
    }

    public function update_student(Request $request, $id)
    {
      $student = Student::findOrFail($id);

      foreach($request->get('attributes') as $attrID => $attribute)
      {
        $newStatus = $attribute['status'];

        $attribute = Attribute::findOrFail($attrID);

        if(isset($newStatus['id']))
        {
          //Add status using id
          $status = Status::findOrFail($newStatus['id']);
        }
        else if(isset($newStatus['value']))
        {
          //Add status with a value
          $status = Status::where('code', $attribute->code . '-fillable')->where('attribute_id', $attribute->id)->firstOrFail();
        }
        else
          continue; //No value uploaded. Leave blank

        if(isset($newStatus['message']))
        {
          if($attribute->is_info == 1)
            $sync = [$status->id => ['value' => $newStatus['value'], 'message' => $newStatus['message']]];
          else
            $sync = [$status->id => ['message' => $newStatus['message']]];

        }
        else
        {
          if($attribute->is_info == 1)
            $sync = [$status->id => ['value' => $newStatus['value']]];
          else
            $sync = [$status->id];
        }

        //If there is a curret status, remove it
        $removeStatuses = $student->statuses()->where('attribute_id', $attribute->id)->pluck('statuses.id')->toArray();
        if(!empty($removeStatuses))
          $student->statuses()->detach($removeStatuses);

        //Add the new status
        $student->statuses()->sync($sync, false);
        $student->save();
      }

      $status = "Successfully updated! ";

      return redirect()->route('admin.view-students', $student->id)->with(['status' => $status]);
    }

    //This function could use some seperating into functions, so we can use them above
    public function upload(Request $request)
    {
      // May need longer than 30 seconds for large excel files
      ini_set('max_execution_time', 300); //300 seconds = 5 minutes

      if($request->file('sheet')->isValid())
      {
        Storage::put('file.temp', file_get_contents($_FILES['sheet']['tmp_name']));

        $reader = Excel::load('storage/app/file.temp', function($reader) {})->get();
        // ->all() is a wrapper for ->get() and will work the same
        $results = $reader->all();
        $row = 0;

        //Loop through each row
        foreach($results as $result)
        {
          $row++;

          //Find the student associated
          if(!isset($result->uid) && !isset($result->netid))
          {
            //NOTE: Need to throw an error here
            $errors = ['Could not find uid or netid for row:' . $row];
            return view('admin.upload', ['errors' => $errors]);
          }
          $uid = $result->uid;

          if($uid == null)
          {
            //If uid failed, try netid
            $netid = $result->netid;

            if($netid == null)
            {
              //NOTE: Need to throw an error here
              $errors = ['Could not locate student. NetID and UID were not provided. Row: ' . ($row)];

              return view('admin.upload', ['errors' => $errors]);
            }

            //Process using netid, UID is required to create
            $student = Student::where('netid', $netid)->first();

            if($student == null)
            {
              //NOTE: Need to throw an error here
              $errors = ['Could not locate student. NetID does not match any on record. Row: ' . ($row)];

              return view('admin.upload', ['errors' => $errors]);
            }
          }
          else
          {
            if(!preg_match('/[U]{1}\d{8}/', $uid))
            {
              //NOTE: Need to throw an error here
              $errors = ['Incorrectly formatted UID '.$uid.'. Row: ' . ($row)];

              return view('admin.upload', ['errors' => $errors]);
            }

            //Process using UID
            $student = Student::where('UID', $uid)->firstOrCreate(['UID' => $uid]);
          }

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
                {
                  $newType = StudentType::where('code', $type)->value('id');
                  if($newType == null)
                  {
                    //NOTE: Need to throw an error here
                    $errors = ['Could not locate student type with code:'. $type .' . Row: ' . ($row)];

                    return view('admin.upload', ['errors' => $errors]);
                  }
                  $studentType[] = $newType;
                }
              }

              $newType = StudentType::where('code', 'ALL')->value('id');
              if($newType == null)
              {
                //NOTE: Need to throw an error here
                $errors = ['The ALL student type cannot be found! Please add this student type back, or contact UGS web for assistance.'];

                return view('admin.upload', ['errors' => $errors]);
              }
              $studentType[] = $newType;

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
            $attribute = Attribute::where('code', $key)->first();

            if($attribute == null)
            {
              //NOTE: Error. Bad attribute found.
              $errors = ['Could not find an attribute with the code: ' . $key];

              return view('admin.upload', ['errors' => $errors]);
            }

            if($value == null || $value == '') continue; //Skip if blank

            //If this is a fillable status, fill it!
            if($attribute->is_info == 1)
            {
              $status = Status::where('code', $attribute->code . '-fillable')->where('attribute_id', $attribute->id)->first();
            }
            else
              $status = Status::where('code', $value)->where('attribute_id', $attribute->id)->first();

            if($status == null)
            {
              //NOTE: Error. Bad attribute found.
              $errors = ['Could not find a status with the code ' . $value . ' for attribute ' . $attribute->name . ' at row:  ' . ($row)];

              return view('admin.upload', ['errors' => $errors]);
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
              //Student was just created. Add the ALL student type, if not added earlier
              $newType = StudentType::where('code', 'ALL')->first();

              if($newType == null)
              {
                //NOTE: Need to throw an error here
                $errors = ['The ALL student type cannot be found! Please add this student type back, or contact UGS web for assistance.'];

                return view('admin.upload', ['errors' => $errors]);
              }

              $student->student_types()->attach($newType);
            }

            //Add the new status
            $student->statuses()->sync($sync, false);
          }
          $student->save(); // Save all changes
        }
      }

      return view('admin.admin', ['success' => 'Upload successfull!']);
    }
}
