<?php

$router->group(['middleware' => 'api-auth'], function () use ($router) {
    $router->post('/signup', 'SignupController@add');
});
