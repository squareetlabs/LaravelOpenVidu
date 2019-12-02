<?php

namespace SquareetLabs\LaravelOpenVidu\Exceptions;


use Throwable;

/**
 * Class OpenViduRecordingNotFoundException
 * @package SquareetLabs\LaravelOpenVidu\Exceptions
 */
class OpenViduRecordingStatusException extends OpenViduException
{
    public function __construct($message = "", Throwable $previous = null)
    {
        parent::__construct($message, 406, $previous);
    }

    public function __toString()
    {
        return __CLASS__ . ":[{$this->code}]:{$this->message}\n";
    }
}
