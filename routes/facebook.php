<?php
/**
 * Created by PhpStorm.
 * User: smithjunior
 * Date: 29/10/18
 * Time: 18:39
 */
$router->group(['prefix' => 'webhook/facebook'], function () use ($router) {
    $router->get('/', 'Facebook\FacebookMessengerController@validateToken');
    $router->post('/', 'Facebook\FacebookMessengerController@postMessage');
});
