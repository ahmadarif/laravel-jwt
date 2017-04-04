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

Route::group(['prefix' => '/auth'], function () {
    Route::post('/login', 'Auth\AuthenticateController@postLogin');
    Route::delete('/invalidate', 'Auth\AuthenticateController@deleteInvalidate');
    Route::patch('/refreshToken', 'Auth\AuthenticateController@patchRefreshToken');
    Route::get('/profil', 'Auth\AuthenticateController@getProfil');
});