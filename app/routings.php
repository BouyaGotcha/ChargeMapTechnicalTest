<?php

use App\Controller\ChargeController;
use App\Controller\HomeController;
use App\Controller\UserController;
use Slim\App;

return function (App $app) {
    $app->get('/', HomeController::class . ":index");

    $app->post('/users', UserController::class . ":createUser");
    $app->delete('/users/{email}', UserController::class . ":deleteUser");
    $app->get('/users/{email}/stats', UserController::class . ":getStats");

    $app->post('/charges/{email}', ChargeController::class . ":createCharge");
};