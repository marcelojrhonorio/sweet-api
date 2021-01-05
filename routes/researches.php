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
$router->group(['prefix' => 'api/researches/v1'], function () use ($router) {
    $router->group(['prefix' => 'frontend'], function () use ($router) {
        $router->get('/customer/{id}', 'CustomersController@findById');
        $router->post('/customer/update-points', 'CustomersController@updateCustomerPoints');

        $router->get('/option', 'Researches\OptionController@index');
        $router->get('/option/{id}', 'Researches\OptionController@show');             
        $router->post('/option', 'Researches\OptionController@store');

        $router->get('/researche', 'Researches\ResearcheController@index');
        $router->get('/researche/{id}', 'Researches\ResearcheController@show');              
        $router->get('/researche/verify-url/{url}', 'Researches\ResearcheController@verifyUrl');             
        $router->get('/researche/verify/url/', 'Researches\ResearcheController@verify');             
        $router->post('/researche', 'Researches\ResearcheController@store');
        $router->post('/researche/{id}', 'Researches\ResearcheController@delete');

        $router->get('/researche-question', 'Researches\ResearcheQuestionController@index');
        $router->get('/researche-question/{id}', 'Researches\ResearcheQuestionController@show');             
        $router->get('/researche-question/get-research-question/{research_id}', 'Researches\ResearcheQuestionController@getResearchQuestion');             
        $router->post('/researche-question', 'Researches\ResearcheQuestionController@store');
        $router->post('/researche-question/{id}', 'Researches\ResearcheQuestionController@delete');
        $router->post('/researche-question/remove/{id}', 'Researches\ResearcheQuestionController@remove');
        $router->put('/researche-question/{id}', 'Researches\ResearcheQuestionController@update');
        
        $router->get('/question', 'Researches\QuestionController@index');
        $router->get('/question/{id}', 'Researches\QuestionController@show');             
        $router->post('/question', 'Researches\QuestionController@store');

        $router->get('/question-option', 'Researches\QuestionOptionController@index');
        $router->get('/question-option/order', 'Researches\QuestionOptionController@order');
        $router->get('/question-option/{id}', 'Researches\QuestionOptionController@show');             
        $router->get('/question-option/get-question-option/{questions_id}', 'Researches\QuestionOptionController@getQuestionOption');             
        $router->get('/question-option/get-question-option-by-option/{options_id}', 'Researches\QuestionOptionController@getQuestionOptionByOption');             
        $router->post('/question-option', 'Researches\QuestionOptionController@store');        

        $router->get('/researche-answer', 'Researches\ResearcheAnswerController@index');
        $router->get('/researche-answer/{id}', 'Researches\ResearcheAnswerController@show');             
        $router->post('/researche-answer', 'Researches\ResearcheAnswerController@store');
        $router->post('/researche-answer/store', 'Researches\ResearcheAnswerController@insertAnswers');
        $router->post('/researche-answer/update', 'Researches\ResearcheAnswerController@updateAnswers');

        $router->get('/middle-page', 'Researches\MiddlePageController@index');
        $router->get('/middle-page/{id}', 'Researches\MiddlePageController@show');             
        $router->post('/middle-page', 'Researches\MiddlePageController@store');

        $router->get('/researches-middle-page', 'Researches\ResearchesMiddlePageController@index');
        $router->get('/researches-middle-page/{id}', 'Researches\ResearchesMiddlePageController@show');             
        $router->get('/researches-middle-page/get-research-middle-page/{researches_id}', 'Researches\ResearchesMiddlePageController@getResearchMiddlePage');             
        $router->post('/researches-middle-page', 'Researches\ResearchesMiddlePageController@store');

        $router->get('/customer_researches', 'Researches\CustomerResearchController@index');
        $router->get('/customer_researches/{id}', 'Researches\CustomerResearchController@show');             
        $router->post('/customer_researches/verify', 'Researches\CustomerResearchController@verify');
        $router->post('/customer_researches', 'Researches\CustomerResearchController@store');
    });
});