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


$router->post('/login', 'UserController@login');
$router->post('/register', 'UserController@register');
$router->get('/get-data-user', 'UserController@getDataUser');

// Post
$router->group(['prefix' => 'post'], function () use ($router) {
    $router->get('/', 'PostController@index');
    $router->post('/', 'PostController@create');
    $router->get('/{id}', 'PostController@show');
    $router->post('/{id}', 'PostController@update');
    $router->delete('/{id}', 'PostController@delete');
});

// Categories
$router->group(['prefix' => 'categories'], function () use ($router) {
    $router->get('/', 'CategoriesController@index');
    $router->post('/', 'CategoriesController@create');
    $router->get('/{id}', 'CategoriesController@show');
    $router->post('/{id}', 'CategoriesController@update');
    $router->delete('/{id}', 'CategoriesController@delete');
});

// Tag
$router->group(['prefix' => 'tag'], function () use ($router) {
    $router->get('/', 'TagController@index');
    $router->post('/', 'TagController@create');
    $router->get('/{id}', 'TagController@show');
    $router->post('/{id}', 'TagController@update');
    $router->delete('/{id}', 'TagController@delete');
});