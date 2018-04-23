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

//Route::get('/', function () {
//    return view('welcome');
//});

Auth::routes();

Route::get('/home/{user}/{age}', 'HomeController@index')  -> name('home');

Route::get('/homely', function() {
    dd(route('home', ['age' => 30]));
//    return redirect() ->route('home', ['age' => 30]);
}) -> middleware(\App\Http\Middleware\ApplicationTesting::class) ->name('home2');

Route::post ('validations', 'HomeController@validations');

Route::get('dbQuery', 'HomeController@dbQuery');
Route::get('schemaCreate', 'HomeController@schemaCreate');

Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');

Route::get('fire/{name}/{id}', 'HomeController@callFireDepartment')->name('app.utility.fire');

//Route::redirect('/redirect', '/fire', 301,  ['id' => "name", 'name' => 'Kushagra']);

Route::get('redirect', function() {
    echo "inside ";
    return redirect('fire', ['id'=>'Kushagra', 'name' => 12]) -> with( ['id'=>'Kushagra', 'name' => 12]);
});

Route::get('implicit', 'NHomeController');
Route::get('implicit2', 'NHomeController');

Route::resource('user', 'RHomeController');
Route::resource('user.postE', 'RHomeEController');

// or
Route::resources([
    'user' => 'RHomeController',
    'user.postE' => 'RHomeEController'
]);

Route::post('postIndex', 'HomeController@postIndex');


//Route::model('id', '\App\User');
Route::get('getUserByName/{user}', function(\App\User $user) {
    dd($user->name);
    dd($user->email);
})-> name('getuser');
Route::get('getUserName', function() {
    $user = \App\User::find(1);
//    dd($user->name);
    return redirect() -> route('getuser', [$user]);
});

//Route::get('queryingModel', 'HomeController@queryingModel');
Route::get('queryingDB', 'HomeTownController@queryingDB');
Route::get('getUserResources', 'HomeTownController@getUserResources');
Route::get('nm', 'HomeTownController@nm');