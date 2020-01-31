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
    $router -> delete('/author/{id}', 'AuthorsController@destroy');

    //list daftar bacaan routes
    $router -> get('/dafbas', 'DaftarController@index');
    $router -> get('/dafba/{id}', 'DaftarController@show');
    $router -> post('/dafbas', 'DaftarController@store');
    $router -> put('/dafba/{id}', 'DaftarController@edit');
    $router -> delete('/dafba/{id}', 'DaftarController@destroy');

    //isi bacaan routes
    $router -> get('/isii', 'IsiController@index');
    $router -> get('/isi/{id}', 'IsiController@show');
    $router -> post('/isii', 'IsiController@store');
    $router -> put('/isi/{id}', 'IsiController@edit');
    $router -> delete('/isi/{id}', 'IsiController@destroy');

    //baca nanti routes
    $router -> get('/nantis', 'NantiController@index');
    $router -> get('/nanti/{id}', 'NantiController@show');
    $router -> post('/nantis', 'NantiController@store');
    $router -> delete('/nanti/{id}', 'NantiController@destroy');
});