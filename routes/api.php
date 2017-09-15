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

Route::group(['middleware' => 'auth:api', 'prefix' => 'players'], function () {
    Route::get('/', 'PlayerController@index');
    Route::get('/{id}', 'PlayerController@getByID');
    Route::get('/{id}/teams', 'PlayerController@getTeams');
    Route::get('/{id}/goals', 'PlayerController@getGoals');
    Route::get('/{id}/assists', 'PlayerController@getAssists');
    Route::post('/', 'PlayerController@savePlayer');
    Route::delete('/{id}', 'PlayerController@deletePlayer');
});

Route::group(['middleware' => 'auth:api', 'prefix' => 'matches'], function () {
    Route::get('/', 'MatchController@index');
    Route::get('/{id}', 'MatchController@getByID');
    Route::get('/{id}/teams', 'MatchController@getTeams');
    Route::get('/{id}/round', 'MatchController@getRound');
    Route::get('/{id}/goals', 'MatchController@getGoals');
    Route::get('/season/{season}', 'MatchController@getBySeason');
    Route::post('/', 'MatchController@saveMatch');
    Route::put('/{id}', 'MatchController@updateMatch');
    Route::delete('/{id}', 'MatchController@deleteMatch');
});

Route::group(['middleware' => 'auth:api', 'prefix' => 'teams'], function () {
    Route::get('/', 'TeamController@index');
    Route::get('/{id}', 'TeamController@getByID');
    Route::get('/season/{season}', 'TeamController@getBySeason');
    Route::get('/{id}/players', 'TeamController@getPlayers');
    Route::get('/{id}/goals', 'TeamController@getGoals');
    Route::get('/{id}/matches', 'TeamController@getMatches');
    Route::get('/{id}/assists', 'TeamController@getAssists');
    Route::post('/', 'TeamController@saveTeam');
    Route::delete('/{id}', 'TeamController@deleteTeam');
});

Route::group(['middleware' => 'auth:api', 'prefix' => 'rounds'], function () {
    Route::get('/', 'RoundController@index');
    Route::get('/{id}', 'RoundController@getByID');
    Route::get('/season/{season}', 'RoundController@getBySeason');
    Route::post('/', 'RoundController@saveRound');
    Route::put('/{id}', 'RoundController@updateRound');
    Route::delete('/{id}', 'RoundController@deleteRound');
});

Route::group(['middleware' => 'auth:api', 'prefix' => 'seasons'], function () {
    Route::get('/', 'SeasonController@index');
    Route::get('/{id}', 'SeasonController@getByID');
    Route::get('/{id}/rounds', 'SeasonController@getRounds');
    Route::get('/{id}/teams', 'SeasonController@getTeams');
    Route::post('/', 'SeasonController@saveSeason');
    Route::put('/{id}', 'SeasonController@updateSeason');
    Route::delete('/{id}', 'SeasonController@deleteSeason');
});

Route::group(['middleware' => 'auth:api', 'prefix' => 'goals'], function () {
    Route::get('/', 'GoalController@index');
    Route::get('/{id}', 'GoalController@getByID');
    Route::get('/{id}/team', 'GoalController@getTeam');
    Route::get('/{id}/player', 'GoalController@getPlayer');
    Route::get('/{id}/match', 'GoalController@getMatch');
    Route::get('/{id}/assist', 'GoalController@getAssist');
    Route::post('/', 'GoalController@saveGoal');
    Route::delete('/{id}', 'GoalController@deleteGoal');
});

Route::group(['middleware' => 'auth:api', 'prefix' => 'assists'], function () {
    Route::get('/', 'AssistController@index');
    Route::get('/{id}', 'AssistController@getByID');
    Route::get('/{id}/team', 'AssistController@getTeam');
    Route::get('/{id}/player', 'AssistController@getPlayer');
    Route::get('/{id}/match', 'AssistController@getMatch');
    Route::get('/{id}/goal', 'AssistController@getGoal');
    Route::post('/', 'AssistController@saveAssist');
    Route::delete('/{id}', 'AssistController@deleteAssist');
});

Route::group(['prefix' => 'auth'], function () {
    Route::post('/token', 'Auth\DefaultController@authenticate');
    Route::post('/refresh', 'Auth\DefaultController@refreshToken');
    Route::post('/register', 'Auth\DefaultController@register');
    Route::post('/email', 'Auth\ForgotPasswordController@getResetToken');
    Route::post('/reset', 'Auth\ResetPasswordController@reset');
});
