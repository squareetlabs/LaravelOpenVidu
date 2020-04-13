<?php

namespace SquareetLabs\LaravelOpenVidu\Exceptions;


use Throwable;

/**
 * Class OpenViduProblemWithBodyParameterException
 * @package SquareetLabs\LaravelOpenVidu\Exceptions
 */
class OpenViduProblemWithBodyParameterException extends OpenViduException
{
    public function __construct(Throwable $previous = null)
    {
        parent::__construct('There is a problem with some body parameter', 400, $previous);
    }

    public function __toString()
    {
        return __CLASS__.":[{$this->code}]:{$this->message}\n";
    }
}
