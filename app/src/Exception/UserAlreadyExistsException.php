<?php

namespace App\Exception;

use Exception;

class UserAlreadyExistsException extends Exception
{
    protected $message = 'User already exists';
}