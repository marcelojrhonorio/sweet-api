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
$router->group(['prefix' => 'api/greenpeace-oceanos/v1'], function () use ($router) {
    $router->group(['prefix' => 'frontend'], function () use ($router) {
        $router->get('/research-question', 'GreenpeaceOceanos\ResearchQuestionsController@index');
        $router->get('/research-question/{id}', 'GreenpeaceOceanos\ResearchQuestionsController@show');             
        $router->post('/research-question', 'GreenpeaceOceanos\ResearchQuestionsController@store');

        $router->get('/research-option', 'GreenpeaceOceanos\ResearchOptionsController@index');
        $router->get('/research-option/{id}', 'GreenpeaceOceanos\ResearchOptionsController@show');             
        $router->post('/research-option', 'GreenpeaceOceanos\ResearchOptionsController@store');

        $router->get('/research-answer', 'GreenpeaceOceanos\ResearchAnswersController@index');
        $router->get('/research-answer/{id}', 'GreenpeaceOceanos\ResearchAnswersController@show');             
        $router->post('/research-answer', 'GreenpeaceOceanos\ResearchAnswersController@store');        
    });
});