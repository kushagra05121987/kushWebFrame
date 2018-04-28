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
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('checkAuth', 'HomeTownController@checkAuth') -> middleware('auth');
Route::get('checkAuths', 'HomeTownController@queryingDB') -> middleware('can:update, App\Post');
Route::get('checkAuthBlade', 'HomeTownController@checkAuthBlade');

//Route::controller('impl', 'HomeController'); Non implicit controllers in 5.5 or after 5.3

Route::get('api/createAuthClient', 'HomeTownController@createClient');



Route::get('requestToken', function () {
    $http = new GuzzleHttp\Client;
    $response = $http->post('http://laravel.test.v5:8080/oauth/token', [
        'form_params' => [
            'grant_type' => 'password',
            'client_id' => '2',
            'client_secret' => 'JJofxOPwvx75PT4gIrVdAB1mXTuV2yNApHfLxLdy',
            'username' => 'karizmatic.kay@gmail.com',
            'password' => '123456',
            'scope' => '*',
        ],
    ]);
    return json_decode((string) $response->getBody(), true);
});
Route::get('createPersonalToken', function () {
    $user = App\User::find(24);

// Creating a token without scopes...
    $token = Auth::user()->createToken('TokenName')->accessToken;
    dd($token);
});

Route::get('/redirect', function () {
    $query = http_build_query([
        'client_id' => '4',
        'redirect_uri' => 'http://laravel.test.v5:8080/auth/callback',
        'response_type' => 'code',
        'scope' => '*',
    ]);

    return redirect('http://laravel.test.v5:8080/oauth/authorize?'.$query);
});

Route::get('auth/callback', function(\Illuminate\Http\Request $request) {
//    dd($request -> code);
    if($request -> has('code')) {
        $http = new GuzzleHttp\Client;
        $response = $http->post('http://laravel.test.v5:8080/oauth/token', [
            'form_params' => [
                'grant_type' => 'authorization_code',
                'client_id' => '4',
                'client_secret' => 'doSVVJAsuXv2tOC2KD4Jh1jb7rA5NefwrkElUKa5',
                'code' => $request -> code,
                'redirect_uri' => 'http://laravel.test.v5:8080/auth/callback',
            ],
        ]);
        return json_decode((string) $response->getBody(), true);
    } else {
        echo "hello";exit;
    }

});

