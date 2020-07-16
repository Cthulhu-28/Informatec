<?php

use Informatec\Validation\Validator;

use Respect\Validation\Validator as v;

// ini_set('memory_limit', '2G');

session_start();

require __DIR__ . '/../vendor/autoload.php';

$app = new \Slim\App([
    'settings' => [
        'displayErrorDetails' => true,
        "db" => [
            'driver' => 'mysql',
            'host' => 'us-cdbr-east-06.cleardb.net',
            'username' => 'b4e1b8c20cd5e4',
            'password' => '27fa3cfa',
            'database' => 'heroku_cad5d849da1e2ca',
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
        ]
    ],
]);

$container = $app->getContainer();

$capsule = new \Illuminate\Database\Capsule\Manager;
$capsule->addConnection($container['settings']['db']);
$capsule->setAsGlobal();
$capsule->bootEloquent();

$container['db'] = function ($container) use ($capsule) {
    return $capsule;
};

$container['auth'] = function ($container) {
    return new \Informatec\Auth\Auth;
};

$container['flash'] = function ($container) {
    return new \Slim\Flash\Messages;
};

$container['view'] = function ($container) {
    $view = new \Slim\Views\Twig(__DIR__ . '/../resources/views', [
        'cache' => false,
    ]);
    $view->addExtension(new \Slim\Views\TwigExtension(
        $container->router,
        $container->request->getUri()
    ));
    $view->getEnvironment()->addGlobal('auth', [
        'check' =>  $container->auth->check(),
        'user' =>  $container->auth->user()
    ]);
    $view->getEnvironment()->addGlobal('flash', $container->flash);
    return $view;
};


$container[\Informatec\Controllers\HomeController::class] = function ($container) {
    return new \Informatec\Controllers\HomeController($container);
};

$container[\Informatec\Controllers\Auth\AuthController::class] = function ($container) {
    return new \Informatec\Controllers\Auth\AuthController($container);
};

$container[\Informatec\Controllers\Auth\PasswordController::class] = function ($container) {
    return new \Informatec\Controllers\Auth\PasswordController($container);
};

$container[\Informatec\Controllers\Majors\MajorController::class] = function ($container) {
    return new \Informatec\Controllers\Majors\MajorController($container);
};

$container[\Informatec\Controllers\Admin\MajorController::class] = function ($container) {
    return new \Informatec\Controllers\Admin\MajorController($container);
};

$container['validator'] = function () {
    return new Validator;
};

$container['csrf'] = function ($container) {
    return new \Slim\Csrf\Guard;
};



$app->add(new \Informatec\Middleware\ValidationErrorsMiddleware($container));
$app->add(new \Informatec\Middleware\OldInputMiddleware($container));
$app->add(new \Informatec\Middleware\CsrfViewMiddleware($container));

$app->add($container->csrf);

v::with('Informatec\\Validation\\Rules\\');

require __DIR__ . '/../app/routes.php';
