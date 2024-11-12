<?php

namespace App\Exception;

use Exception;

class UserNotFoundException extends Exception
{
    protected $message = 'User not found';
}