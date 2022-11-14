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

Route::prefix('communities',
['middleware' => 'api'])->group(function () {
    Route::post('/register', 'CommunityController@register');
    Route::post('/me', 'CommunityController@me');
});

Route::prefix('users',
['middleware' => 'api'])->group(function () {
    Route::post('/register', 'UserController@register');
    Route::post('/me', 'UserController@me');
});

Route::prefix('donations',
['middleware' => 'api'])->group(function () {
    Route::post('/donate/{id}', 'DonationController@donate');
    Route::post('/withdraw/{id}', 'DonationController@withdraw');
});

Route::prefix('auth',
['middleware' => 'api'])->group(function () {
    Route::post('/loginUser', 'AuthController@loginUser');
    Route::post('/loginCommunity', 'AuthController@loginCommunity');
    Route::post('/logout', 'AuthController@logout');
    Route::post('/refresh', 'AuthController@refresh');
    // Route::post('/me','AuthController@me');
});

Route::prefix('reports',
['middleware' => 'api'])->group(function () {
    Route::get('', 'ReportController@index');
    Route::post('', 'ReportController@store');
    Route::patch('/takeReport/{id}', 'ReportController@takeReport');
    Route::delete('{id}', 'ReportController@destroy');
});

Route::prefix('activities',
['middleware' => 'api'])->group(function () {
    Route::get('', 'ActivityController@index');
    // Route::post('', 'ReportController@store');
});

Route::prefix('usign',
['middleware' => 'api'])->group(function () {
    Route::post('/getToken', 'UsignController@getToken');
    Route::post('/signDocs/{id}', 'UsignController@signDocument');
    // Route::post('', 'ReportController@store');
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
