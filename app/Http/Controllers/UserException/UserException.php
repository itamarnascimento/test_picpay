<?php

namespace App\Http\Controllers\UserException;

use Exception;

class UserException extends Exception
{

    public function __construct($message)
    {
        parent::__construct($message);

    }
}
