<?php

require_once __DIR__ . '/../vendor/autoload.php';

try {
    (new Dotenv\Dotenv(__DIR__ . '/../'))->load();
} catch (Dotenv\Exception\InvalidPathException $e) {
    //
}

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| Here we will load the environment and create the application instance
| that serves as the central piece of this framework. We'll use this
| application as an "IoC" container and router for this framework.
|
 */

$app = new Laravel\Lumen\Application(
    realpath(__DIR__ . '/../')
);

$app->withFacades();

$app->withEloquent();

$app->configure('mail');

/*if (!class_exists('DataTables')) {
class_alias('Yajra\DataTables\Facades\DataTables', 'DataTables');
}*/

/*
|--------------------------------------------------------------------------
| Register Container Bindings
|--------------------------------------------------------------------------
|
| Now we will register a few bindings in the service container. We will
| register the exception handler and the console kernel. You may add
| your own bindings here if you like or you can make another file.
|
 */

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

/*
|--------------------------------------------------------------------------
| Register Middleware
|--------------------------------------------------------------------------
|
| Next, we will register the middleware with the application. These can
| be global middleware that run before and after each request into a
| route or middleware that'll be assigned to some specific routes.
|
 */

$app->middleware([
    App\Http\Middleware\CorsMiddleware::class,
]);

$app->routeMiddleware([
    'auth' => App\Http\Middleware\Authenticate::class,
    'token' => App\Http\Middleware\TokenCustomer::class,
    'roles' => App\Http\Middleware\CheckRole::class,
    'jwt.auth' => App\Http\Middleware\JwtMiddleware::class,
    'thirdparty.auth' => App\Http\Middleware\ThirdPartyClientMiddleware::class,
    'ip.ssi.check' => \App\Http\Middleware\IpSsiMiddleware::class,
]);

/*
|--------------------------------------------------------------------------
| Register Service Providers
|--------------------------------------------------------------------------
|
| Here we will register all of the application's service providers which
| are used to bind services into the container. Service providers are
| totally optional, so you are not required to uncomment this line.
|
 */

$app->register(App\Providers\AppServiceProvider::class);
$app->register(App\Providers\AuthServiceProvider::class);
$app->register(App\Providers\EventServiceProvider::class);
$app->register(Illuminate\Redis\RedisServiceProvider::class);
$app->register(App\Providers\TokenCustomerServiceProvider::class);
$app->register(Flipbox\LumenGenerator\LumenGeneratorServiceProvider::class);
$app->register('Sentry\SentryLaravel\SentryLumenServiceProvider');
$app->register(\Rap2hpoutre\LaravelLogViewer\LaravelLogViewerServiceProvider::class);
$app->register(\LaravelLegends\PtBrValidator\ValidatorProvider::class);

/*
|--------------------------------------------------------------------------
| Load The Application Routes
|--------------------------------------------------------------------------
|
| Next we will include the routes file so that they can all be added to
| the application. This will provide all of the URLs the application
| can respond to, as well as the controllers that may handle them.
|
 */

$app->router->group([
    'namespace' => 'App\Http\Controllers',
], function ($router) {
    require __DIR__ . '/../routes/web.php';
    require __DIR__ . '/../routes/researches/seguro_auto.php';
    require __DIR__ . '/../routes/researches/ssi.php';
    require __DIR__ . '/../routes/exchange_points.php';
    require __DIR__ . '/../routes/incentive_emails.php';
    require __DIR__ . '/../routes/relationship_rule.php';
    require __DIR__ . '/../routes/facebook.php';
    require __DIR__ . '/../routes/researches/quiz.php';
    require __DIR__ . '/../routes/stamps.php';
    require __DIR__ . '/../routes/pixeis.php';
    require __DIR__ . '/../routes/researches/carsystem.php';
    require __DIR__ . '/../routes/stamp_types.php';
    require __DIR__ . '/../routes/customer_address.php';
    require __DIR__ . '/../routes/unsubscribed.php';
    require __DIR__ . '/../routes/researches/ead.php';
    require __DIR__ . '/../routes/researches/greenpeace_oceanos.php';
    require __DIR__ . '/../routes/customer_device.php';
    require __DIR__ . '/../routes/mgm_action.php';
    require __DIR__ . '/../routes/researches/alfacon.php';
    require __DIR__ . '/../routes/messages.php';
    require __DIR__ . '/../routes/researches/social_class.php';
    require __DIR__ . '/../routes/app/auth.php';
    require __DIR__ . '/../routes/app/message.php';
    require __DIR__ . '/../routes/researches.php';
    require __DIR__ . '/../routes/researches/infoproduto.php';
    require __DIR__ . '/../routes/email_forwarding.php';
});

return $app;
