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
$router->group(['prefix' => 'api/seguroauto/v1'], function () use ($router) {
    $router->group(['prefix' => 'frontend'], function () use ($router) {
        $router->get('/brands', 'SeguroAuto\BrandController@index');

        $router->get('/vehicle-models', 'SeguroAuto\VehicleModelsController@index');

        $router->get('/model-years', 'SeguroAuto\ModelYearsController@index');

        $router->get('/insurance-companys', 'SeguroAuto\InsuranceCompanysController@index');
        
        $router->get('/veem-leads', 'SeguroAuto\VeemLeadsController@index');

        $router->get('/customer-researches', 'SeguroAuto\CustomerResearchesController@index');

        $router->get('/customer-researches/{id}', 'SeguroAuto\CustomerResearchesController@show');

        $router->post('/customer-researches', 'SeguroAuto\CustomerResearchesController@store');

        $router->put('/customer-researches/{id}', 'SeguroAuto\CustomerResearchesController@update');

        $router->get('/customer-research-answers', 'SeguroAuto\CustomerResearchAnswersController@index');

        $router->post('/customer-research-answers', 'SeguroAuto\CustomerResearchAnswersController@store');

        $router->put('/customer-research-answers/{id}', 'SeguroAuto\CustomerResearchAnswersController@update');

        $router->get('/customer-research-answers/{id}', 'SeguroAuto\CustomerResearchAnswersController@show');

        $router->get('/research-question', 'SeguroAuto\ResearchQuestionsController@index');
        $router->get('/research-question/{id}', 'SeguroAuto\ResearchQuestionsController@show');             
        $router->post('/research-question', 'SeguroAuto\ResearchQuestionsController@store');

        $router->get('/research-option', 'SeguroAuto\ResearchOptionsController@index');
        $router->get('/research-option/{id}', 'SeguroAuto\ResearchOptionsController@show');             
        $router->post('/research-option', 'SeguroAuto\ResearchOptionsController@store');

        $router->get('/research-answer', 'SeguroAuto\ResearchAnswersController@index');
        $router->get('/research-answer/{id}', 'SeguroAuto\ResearchAnswersController@show');             
        $router->post('/research-answer', 'SeguroAuto\ResearchAnswersController@store');        
    });
});
