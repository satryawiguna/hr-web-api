<?php

namespace App\Exceptions;

use Exception;

class ErrorException extends Exception
{
    public function render($request)
    {
        return json_decode((string) $this->message, true)["message"];
    }
}
