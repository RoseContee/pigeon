<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group([
    'namespace' => 'App\Http\Controllers\Api',
], function() {
    Route::get('words', 'ApiController@words');
    Route::get('apps', 'ApiController@apps');

    Route::get('get-token', 'ApiController@getToken');
    Route::post('auth-google', 'ApiController@authGoogle');
    Route::post('get-user-info', 'ApiController@getUserInfo');
    Route::post('add-guest', 'ApiController@addGuest');
    Route::post('create-zoom-link', 'ApiController@createZoomLink');
    Route::post('create-event', 'ApiController@createEvent');
});
