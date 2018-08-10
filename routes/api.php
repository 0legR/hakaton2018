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

//curl -XGET "http://php_server.ua/api/loggin" -H 'Accept: application/json'
// curl -XGET "http://php_server.ua/api/loggin" -H 'Accept: application/json' -d 'password=123123,email=serg@gmail.com'
Route::group(['middleware' => ['requestNotEmpty']], function() {
	Route::get('loggin', 'API\UserController@loggin');
	Route::post('auth', 'API\UserController@store');
});

Route::group(['middleware' => ['auth:api', 'requestNotEmpty']], function() {
	Route::resource('vacancies', 'API\VacancyController', ['except' => ['create']]);
	Route::resource('questions', 'API\QuestionController', ['except' => ['create']]);
	Route::resource('results', 'API\ResultController', ['only' => ['index', 'store']]);
	Route::resource('companies', 'API\CompanyController', ['except' => ['create', 'show']]);
	Route::get('passed_result', 'API\ResultController@isUserPassedTest');
	Route::resource('orders', 'API\OrderController', ['except' => ['create', 'show']]);
	Route::resource('scores', 'API\ScoreController', ['only' => ['index']]);
	// test
	// Route::post('details', 'API\UserController@details');
});

//curl -XGET "http://php_server.ua/api/todos" -H 'Accept: application/json'
// Route::get('todos', 'TodoController')->middleware('auth:api');

// Route::post('login', 'API\UserController@login');
// Route::post('register', 'API\UserController@register');
