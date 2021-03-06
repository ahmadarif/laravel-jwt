<?php

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

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', [
    'namespace' => 'App\Http\Controllers',
    'middleware' => 'api.throttle',
    'limit' => 100,
    'expires' => 1
], function ($api) {
    $api->group(['prefix' => '/auth'], function ($api){
        $api->post('/login', 'Auth\AuthenticateController@postLogin');

        $api->group(['middleware' => 'api.auth', 'providers' => 'jwt'], function ($api) {
            $api->patch('/refreshToken', 'Auth\AuthenticateController@patchRefreshToken');
            $api->delete('/invalidate', 'Auth\AuthenticateController@deleteInvalidate');
            $api->get('/profil', 'Auth\AuthenticateController@getProfil');
        });
    });
});