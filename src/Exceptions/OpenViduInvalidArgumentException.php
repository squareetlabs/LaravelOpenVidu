<?php

namespace SquareetLabs\LaravelOpenVidu\Exceptions;


use Exception;
use Throwable;

/**
 * Class OpenViduInvalidArgumentException
 * @package SquareetLabs\LaravelOpenVidu\Exceptions
 */
class OpenViduInvalidArgumentException extends Exception
{
    public function __construct($message = "", $code = 422, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function __toString()
    {
        return __CLASS__ . ":[{$this->code}]:{$this->message}\n";
    }
}
