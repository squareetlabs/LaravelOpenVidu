<?php

namespace SquareetLabs\LaravelOpenVidu\Exceptions;


use Throwable;

/**
 * Class OpenViduRecordingResolutionException
 * @package SquareetLabs\LaravelOpenVidu\Exceptions
 */
class OpenViduRecordingResolutionException extends OpenViduException
{
    public function __construct(Throwable $previous = null)
    {
        parent::__construct('"Resolution" parameter exceeds acceptable values (for both width and height, min 100px and max 1999px) or trying to start a recording with both "hasAudio" and "hasVideo" to false', 422, $previous);
    }

    public function __toString()
    {
        return __CLASS__.":[{$this->code}]:{$this->message}\n";
    }
}
