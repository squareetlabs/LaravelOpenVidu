<?php

namespace SquareetLabs\LaravelOpenVidu\Exceptions;


use Throwable;

/**
 * Class OpenViduSessionCantCreateException
 * @package SquareetLabs\LaravelOpenVidu\Exceptions
 */
class OpenViduTokenCantCreateException extends OpenViduException
{
    /**
     * OpenViduTokenCantCreateException constructor.
     * The 424 (Failed Dependency) status code means that the method could not be performed on the resource because the requested action depended on another action and that action failed.
     * In this case, in obtaining the session.
     * https://tools.ietf.org/html/rfc4918#section-11.4
     * @param  string  $message
     * @param  Throwable|null  $previous
     *
     */
    public function __construct($message = "", Throwable $previous = null)
    {
        parent::__construct($message, 424, $previous);
    }

    public function __toString()
    {
        return __CLASS__.":[{$this->code}]:{$this->message}\n";
    }
}
