<?php

namespace SquareetLabs\LaravelOpenVidu\Exceptions;


use Throwable;

/**
 * Class OpenViduSessionCantRecordingException
 * @package SquareetLabs\LaravelOpenVidu\Exceptions
 */
class OpenViduSessionCantRecordingException extends OpenViduException
{
    public function __construct($message = "", Throwable $previous = null)
    {
        parent::__construct($message, 409, $previous);
    }

    public function __toString()
    {
        return __CLASS__ . ":[{$this->code}]:{$this->message}\n";
    }
}
