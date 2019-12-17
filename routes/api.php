<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\LoginController;
use Illuminate\Support\Str;

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

Route::middleware('auth:api')->get('/user', 'Api\UserController@show');

Route::group(['middleware' =>['auth:api']], function(){
    Route::resource('posts', 'Api\PostController', ['except' => ['create', 'edit']]);
});

Route::group(['middleware' =>['auth:api']], function(){
    Route::resource('users', 'Api\UserController', ['except' => ['create', 'edit', 'store', 'show']]);
});

Route::middleware('api')->post('login', 'Api\LoginController@login');

Route::middleware('api')->post('users', 'Api\UserController@store');
