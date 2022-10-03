<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use App\Http\Controllers\PostsController;
use App\Http\Controllers\UserController;

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
$router->get('/posts', 'PostsController@index');
$router->post('/posts/save', 'PostsController@store');
$router->get('/posts/{id}', 'PostsController@edit');
$router->put('/posts/save/{id}', 'PostsController@update');
$router->delete('/posts/delete/{id}', 'PostsController@destroy');

$router->post('/register', 'UserController@register');
$router->post('/login', 'UserController@login');
