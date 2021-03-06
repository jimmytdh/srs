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

Route::get('/test',function (){
    return view('signature');
});
Route::get('/','HomeController@index');

Route::get('/login','MainController@login');
Route::post('/login','MainController@validateLogin');
Route::get('logout',function(){
    \Illuminate\Support\Facades\Session::flush();
    \Illuminate\Support\Facades\Auth::logout();
    return redirect('/login');
});
//Manage Charts and Calendar
Route::get('/home/chart','HomeController@lineChart');



//Print Barcode
Route::get('/pdf/track','PrintController@printTrack');

//Manage Profile
Route::get('/user/profile','UserController@profile');
Route::get('/user/signature','UserController@signature');
Route::post('/user/signature','UserController@saveSignature');
Route::post('/user/change/password','UserController@password');

//Events and my calendar
Route::get('/user/calendar','CalendarController@index');
Route::post('/user/calendar/save','CalendarController@save');
Route::get('/user/calendar/edit/{id}','CalendarController@edit');
Route::post('/user/calendar/update/{id}','CalendarController@update');
Route::get('/user/calendar/delete/{id}','CalendarController@delete');

Route::get('/user/events','CalendarController@events');
Route::get('/user/events/personal','CalendarController@myCalendar');


//Manage Users
Route::get('admin/users','admin\UserController@index');
Route::post('admin/users/save','admin\UserController@save');
Route::get('admin/users/edit/{id}','admin\UserController@edit');
Route::post('admin/users/update/{id}','admin\UserController@update');

//Import Users
Route::get('/admin/users/import','admin\ImportController@index');

//Manage Designations
Route::get('/admin/designation','admin\DesignationController@index');
Route::post('/admin/designation/save','admin\DesignationController@save');
Route::get('/admin/designation/edit/{id}','admin\DesignationController@edit');
Route::get('/admin/designation/delete/{id}','admin\DesignationController@delete');
Route::post('/admin/designation/update/{id}','admin\DesignationController@update');
Route::post('/admin/designation/search','admin\DesignationController@search');

//Manage Division
Route::get('/admin/division','admin\DivisionController@index');
Route::post('/admin/division/save','admin\DivisionController@save');
Route::get('/admin/division/edit/{id}','admin\DivisionController@edit');
Route::get('/admin/division/delete/{id}','admin\DivisionController@delete');
Route::post('/admin/division/update/{id}','admin\DivisionController@update');
Route::post('/admin/division/search','admin\DivisionController@search');

//Manage Section
Route::get('/admin/section','admin\SectionController@index');
Route::post('/admin/section/save','admin\SectionController@save');
Route::get('/admin/section/edit/{id}','admin\SectionController@edit');
Route::get('/admin/section/delete/{id}','admin\SectionController@delete');
Route::post('/admin/section/update/{id}','admin\SectionController@update');
Route::post('/admin/section/search','admin\SectionController@search');


//ITEM SECTIONS

Route::get('/items','ItemController@index');
Route::post('/items/save','ItemController@save');
Route::get('/items/delete/{id}','ItemController@delete');
Route::get('/items/edit/{id}','ItemController@edit');
Route::post('/items/update/{id}','ItemController@update');
Route::post('/items/search','ItemController@search');

Route::post('/items/borrow','ItemController@borrow');
Route::post('/items/return','ItemController@returnItem');

//END ITEM SECTION

//START RESERVATION SECTION
Route::get('/reservation','ReservationController@index');
Route::post('/reservation/save','ReservationController@save');
Route::post('/reservation/update/{code}','ReservationController@save');
Route::post('/reservation/search','ReservationController@search');
Route::get('/reservation/edit/{code}','ReservationController@edit');

Route::get('/reservation/calendar','ReservationController@calendar');

Route::get('/reservation/change/date/{code}','ReservationController@changeDate');
Route::get('/reservation/cancel/{code}','ReservationController@cancel');
Route::get('/reservation/borrow/{code}','ReservationController@borrow');

Route::get('/reservation/available/{date}/{time_start}/{time_end}/{code}','ReservationController@checkAvailable');

//END RESERVATION SECTION

//START JOB SECTION

Route::get('/job','JobController@index');
Route::post('/job/save','JobController@save');
Route::post('/job/delete','JobController@delete');
Route::get('/job/edit/{id}','JobController@edit');
Route::post('/job/update/{id}','JobController@update');
Route::post('/job/search','JobController@search');
Route::get('/job/print','JobController@printReport');
Route::get('/job/print/{id}','JobController@printJobReport');
Route::get('/job/signature/{id}','JobController@signature');
Route::post('/job/signature/{id}','JobController@saveSignature');

Route::get('/job/services/{id}','JobController@editServices');
Route::post('/job/services/{id}','JobController@updateServices');

//END JOB SECTION

//START REQUEST
Route::get('/request','RequestController@jobRequest');
Route::post('/request','RequestController@jobRequest');
//END REQUEST

//START IP Section

Route::get('/ip/{range}','IPController@index');
Route::post('/ip/update/{type}/{id}','IPController@update');
Route::post('/ip/search/{type}','IPController@search');

//END IP Section

//START TASK SECTION

Route::get('/tasks','TaskController@index');
Route::post('/tasks/save','TaskController@store');
Route::get('tasks/edit/{id}','TaskController@edit');
Route::post('tasks/update/{id}','TaskController@update');
Route::post('tasks/delete','TaskController@destroy');
Route::post('tasks/search','TaskController@search');
//END TASK SECTION

//PARAM
Route::get('/param/clear/{session}','ParamController@clearSession');
Route::get('/loading','ParamController@loading');

Route::get('/manual/lastFriday','ParamController@lastFriday');
Route::get('/manual/thirdWed','ParamController@thirdWed');


Route::get('/send','FcmController@sendMessage');