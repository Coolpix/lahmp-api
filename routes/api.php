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

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::group(['prefix' => 'players'], function () {
    Route::get('/', 'PlayerController@index');
    Route::get('/{id}', 'PlayerController@getByID');
    Route::get('/{id}/teams', 'PlayerController@getTeams');
});

Route::group(['prefix' => 'matches'], function () {
    Route::get('/', 'MatchController@index');
    Route::get('/{id}', 'MatchController@getByID');
    Route::get('/{id}/teams', 'MatchController@getTeams');
});

Route::group(['prefix' => 'teams'], function () {
    Route::get('/', 'TeamController@index');
    Route::get('/{id}', 'TeamController@getByID');
    Route::get('/year/{year}', 'TeamController@getByYear');
    Route::get('/{id}/players', 'TeamController@getPlayers');
});

Route::group(['prefix' => 'rounds'], function () {
    Route::get('/', 'RoundController@index');
    Route::get('/{id}', 'RoundController@getByID');
    /*Route::get('/year/{year}', 'TeamController@getByYear');
    Route::get('/{id}/players', 'TeamController@getPlayers');*/
});

Route::group(['prefix' => 'seasons'], function () {
    Route::get('/', 'SeasonController@index');
    /*Route::get('/{id}', 'TeamController@getByID');
    Route::get('/year/{year}', 'TeamController@getByYear');
    Route::get('/{id}/players', 'TeamController@getPlayers');*/
});
