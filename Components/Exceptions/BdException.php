<?php

declare(strict_types=1);


namespace components;

use Exception;
use Throwable;

class BdException extends Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}