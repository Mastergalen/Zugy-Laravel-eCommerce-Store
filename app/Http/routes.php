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
    return view('pages.home');
});

Route::get('product', function () {
    return view('pages.product');
});

Route::group(['prefix' => 'auth'], function () {
    Route::get('login', ['as' => 'login', 'uses' => 'Auth\AuthController@login']);
    Route::get('login/facebook', 'Auth\AuthController@facebookLogin');
    Route::get('login/google', 'Auth\AuthController@googleLogin');
    Route::get('login/twitter', 'Auth\AuthController@twitterLogin');

    Route::get('logout', ['uses' => 'Auth\AuthController@getLogout']);
});

Route::group(['prefix' => 'your-account', 'middleware' => 'auth'], function () {
    Route::get('', ['as' => 'your-account',function() {
        return view('pages.account.home');
    }]);
});

Route::get('test', function() {
    //
});
