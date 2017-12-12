<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$app->get('/', function () use ($app) {
    return $app->version();
});

$app->group(['prefix' => 'api/'], function() use ($app) {
    $app->post('login', 'UserController@authenticate');
    $app->post('user', 'UserController@create');
    $app->post('sync', 'UserController@sync');

    $app->group(['middleware' => ['auth:api']], function() use ($app) {
        $app->put('user', 'UserController@update');
        $app->put('ability', 'AbilityController@update');
    });
});