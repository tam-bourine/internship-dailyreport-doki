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

// USER
Route::middleware('api')->post('login', 'Api\LoginController@login');
Route::group(['middleware' =>['auth:api']], function(){
    Route::resource('users', 'Api\UserController', ['except' => ['create', 'edit', 'store', 'show']]);
});
Route::middleware('api')->post('users', 'Api\UserController@store');
Route::middleware('auth:api')->get('user', 'Api\UserController@show');
Route::middleware('auth:api')->post('users/{user}/comment', 'Api\UserController@registerComment');
Route::middleware('auth:api')->get('users/{id}', 'Api\UserController@show_by_id');


// POST
Route::group(['middleware' =>['auth:api']], function(){
    Route::resource('posts', 'Api\PostController', ['except' => ['create', 'edit']]);
});

// LIKE
Route::middleware('auth:api')->post('posts/{post}/likes/{user_id}', 'Api\LikesController@store');
Route::middleware('auth:api')->delete('posts/{post}/likes/{user_id}', 'Api\LikesController@destroy');

// TAG
Route::middleware('auth:api')->get('tags', 'Api\TagController@index');
Route::middleware('auth:api')->post('posts/{post}/tags', 'Api\TagController@store');
Route::middleware('auth:api')->get('tags/{tag}', 'Api\TagController@show');
Route::middleware('auth:api')->delete('tags/{tag}', 'Api\TagController@destroy');
