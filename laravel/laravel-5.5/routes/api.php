<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::get('clientCreds', function() {
    $http = new GuzzleHttp\Client;
    $response = $http->post('http://laravel.test.v5:8080/oauth/token', [
        'form_params' => [
            'grant_type' => 'client_credentials',
            'client_id' => '4',
            'client_secret' => 'doSVVJAsuXv2tOC2KD4Jh1jb7rA5NefwrkElUKa5',
            'scope' => '*',
        ],
    ]);

    return json_decode((string) $response->getBody(), true)['access_token'];
});
Route::get('checkClientCreds', function() {
    echo "Hello";
})  -> middleware('client');