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

//auth
$router -> group(['prefix' => 'auth'], function () use ($router){
    $router -> post('/register', 'AuthController@register');
    $router -> post('/login', 'AuthController@login');
});

$router -> group(['middleware' => ['auth']], function ($router){
    //users routes
    $router -> get('/users', 'UsersController@index');
    $router -> get('/user/{id}', 'UsersController@show');
    $router -> delete('/user/{id}', 'UsersController@destroy');

    //author info routes
    $router -> get('/authors', 'AuthorsController@index');
    $router -> get('/author/{id}', 'AuthorsController@show');
    $router -> post('/authors', 'AuthorsController@store');
    $router -> put('/author/{id}', 'AuthorsController@edit');
    $router -> delete('/author/{id}', 'AuthorsController@destroy');
});