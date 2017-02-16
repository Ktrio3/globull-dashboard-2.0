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

    //Check if admin

    //Else if student
    return view('welcome');
  });
});

Route::group(['middleware' => 'auth.admin'], function() {
  Route::group(['prefix' => '/admin', ], function() {
      Route::get('/', function(){
        return view('admin.admin');
      })->name('admin.index');

      Route::resource('student-types', 'StudentTypeController');
      Route::resource('attributes', 'AttributeController');
      Route::resource('attribute-types', 'AttributeTypeController');

      Route::group(['middleware' => 'auth.master'], function() {
        Route::resource('users', 'UserController');
      });

  });
});
