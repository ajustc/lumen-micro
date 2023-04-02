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

// Order
$router->group(['prefix' => 'order'], function () use ($router) {
    $router->get('/', 'OrderController@index');
    $router->post('/', 'OrderController@create');
    $router->get('/{id}', 'OrderController@show');
    $router->post('/{id}', 'OrderController@update');
    $router->delete('/{id}', 'OrderController@delete');
});

// Order Detail
$router->group(['prefix' => 'order-detail'], function () use ($router) {
    $router->get('/', 'OrderDetailController@index');
    $router->post('/', 'OrderDetailController@create');
    $router->get('/{id}', 'OrderDetailController@show');
    $router->post('/{id}', 'OrderDetailController@update');
    $router->delete('/{id}', 'OrderDetailController@delete');
});

// Payment
$router->group(['prefix' => 'payment'], function () use ($router) {
    $router->get('/', 'PaymentController@index');
    $router->post('/', 'PaymentController@create');
    $router->get('/{id}', 'PaymentController@show');
    $router->post('/{id}', 'PaymentController@update');
    $router->delete('/{id}', 'PaymentController@delete');
});