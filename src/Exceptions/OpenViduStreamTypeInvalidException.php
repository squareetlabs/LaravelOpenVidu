<?php

namespace SquareetLabs\LaravelOpenVidu\Exceptions;


use Throwable;

/**
 * Class OpenViduStreamTypeInvalidException
 * @package SquareetLabs\LaravelOpenVidu\Exceptions
 */
class OpenViduStreamTypeInvalidException extends OpenViduException
{
    public function __construct(Throwable $previous = null)
    {
        parent::__construct('The stream type is not valid', 409, $previous);
    }

    public function __toString()
    {
        return __CLASS__.":[{$this->code}]:{$this->message}\n";
    }
}
