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

Route::any('/', 'HomeController@showWelcome');
Route::get('/home/check', ['as' => 'home.check', 'uses' => 'HomeController@check']);
Route::get('/home/macro', ['as' => 'home.macro', 'uses' => 'HomeController@macro']);

// we can use pattern based filters using Route::when('admin/*', filtername) and Route::when('admin/*', filtername, ['post]) to specify if url has admin and not matter what it has after admin or if type is post along with admin th only this filter will get applied

//Route::get('/', function()
//{
//	return View::make('hello');
//});

// we can bind route parameters with call backs and then do anything to them using Route::bind method

Route::pattern('id', '[0-9]+');

Route::get("use/{id}", "UseController@getIndex") -> where('id', '^[0-9]+$');
Route::controller('use', 'UseController'); // implicit controller
Route::controller('impl.post', 'UseController'); // implicit controller

Route::get('getCookieResponse', "HomeController@returnCookieResponse");
Route::get('getLetter/admin/{function}/{id?}', array("uses" => "HomeController@getLetter", "as" => "letter.receive")); /// the controller action receives the arguments based on the action argument names.
Route::post('postLetter', array("uses" => "HomeController@postLetter", "as" => "letter.send", 'prefix' => 'admin'));

Route::get('download', 'HomeController@download');

Route::get('useBlade', 'HomeController@useBladeProfiles');

Route::get('useControllerBladeProfiles', 'HomeController@useControllerBladeProfiles');

Route::model('user', 'User');
Route::get('get/user/{user}', 'HomeController@user');

//Route::match(array('get', 'post'), 'get/filters/{user}', array('before' => 'customFilter', 'uses' => 'HomeController@user'));

Route::get('filterFunctionCallCheck', 'HomeController@filterFunctionCallCheck');

// cannot resolve and inject classes and objects in method calls unless its something internal to laravel in which it knows that it has to pass that value to callback function. Like filters and events
Route::get('checkIOCFunctionInjection', 'HomeController@checkIOCFunctionInjection');

Route::get('fireEvent', 'HomeController@fireEvent');

Route:: get('storeCache', 'HomeController@storeCache');

Route::get('sendMail', "HomeController@sendMail");

Route::get('pullLang', 'HomeController@pullLang');

Route::get('validation', 'HomeController@validation');

Route::get('displayValidationErrors', 'HomeController@displayValidationErrors');
Route::get('fireJobs', 'HomeController@fireJobs');

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

Route::get('getRemind', 'RemindersController@getRemind');
Route::get('runQuery', 'HomeController@db');
Route::get('nestedtransactions', 'HomeController@nestedtransactions');
Route::get('queryBuild', 'HomeController@queryBuild');
Route::get('createSchema', 'HomeController@createSchema');
Route::get('modelQueryUsers', 'HomeController@modelQueryUsers');
Route::get('modelQueryDuplicates', 'HomeController@modelQueryDuplicates');
Route::get('createModel', 'HomeController@createModel');
Route::get('callJmin', 'HomeController@callJmin');
Route::put('callJmin', 'HomeController@callJmin');
Route::delete('callJmin', 'HomeController@callJmin');
Route::options('callJmin', 'HomeController@callJmin');
Route::patch('callJmin', 'HomeController@callJmin');
Route::get('redirectTo', 'HomeController@redirectTo');
Route::resource('user.post', "ResourceController");
Route::resource('index', "HomeController@index");
Route::get('relationships', "HomeController@relationships");