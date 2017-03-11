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
Route::get('/logout', function () {})->name('logout'); //logout

Route::group(['middleware' => 'auth.student'], function() {
  //Home route. If student, load their view. If admin, redirect to admin.
  Route::get('/', function () {

    $student = App\Student::where('netid', Auth::user()->netid)->first();

    //Else if student
    return view('student.student', ['student' => $student]);
  })->name('student.index');
});

Route::group(['middleware' => 'auth.admin'], function() {
  Route::group(['prefix' => '/admin', ], function() {
      Route::get('/', function(){
        return view('admin.admin');
      })->name('admin.index');

      Route::get('/students', function(){return view('admin.students');})->name('admin.students');

      Route::get('/students/export', 'UploadController@export')->name('admin.export');

      Route::post('/students/export', 'UploadController@export')->name('admin.export');

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
