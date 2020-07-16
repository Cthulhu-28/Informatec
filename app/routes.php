<?php

use Informatec\Middleware\AuthMiddleware;
use Informatec\Middleware\GuestMiddleware;

$app->get('/', \Informatec\Controllers\HomeController::class . ':index')->setName('home');
$app->get('/majors/map', \Informatec\Controllers\Majors\MajorController::class . ':getMajorsList');

$app->group('', function () {
    $this->get('/auth/signup', \Informatec\Controllers\Auth\AuthController::class . ':getSignUp')->setName('auth.signup');
    $this->post('/auth/signup', \Informatec\Controllers\Auth\AuthController::class . ':postSignUp');

    $this->get('/auth/signin', \Informatec\Controllers\Auth\AuthController::class . ':getSignIn')->setName('auth.signin');
    $this->post('/auth/signin', \Informatec\Controllers\Auth\AuthController::class . ':postSignIn');
})->add(new GuestMiddleware($container));

$app->group('', function () {
    $this->get('/auth/signout', \Informatec\Controllers\Auth\AuthController::class . ':getSignOut')->setName('auth.signout');
    $this->get('/auth/password/change', \Informatec\Controllers\Auth\PasswordController::class . ':getChangePassword')->setName('auth.password.change');
    $this->post('/auth/password/change', \Informatec\Controllers\Auth\PasswordController::class . ':postChangePassword');
})->add(new AuthMiddleware($container));


$app->group('/admin', function () {
    $this->get('/majors/new', \Informatec\Controllers\Admin\MajorController::class . ':getNewMajor')->setName('admin.majors.new');
})->add(new AuthMiddleware($container));
