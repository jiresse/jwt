<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(array('prefix' => 'api/v1'), function()
    {
        Route::post('register', 'TokenAuthController@register');
        Route::post('login', 'TokenAuthController@authenticate');
        Route::get('logged/user', 'TokenAuthController@getAuthenticatedUser');
        Route::resource('todo', 'TodoController');
    
    });

