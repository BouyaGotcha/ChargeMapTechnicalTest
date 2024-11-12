<?php

use App\Controller\UserController;
use Slim\App;

return function(App $app){
    $app->post('/users', UserController::class . ":createUser");
    $app->delete('/users/{id}', UserController::class . ":deleteUser");
};