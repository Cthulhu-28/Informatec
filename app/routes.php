<?php

use Informatec\Middleware\AuthMiddleware;
use Informatec\Middleware\GuestMiddleware;

$app->get('/', \Informatec\Controllers\HomeController::class . ':index')->setName('home');
$app->get('/contact', \Informatec\Controllers\HomeController::class . ':contact')->setName('contact');
$app->get('/majors/map', \Informatec\Controllers\Majors\MajorController::class . ':getMajorsList')->setName('majors.list');
$app->get('/majors/show/{id}', \Informatec\Controllers\Majors\MajorController::class . ':getMajor')->setName('majors.show');
$app->get('/majors/test/{id}', \Informatec\Controllers\Majors\MajorController::class . ':testMajor')->setName('majors.test');

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


$app->group('/admin', function () use ($container) {
    $this->get('/home', \Informatec\Controllers\Admin\MajorController::class . ':getMajorsList')->setName('admin.home');

    $this->get('/majors/new', \Informatec\Controllers\Admin\MajorController::class . ':getNewMajor')->setName('admin.majors.new');
    $this->post('/majors/new', \Informatec\Controllers\Admin\MajorController::class . ':postNewMajor');

    $this->post('/majors/update', \Informatec\Controllers\Admin\MajorController::class . ':postUpdateMajor')->setName('admin.majors.update');

    $this->get('/majors/edit/{id}', \Informatec\Controllers\Admin\MajorController::class . ':getEditMajor')->setName('admin.majors.edit');
    $this->post('/majors/edit/{id}', \Informatec\Controllers\Admin\MajorController::class . ':postEditMajor');

    $this->get('/majors/{id}/areas/new', \Informatec\Controllers\Admin\MajorController::class . ':getNewArea')->setName('admin.majors.areas.new');
    $this->post('/majors/{id}/areas/new', \Informatec\Controllers\Admin\MajorController::class . ':postNewArea');

    $this->get('/majors/{id}/areas/edit/{area}', \Informatec\Controllers\Admin\MajorController::class . ':getEditArea')->setName('admin.majors.areas.edit');
    $this->post('/majors/{id}/areas/edit/{area}', \Informatec\Controllers\Admin\MajorController::class . ':postEditArea');

    $this->get('/majors/areas/delete/{area}', \Informatec\Controllers\Admin\MajorController::class . ':deleteArea')->setName('admin.majors.areas.delete');
})->add(new AuthMiddleware($container));
