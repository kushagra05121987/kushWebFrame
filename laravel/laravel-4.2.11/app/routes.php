<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', 'HomeController@showWelcome');
Route::get('/home/check', ['as' => 'home.check', 'uses' => 'HomeController@check']);
Route::get('/home/macro', ['as' => 'home.macro', 'uses' => 'HomeController@macro']);

// we can use pattern based filters using Route::when('admin/*', filtername) and Route::when('admin/*', filtername, ['post]) to specify if url has admin and not matter ehat it has after admin or if type is post along with admin th only this filter will get applied

//Route::get('/', function()
//{
//	return View::make('hello');
//});

// we can bind route parameters with call backs and then do anything to them using Route::bind method

Route::pattern('id', '[0-9]+');

Route::get("use/{id}", "UseController@getIndex") -> where('id', '^[0-9]+$');
Route::controller('use', 'UseController'); // implicit controller


//Route::resource('user', 'UserController'); /// resource full controller

Route::group(['prefix' => "admin"], function() {
    Route::resource('photo', 'PhotoController'); /// resource full controller
});

Route::resource('user', 'UserController', array("only" => ['index', 'show'])); /// resource full controller

Route::resource('page', 'PageController', array("except" => ['index'])); /// resource full controller

// resource controllers have names attaches to all the routes for actions such as photo.create we can replace these by using
//Route::resource('photo', 'PhotoController', ['names' => ["create" => "photo.build"]]);

// Response and Redirect can be used with 'with' clause so if we need to send cookie with response then we can use Response::make('hello', 200) -> wihCookie(Cookie::make('name', 'value', 3600));
// if we want to send input with response ( May be used in case when form validation fails and we need to return back the data ) Redirect::to('form') -> withInput(Input::flash()); or Redirect::to('form') -> withInput(Input::flashOnly('name')) or Redirect::to('form') -> withInput(Input::flashExcept('name'))
// this flash data is available only until next request comes in and overrights this old data.
// so now if something has been sent using flash method or a request arrives with flash data then controller maybe able to access that data using Input::old()
// we flash the input to session using Input::flash()