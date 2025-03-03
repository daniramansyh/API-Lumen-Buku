<?php

/** @var \Laravel\Lumen\Routing\Router $router */


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

$router->post('/register', 'AuthController@register');
$router->post('/login', 'AuthController@login');

$router->group(['middleware' => 'auth'], function () use ($router) {
    $router->post('/logout', 'AuthController@logout');
    $router->get('/profile', 'AuthController@profile');

    $router->group(['prefix' => 'authors'], function () use ($router) {
        $router->get('/', 'AuthorController@index');
        $router->post('/', 'AuthorController@create');
        $router->get('/{id}', 'AuthorController@detail');
        $router->patch('/{id}', 'AuthorController@update');
        $router->delete('/{id}', 'AuthorController@delete');
    });
    $router->group(['prefix' => 'publishers'], function () use ($router) {
        $router->get('/', 'PublisherController@index');
        $router->post('/', 'PublisherController@create');
        $router->get('/{id}', 'PublisherController@detail');
        $router->patch('/{id}', 'PublisherController@update');
        $router->delete('/{id}', 'PublisherController@delete');
    });
    $router->group(['prefix' => 'genres'], function () use ($router) {
        $router->get('/', 'GenreController@index');
        $router->post('/', 'GenreController@create');
        $router->get('/{id}', 'GenreController@detail');
        $router->patch('/{id}', 'GenreController@update');
        $router->delete('/{id}', 'GenreController@delete');
    });
    $router->group(['prefix' => 'books'], function () use ($router) {
        $router->get('/', 'BookController@index');
        $router->post('/', 'BookController@create');
        $router->get('/trash', 'BookController@getTrash');
        $router->get('/{id}', 'BookController@detail');
        $router->patch('/{id}', 'BookController@update');
        $router->delete('/{id}', 'BookController@delete');
        $router->get('/restore/{id}', 'BookController@restore');
        $router->delete('/delete/{id}', 'BookController@forceDelete');
    });
    $router->group(['prefix' => 'transactions'], function () use ($router) {
        $router->get('/', 'TransactionController@index');
        $router->post('/', 'TransactionController@create');
        $router->post('/return', 'TransactionController@returnBook');
        $router->get('/{id}', 'TransactionController@detail');
        $router->patch('/{id}', 'TransactionController@update');
        $router->delete('/{id}', 'TransactionController@delete');
    });
});