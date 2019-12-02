<?php

namespace SquareetLabs\LaravelOpenVidu\Exceptions;


use Throwable;

/**
 * Class OpenViduSessionHasNotConnectedParticipantsException
 * @package SquareetLabs\LaravelOpenVidu\Exceptions
 */
class OpenViduSessionHasNotConnectedParticipantsException extends OpenViduException
{
    public function __construct(Throwable $previous = null)
    {
        parent::__construct(__('The session has no connected participants'), 406, $previous);
    }

    public function __toString()
    {
        return __CLASS__ . ":[{$this->code}]:{$this->message}\n";
    }
}
