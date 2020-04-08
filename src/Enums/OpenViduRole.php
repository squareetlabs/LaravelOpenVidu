<?php

namespace SquareetLabs\LaravelOpenVidu\Enums;

/**
 * Class OpenViduRole
 * @package SquareetLabs\LaravelOpenVidu\Enums
 */
class OpenViduRole
{
    /**
     * SUBSCRIBER permissions + can publish their own Streams (call Session.publish())
     */
    public const SUBSCRIBER = 'SUBSCRIBER';

    /**
     * Can subscribe to published Streams of other users
     */
    public const PUBLISHER = 'PUBLISHER';

    /**
     * SUBSCRIBER + PUBLISHER permissions + can force the unpublishing or disconnection over a third-party Stream or Connection (call Session.forceUnpublish() and Session.forceDisconnect())
     */
    public const MODERATOR = 'MODERATOR';
}
