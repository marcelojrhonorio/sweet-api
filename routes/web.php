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




$router->get('/', function () use ($router) {
   return 'SWEETMEDIA';
});

$router->get('/ambev/view-email', function() use ($router) {
    return view('emails.ambev.1');
});

$router->get('/ambev/sendmail', 'Ambev\SendAmbevEmailsController@send');

$router->group(['namespace' => '\Rap2hpoutre\LaravelLogViewer'], function() use ($router) {
    $router->get('logs', 'LogViewerController@index');
});

$router->group(['prefix' => 'api/v1'], function() use ($router) {
    $router->group(['prefix' => 'frontend'], function() use ($router) {
        $router->group(['prefix' => 'actions'], function () use ($router) {
            $router->get('/', 'ActionsController@index');
            $router->get('/getAllActions', 'ActionsController@getAllActions');
            $router->get('/type/{id}', 'ActionsController@getType');
            $router->get('/type-metas/{id}', 'ActionsController@getTypeMetas');
            $router->get('/show/{id}', 'ActionsController@showAction');
            $router->get('/categories', 'ActionsCategoryController@index');
            $router->get('/categories/{id}', 'ActionsCategoryController@show');
            $router->get('/categories/{id}/actions', 'ActionsController@listByCategory');
        });

        $router->group(['prefix' => 'customer-expired-points'], function() use ($router) {
            $router->get('/', 'CustomerExpiredPointsController@index');
            $router->get('/{id}', 'CustomerExpiredPointsController@show');
            $router->post('/', 'CustomerExpiredPointsController@store');
            $router->put('/{id}', 'CustomerExpiredPointsController@update');
        });

        $router->group(['prefix' => 'services-enabled-time'], function() use ($router) {
            $router->get('/smartlook', 'ServicesEnabled\ServicesEnabledTime@smartlook');
        });

        $router->group(['prefix' => 'customers'], function () use ($router) {
            $router->post('/', 'CustomersController@create');
            $router->post('/{id}', 'CustomersController@findById');
            $router->post('/update-receive-offers/{id}', 'CustomersController@updateReceiveOffers');
            $router->get('/find-email', 'CustomersController@findByEmail');
            $router->put('/{id}', 'CustomersController@update');
            $router->put('/update-customer-data/{id}', 'CustomersController@updateCustomerData');
            $router->put('/update-customer/points', 'CustomersController@updateCustomerPoints');
            $router->put('/update-customer/register-from-action', 'CustomersController@updateRegisterFromAction');
            $router->put('/update-customer/sent-store-email', 'CustomersController@updateSentStoreEmail');

            $router->put('/update-customer/forwarding-email-sent', 'CustomersController@updateForwardingEmailSent');
            $router->put('/update-customer/reset-forwarding-email-sent', 'CustomersController@resetForwardingEmailSent');
            $router->post('/update-customer/verify-forwarding-email', 'CustomersController@verifyForwardingEmailSent');
            $router->get('/update-customer/verify-forwarding-email-send', 'CustomersController@forwardingEmailSentVerify');

            $router->get('/update-customer/verify-customer-avatar', 'CustomersController@verifyCustomerAvatar');
            $router->post('/update-customer/update-customer-avatar', 'CustomersController@updateCustomerAvatar');

            $router->delete('/{id}', 'CustomersController@destroy');
        });

        $router->group(['prefix' => 'products-services'], function () use ($router) {
            $router->get('/{id}', 'ProductsServicesController@getById');
        });        
        
        $router->group(['prefix' => 'clairvoyant'], function () use ($router) {
            $router->post('/', 'ClairvoyantsController@create');
            $router->get('/list', 'ClairvoyantsController@index');
        });

        $router->group(['prefix' => 'xmove-car'], function () use ($router) {
            $router->post('/', 'XMoveCar\XMoveCarController@create');
            $router->get('/list', 'XMoveCar\XMoveCarController@index');
        });

        $router->group(['prefix' => 'vip-list'], function () use ($router) {
            $router->get('/', 'VipListSubscribersController@index');
            $router->get('/{id}', 'VipListSubscribersController@show');
            $router->post('/', 'VipListSubscribersController@store');
            $router->post('/create', 'VipListSubscribersController@create');
            $router->post('/update', 'VipListSubscribersController@update');
            $router->post('/verify-phone', 'VipListSubscribersController@verifyPhone');
            $router->put('/{id}', 'VipListSubscribersController@update');
        });

        $router->group(['prefix' => 'app-indication'], function () use ($router) { 
            $router->get('/', 'MobileApp\Indications\AppIndicationsController@index');
            $router->get('/{id}', 'MobileApp\Indications\AppIndicationsController@show');
            $router->post('/', 'MobileApp\Indications\AppIndicationsController@store');
            $router->post('/verify-indicated', 'MobileApp\Indications\AppIndicationsController@verifyIndicated');
            $router->put('/{id}', 'MobileApp\Indications\AppIndicationsController@update');            
        });

        $router->group(['prefix' => 'validated-indication'], function () use ($router) { 
            $router->get('/', 'MobileApp\Indications\AppValidatedIndicationController@index');
            $router->get('/{id}', 'MobileApp\Indications\AppValidatedIndicationController@show');
            $router->post('/', 'MobileApp\Indications\AppValidatedIndicationController@store');
            $router->post('/verify-indicated', 'MobileApp\Indications\AppValidatedIndicationController@verifyIndicated');
            $router->put('/{id}', 'MobileApp\Indications\AppValidatedIndicationController@update');
        });

        $router->group(['prefix' => 'interest'], function () use ($router) {
            $router->group(['prefix' => 'interest-types'], function () use ($router) {
                $router->get('/', 'Interests\InterestTypesController@index');
                $router->get('/{id}', 'Interests\InterestTypesController@show');
                $router->post('/', 'Interests\InterestTypesController@store');
                $router->put('/{id}', 'Interests\InterestTypesController@update');
            });

            $router->group(['prefix' => 'customers-interest'], function () use ($router) {
                $router->get('/', 'Interests\CustomersInterestController@index');
                $router->get('/{id}', 'Interests\CustomersInterestController@show');
                $router->post('/', 'Interests\CustomersInterestController@store');
                $router->post('/create', 'Interests\CustomersInterestController@create');
                $router->post('/delete', 'Interests\CustomersInterestController@delete');
                $router->put('/{id}', 'Interests\CustomersInterestController@update');
            }); 

            $router->group(['prefix' => 'schedule-updated-info'], function () use ($router) {
                $router->get('/{id}', 'CustomersController@getScheduleUpdatedInfo');
                $router->post('/update', 'CustomersController@updateScheduleUpdatedInfo');
            }); 
        });

        $router->group(['prefix' => 'campaigns', 'namespace' => 'Frontend', 'middleware' => 'token'], function() use ($router) {
            $router->get('/', 'CampaignsController@index');
            $router->patch('{id}', 'CampaignsController@patch');

            $router->group(['prefix' => 'filtered'], function() use ($router) {
                $router->get('/', 'CampaignsController@filtered');
            });

            $router->group(['prefix' => 'answers'], function() use ($router) {
                $router->post('/', 'CampaignAnswersController@create');
            });

            $router->group(['prefix' => 'fields'], function () use ($router) {
                $router->get('/{id}', 'CampaignFieldsController@show');
                $router->get('/{id}/edit', 'CaipaignFieldscontroller@edit');
                $router->post('/create', 'CampaignFieldsController@store');
                $router->delete('/{id}', 'CampaignFieldsController@destroy');

                $router->group(['prefix' => 'answers'], function () use($router) {
                    $router->get('/{id}', 'CampaignFieldAnswersController@show');
                    $router->get('/{id}/edit', 'CampaignFieldsAnswersController@edit');
                    $router->post('/create', 'CampaignFieldsAnswersController@store');
                });

                $router->group(['prefix' => 'types'], function () use($router) {
                    $router->get('/{id}', 'CampaignFieldTypesController@show');
                    $router->get('/{id}/edit', 'CampaignFieldTypesController@edit');
                    $router->post('/create', 'CampaignFieldTypesController@store');
                    $router->delete('/{id}', 'CampaignFieldTypesController@destroy');
                });

            });

        });

        $router->group(['prefix' => 'campaing-from-dashboard'], function() use ($router) {
            $router->get('/{campaign_id}', 'CampaignsController@getCampaign');
        });

        $router->group(['prefix' => 'customer-login-points'], function() use ($router) {
            $router->get('/', 'CustomerLoginPointsController@index');
            $router->get('/{id}', 'CustomerLoginPointsController@show');
            $router->post('/', 'CustomerLoginPointsController@store');
            $router->post('/verify', 'CustomerLoginPointsController@verify');
            $router->put('/{id}', 'CustomerLoginPointsController@update');
        });

    });

    $router->group(['prefix' => 'auth'], function () use ($router) {
        $router->get('login/','UsersController@authenticate');
    });

    $router->group(['prefix' => 'admin', 'middleware' => ['auth', 'roles']], function () use ($router) {
        $router->group(['prefix' => 'customers'], function() use ($router) {
            $router->get('/', [
                'as' => 'customers.get.all',
                'uses' => 'CustomersController@index',
                'roles' => ['Administrator'],
            ]);
            $router->get('/{id}', [
                'as' => 'customers.get.id',
                'uses' => 'CustomersController@find',
                'roles' => ['Administrator'],
            ]);
            $router->put('{id}', [
                'as' => 'customer.put',
                'uses' => 'CustomersController@update',
                'roles' => ['Administrator'],
            ]);
            $router->patch('{id}', [
                'as' => 'customer.patch',
                'uses' => 'CustomersController@patch',
                'roles' => ['Administrator'],
            ]);
            $router->delete('{id}', [
                'as' => 'customer.delete',
                'uses' => 'CustomersController@destroy',
                'roles' => ['Administrator'],
            ]);
        });

        $router->group(['prefix' => 'companies'], function() use ($router) {
            $router->get('/', [
                'as' => 'companies.get.all',
                'uses' => 'CompaniesController@index',
                'roles' => ['Administrator'],
            ]);

            $router->get('/{id}', [
                'as' => 'companies.find',
                'uses' => 'CompaniesController@find',
                'roles' => ['Administrator'],
            ]);
            $router->post('/', [
                'as' => 'companies.post',
                'uses' => 'CompaniesController@create',
                'roles' => ['Administrator'],
            ]);
            $router->put('{id}', [
                'as' => 'companies.update',
                'uses' => 'CompaniesController@update',
                'roles' => ['Administrator'],
            ]);
            $router->patch('{id}', [
                'as' => 'companies.patch',
                'uses' => 'CompaniesController@patch',
                'roles' => ['Administrator'],
            ]);
            $router->delete('{id}', [
                'as' => 'companies.delete',
                'uses' => 'CompaniesController@destroy',
                'roles' => ['Administrator'],
            ]);
        });

        $router->group(['prefix' => 'domains'], function() use ($router) {
            $router->get('/', [
                'as' => 'domains.get',
                'uses' => 'DomainsController@index',
                'roles' => ['Administrator'],
            ]);
            $router->get('/{id}', [
                'as' => 'domains.find',
                'uses' => 'DomainsController@find',
                'roles' => ['Administrator'],
            ]);
            $router->post('/', [
                'as' => 'domains.create',
                'uses' => 'DomainsController@create',
                'roles' => ['Administrator'],
            ]);
            $router->put('{id}', [
                'as' => 'domains.create',
                'uses' => 'DomainsController@update',
                'roles' => ['Administrator'],
            ]);
            $router->patch('{id}', [
                'as' => 'domains.patch',
                'uses' => 'DomainsController@patch',
                'roles' => ['Administrator'],
            ]);
            $router->delete('{id}', [
                'as' => 'domains.destroy',
                'uses' => 'DomainsController@destroy',
                'roles' => ['Administrator'],
            ]);
        });

        $router->group(['prefix' => 'campaigns'], function() use ($router) {
            //questions
            $router->get('/', [
                'as' => 'campaigns.get',
                'uses' => 'CampaignsController@index',
                'roles' => ['Administrator', 'Company'],
            ]);
            $router->get('/{id}', [
                'as' => 'campaigns.find',
                'uses' => 'CampaignsController@find',
                'roles' => ['Administrator', 'Company'],
            ]);

            $router->post('/', [
                'as' => 'campaigns.store',
                'uses' => 'CampaignsController@store',
                'roles' => ['Administrator', 'Company'],
            ]);
            $router->patch('{id}', [
                'as' => 'campaigns.patch',
                'uses' => 'CampaignsController@patch',
                'roles' => ['Administrator', 'Company'],
            ]);
            $router->put('{id}', [
                'as' => 'campaigns.update',
                'uses' => 'CampaignsController@update',
                'roles' => ['Administrator', 'Company'],
            ]);
        });

        $router->group(['prefix' => 'number-max-order'], function() use ($router) {
            $router->get('/', [
                'as' => 'campaigns.order',
                'uses' => 'CampaignsController@getMaxOrderNumber',
                'roles' => ['Administrator', 'Company'],
            ]);
        });

        $router->group(['prefix' => 'campaign-resources'], function() use ($router) {
            $router->get('/', [
                'as' => 'campaigns.resources',
                'uses' => 'CampaignsController@resources',
                'roles' => ['Administrator', 'Company'],
            ]);
        });

        $router->group(['prefix' => 'campaigns-clickout'], function() use ($router) {
            //questions
            $router->put('{id}', [
                'as' => 'campaigns.clickout.update',
                'uses' => 'CampaignsClickoutController@update',
                'roles' => ['Administrator', 'Company'],
            ]);
            $router->delete('{id}', [
                'as' => 'campaigns.clickout.destroy',
                'uses' => 'CampaignsClickoutController@destroy',
                'roles' => ['Administrator', 'Company'],
            ]);
            $router->post('/', [
                'as' => 'campaigns.clickout.store',
                'uses' => 'CampaignsClickoutController@store',
                'roles' => ['Administrator', 'Company'],
            ]);
        });

        $router->group(['prefix' => 'campaign-types'], function() use ($router) {
            $router->get('/', [
                'as' => 'campaigns.types.get',
                'uses' => 'CampaignTypesController@index',
                'roles' => ['Administrator', 'Company'],
            ]);
            $router->get('/{id}', [
                'as' => 'campaigns.types.show',
                'uses' => 'CampaignTypesController@show',
                'roles' => ['Administrator', 'Company'],
            ]);
            $router->get('/status/{status}', [
                'as' => 'campaigns.types.status',
                'uses' => 'CampaignTypesController@status',
                'roles' => ['Administrator', 'Company'],
            ]);
        });

        $router->group(['prefix' => 'products-services'], function() use ($router) {
            $router->get('/', [
                'as' => 'products.services.get',
                'uses' => 'ProductsServicesController@index',
                'roles' => ['Administrator'],
            ]);
            $router->post('/', [
                'as' => 'products.services.post',
                'uses' => 'ProductsServicesController@create',
                'roles' => ['Administrator'],
            ]);
            $router->put('{id}', [
                'as' => 'products.services.put',
                'uses' => 'ProductsServicesController@update',
                'roles' => ['Administrator'],
            ]);
            $router->patch('{id}', [
                'as' => 'products.services.patch',
                'uses' => 'ProductsServicesController@patch',
                'roles' => ['Administrator'],
            ]);
            $router->post('{id}', [
                'as' => 'products.services.destroy',
                'uses' => 'ProductsServicesController@destroy',
                'roles' => ['Administrator'],
            ]);
            //resources
            $router->get('/resources/', [
                'as' => 'products.services.resources',
                'uses' => 'ProductsServicesController@resources',
                'roles' => ['Administrator'],
            ]);
        });

        /**
         * Dashboard > Actions
         */
        $router->group(['prefix' => 'actions'], function () use ($router) {
            /**
             * Actions > List
             */
            $router->get('/', [
                'as'    => 'actions.index',
                'uses'  => 'ActionsController@index',
                'roles' => ['Administrator'],
            ]);

            /**
             * Actions > List > Categories
             */
            $router->get('/categories', [
                'as'    => 'actions.categories',
                'uses'  => 'ActionsController@categories',
                'roles' => ['Administrator'],
            ]);

            /**
             * Actions > List > Types
             */
            $router->get('/types', [
                'as'    => 'actions.types',
                'uses'  => 'ActionsController@types',
                'roles' => ['Administrator'],
            ]);

            /**
             * Actions > Show
             */
            $router->get('/{id}', [
                'as'    => 'actions.show',
                'uses'  => 'ActionsController@show',
                'roles' => ['Administrator'],
            ]);

            /**
             * Actions > Create
             */
            $router->post('/', [
                'as'    => 'actions.store',
                'uses'  => 'ActionsController@store',
                'roles' => ['Administrator'],
            ]);

            /**
             * Actions > Update
             */
            $router->put('/{id}', [
                'as'    => 'actions.update',
                'uses'  => 'ActionsController@update',
                'roles' => ['Administrator'],
            ]);

            /**
             * Actions > Delete
             */
            $router->delete('/{id}', [
                'as'    => 'actions.destroy',
                'uses'  => 'ActionsController@destroy',
                'roles' => ['Administrator'],
            ]);
        });
    });

    /**
     * Routes used in Sweet Bonus Store.
     */
    $router->group(['prefix' => 'customers', 'namespace' => 'Customers'], function () use ($router) {
        $router->post('login', 'AuthController@login');

        $router->post('token/renew/{customerId}', 'AuthController@renewToken');

        $router->get('login/verify/{code}', 'AuthController@verify');

        $router->post('logout', 'AuthController@logout');

        $router->post('password/email', 'ForgotPasswordController@email');

        $router->post('password/reset', 'ResetPasswordController@reset');

        $router->post('password/update', 'ResetPasswordController@update');

        $router->post('password/change', 'ChangePasswordController@change');

        $router->post('password/create', 'CreatePasswordController@create');

        $router->put('{customerId}', 'ProfileController@update');

        $router->get('{customerId}/products/closest-exchanges', 'ExchangesController@closestExchanges');

        $router->get('patch', 'PatchCityAndStateController@apply');

        $router->get('click-login','ClickLoginController@login');

        $router->get('unsubscribe', 'UnsubscribeController@unsubscribe');

    });

    $router->group(['prefix' => 'product-service-stamps'], function () use ($router) {
        $router->get('/', 'ProductServiceStamps\ProductServiceStampsController@index');
        $router->get('/{id}', 'ProductServiceStamps\ProductServiceStampsController@show');
        $router->post('/', 'ProductServiceStamps\ProductServiceStampsController@store');
        $router->post('/delete', 'ProductServiceStamps\ProductServiceStampsController@delete');

        $router->put('/{id}', 'ProductServiceStamps\ProductServiceStampsController@update');
    });

    $router->group(['prefix' => 'actions'], function () use ($router) {
        $router->get('/', 'ActionsController@freeActionsAll');
        $router->get('/categories/{categoryId}/actions', 'ActionsController@freeActionsByCategory');
    });

    $router->group(['prefix' => 'products', 'namespace' => 'Products'], function () use ($router) {
        $router->get('categories', 'CategoriesController@all');
        $router->get('categories/{category_id}/products/customer/{customerId}', 'ProductsController@findByCategory');
        $router->get('min/{priceMin}/max/{priceMax}/customer/{customerId}', 'ProductsController@findByPriceRange');
    });

    $router->group(['prefix' => 'checkin'], function () use ($router) {
        $router->post('/', 'CheckinController@store');
        $router->get('/getCheckin', 'CheckinController@getCheckin');
    });

    $router->group(['prefix' => 'survey'], function () use ($router) {
        $router->post('/', 'SurveyPostbackController@store');
    });

    $router->get('cep/{cep}', 'CepController@show');

});
