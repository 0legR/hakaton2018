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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('auth', 'API\UserController@store');
Route::get('loggin', 'API\UserController@loggin');
Route::resource('vacancies', 'API\VacancyController', ['only' => ['index', 'store', 'update', 'destroy']]);
Route::resource('questions', 'API\QuestionController', ['only' => ['index', 'store', 'update', 'destroy']]);


