<?php

namespace SquareetLabs\LaravelOpenVidu\Enums;

/**
 * Class Uri
 * @package SquareetLabs\LaravelOpenVidu\Enums
 */
class Uri
{
    /**
     *  https://openvidu.io/docs/reference-docs/REST-API/#get-apirecordings
     */
    public const RECORDINGS_URI = 'api/recordings';
    /**
     * https://openvidu.io/docs/reference-docs/REST-API/#post-apirecordingsstart
     */
    public const RECORDINGS_START = 'api/recordings/start';
    /**
     * https://openvidu.io/docs/reference-docs/REST-API/#post-apirecordingsstopltrecording_idgt
     */
    public const RECORDINGS_STOP = 'api/recordings/stop';
    /**
     * https://openvidu.io/docs/reference-docs/REST-API/#post-apisessions
     */
    public const SESSION_URI = 'api/sessions';
    /**
     * https://openvidu.io/docs/reference-docs/REST-API/#post-apitokens
     */
    public const TOKEN_URI = 'api/tokens';
}
