<?php

namespace SquareetLabs\LaravelOpenVidu\Exceptions;


use Throwable;

/**
 * Class OpenViduConnectionNotFoundException
 * @package SquareetLabs\LaravelOpenVidu\Exceptions
 */
class OpenViduConnectionNotFoundException extends OpenViduException
{
    public function __construct(Throwable $previous = null)
    {
        parent::__construct('No connection exists for the passed sessionId', 404, $previous);
    }

    public function __toString()
    {
        return __CLASS__ . ":[{$this->code}]:{$this->message}\n";
    }
}
