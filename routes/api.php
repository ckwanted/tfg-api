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

Route::group(['prefix' => 'v1'], function() {

    Route::group(['prefix' => 'auth'], function () {

        Route::post('login', 'AuthController@login');
        Route::post('register', 'AuthController@register');
        Route::post('logout', 'AuthController@logout')->middleware('auth:api');
        Route::post('refresh', 'AuthController@refresh')->middleware('auth:api');
        Route::post('me', 'AuthController@me')->middleware('auth:api');

    });

    // COURSES
    Route::get('courses/{course}', 'CourseController@show');
    Route::get('courses', 'CourseController@index');

    Route::group(['middleware' => 'auth:api'], function () {

        // USERS
        Route::get('users', 'UserController@index')->middleware('role:admin');
        Route::get('users/{user}', 'UserController@show')->middleware('role:admin');
        Route::put('users/{user}', 'UserController@update');
        Route::delete('users/{user}', 'UserController@destroy');

        // COURSES
        Route::post('courses', 'CourseController@store')->middleware('role:admin|teacher');
        Route::put('courses/{course}', 'CourseController@update')->middleware('role:admin|teacher');
        Route::delete('courses/{course}', 'CourseController@destroy')->middleware('role:admin|teacher');

    });

    // SEARCH
    Route::group(['prefix' => 'search'], function () {
        Route::post('course', 'SearchController@course');
    });

});
