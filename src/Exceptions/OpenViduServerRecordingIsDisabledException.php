<?php

namespace SquareetLabs\LaravelOpenVidu\Exceptions;


use Throwable;

/**
 * Class OpenViduSessionCantRecordingException
 * @package SquareetLabs\LaravelOpenVidu\Exceptions
 */
class OpenViduServerRecordingIsDisabledException extends OpenViduException
{
    public function __construct(Throwable $previous = null)
    {
        parent::__construct('OpenVidu Server recording module is disabled (openvidu.recording property set to false)', 409, $previous);
    }

    public function __toString()
    {
        return __CLASS__ . ":[{$this->code}]:{$this->message}\n";
    }
}
