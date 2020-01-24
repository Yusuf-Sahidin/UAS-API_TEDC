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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

//users routes
$router -> get('/users', 'UsersController@index');
$router -> post('/users', 'UsersController@store');
$router -> get('/user/{id_user}', 'UsersController@show');
$router -> put('/user/{id_user}', 'UsersController@edit');
$router -> delete('/user/{id_user}', 'UsersController@destroy');

//auth
$router -> group(['prefix' => 'auth'], function () use ($router){
    $router -> post('/register', 'AuthController@register');
    $router -> post('/login', 'AuthController@login');
});