<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//===================================================================
// Authenticated Site
//===================================================================\
Route::get('/user-not-found', function () {
  return view('student.student_not_found', ['errors' => ['No record currently entered for this NetID. If you believe this to be an error, please contact the office of orientation.']]);
})->name('user_not_found'); //logout

Route::group(['middleware' => 'auth.student'], function() {
  //Home route. If student, load their view. If admin, redirect to admin.
  Route::get('/', function () {
    $student = App\Student::where('uid', Auth::user()->UID)->first();

    if($student == null)
    {
      $student = App\Student::where('netid', Auth::user()->netid)->first();
    }

    //Else if student
    return view('student.student', ['student' => $student]);
  })->name('student.index');
});

use App\Database;

Route::get('/test', function (){
  $database = Database::findOrFail(1);
  $database->test();
});

Route::group(['middleware' => 'auth.admin'], function() {
  Route::get('/logout', function () {})->name('logout'); //logout

  Route::group(['prefix' => '/admin', ], function() {
      Route::get('/', function(){
        return view('admin.admin');
      })->name('admin.index');

      Route::get('/students', function(){return view('admin.students');})->name('admin.students');

      Route::get('/students/export', 'UploadController@export')->name('admin.export');

      Route::get('/databases', 'DatabaseController@index')->name('database.index');

      Route::get('/databases/create', 'DatabaseController@add')->name('database.create');

      Route::get('/databases/edit/{id}', 'DatabaseController@edit')->name('database.edit');

      Route::get('/databases/edit-attributes/{id}', 'DatabaseController@edit_attributes')->name('database.edit_attributes');

      Route::post('/databases/store', 'DatabaseController@store')->name('database.store');

      Route::post('/databases/update/{id}', 'DatabaseController@update')->name('database.update');

      Route::post('/databases/update-attributes/{id}', 'DatabaseController@update_attributes')->name('database.update_attributes');

      Route::post('/students/export', 'UploadController@doExport')->name('admin.export');

      Route::get('/students/{id}', function($id){

        $student = App\Student::findOrFail($id);

        $status = session()->get('status') . "Viewing student: " . $student->UID;
        session(['status' => $status]);

        if(Auth::user()->role->id < 5) //User is allowed to edit students
          return view('admin.student-edit', ['student' => $student]);
        else
          return view('admin.student-view', ['student' => $student]);
      })->name('admin.view-students');

      Route::post('/update-student/{id}', 'UploadController@update_student')->name('student.update');

      Route::get('/preview', 'UploadController@preview')->name('admin.preview');

      Route::post('/preview', 'UploadController@do_preview')->name('admin.preview');

      Route::get('/upload', 'UploadController@index')->name('admin.upload');

      Route::post('/upload', 'UploadController@upload')->name('admin.upload-run');

      Route::resource('student-types', 'StudentTypeController');
      Route::resource('attributes', 'AttributeController');
      Route::resource('attribute-types', 'AttributeTypeController');

      Route::group(['middleware' => 'auth.master'], function() {
        Route::resource('users', 'UserController');
      });

  });
});
