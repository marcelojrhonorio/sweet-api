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
$router->group(['prefix' => 'api/social-class/v1'], function () use ($router) {
    $router->group(['prefix' => 'frontend'], function () use ($router) {
        $router->get('/research-question', 'SocialClass\ResearchQuestionsController@index');
        $router->get('/research-question/{id}', 'SocialClass\ResearchQuestionsController@show');             
        $router->post('/research-question', 'SocialClass\ResearchQuestionsController@store');

        $router->get('/research-option', 'SocialClass\ResearchOptionsController@index');
        $router->get('/research-option/{id}', 'SocialClass\ResearchOptionsController@show');             
        $router->post('/research-option', 'SocialClass\ResearchOptionsController@store');

        $router->get('/research-answer', 'SocialClass\ResearchAnswersController@index');
        $router->get('/research-answer/{id}', 'SocialClass\ResearchAnswersController@show');             
        $router->post('/research-answer', 'SocialClass\ResearchAnswersController@store');

        $router->get('/final', 'SocialClass\FinalSocialClassesController@index');
        $router->get('/final/{id}', 'SocialClass\FinalSocialClassesController@show');             
        $router->post('/final', 'SocialClass\FinalSocialClassesController@store');    
        $router->put('/final/{id}', 'SocialClass\FinalSocialClassesController@update');
    });
});