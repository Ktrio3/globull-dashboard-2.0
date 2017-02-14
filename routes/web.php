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

Route::get('/', function () {
    return view('welcome');
});

//===================================================================
// Public Site
//===================================================================
Route::group(['middleware' => 'auth.passive'], function () {
  Route::get('/', function () { return view('home', ['sticky_nav' => true]); }); //home

});

//===================================================================
// Authenticated Site
//===================================================================\
Route::group(['prefix' => '/dashboard'], function () {
  Route::get('/logout', function () {})->name('logout'); //logout

  Route::group(['prefix' => '/admin', ], function() {
      Route::get('/', function(){
        return view('admin.admin');
      })->name('admin.index');

      Route::resource('student-types', 'StudentTypeController');
      Route::resource('attributes', 'AttributeController');
      Route::resource('attribute-types', 'AttributeTypeController');

  });
});
