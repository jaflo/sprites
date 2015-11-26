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

Route::get('/', 'MostController@welcome');
Route::get('/home', 'MostController@home');
Route::get('/search', 'MostController@search');

Route::get('/upload', 'SpriteController@offerUpload');
Route::post('/upload', 'SpriteController@handleUpload');

Route::get('/sprite/redocolors', 'SpriteController@redoColors');
Route::get('/sprite/{spriteId}', 'SpriteController@show');
Route::get('/sprite/{spriteId}/remove', 'SpriteController@remove');
Route::get('/sprite/{spriteId}/edit', 'SpriteController@offerEdit');
Route::post('/sprite/{spriteId}/edit', 'SpriteController@handleEdit');
Route::get('/sprite/{spriteId}/download', 'SpriteController@download');
Route::get('/sprite/{spriteId}/unfavorite', 'SpriteController@unfavorite');
Route::get('/sprite/{spriteId}/favorite', 'SpriteController@favorite');

Route::get('/user/{userId}', 'UserController@showProfile');
Route::get('/user/me/edit', 'UserController@offerEdit');
Route::post('/user/me/edit', 'UserController@handleEdit');

Route::controllers([
	'auth' => 'Auth\AuthController',
	//'password' => 'Auth\PasswordController',
]);
