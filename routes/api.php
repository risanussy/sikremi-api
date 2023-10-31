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

Route::post('login', 'AuthController@login');

Route::apiResource('aplikasi', 'AplikasiController');
Route::get('lampiran/file/{id}/{file_name}', 'AplikasiController@picture');
Route::get('survey/file/{id}/{file_name}', 'SurveyController@picture');

Route::group([
    'middleware' => ['auth:api'],
], function() {

    /* AUTH */
    Route::get('logout', 'AuthController@logout');

    Route::apiResource('verifikasi', 'VerifikasiController');
    Route::apiResource('survey', 'SurveyController');
    Route::apiResource('approval', 'ApprovalController');
    Route::apiResource('user', 'UserController');

    
    Route::get('analytic/performance', 'AnalyticController@performance');

    /* SETTING */
    Route::get('setting/profile', 'SettingController@profile');
    Route::post('setting/change_password', 'SettingController@change_password');

});
