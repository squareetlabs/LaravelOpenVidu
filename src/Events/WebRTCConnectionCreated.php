<?php

namespace SquareetLabs\LaravelOpenVidu\Events;

use stdClass;

/**
 * Class WebRTCConnectionCreated
 * @package SquareetLabs\LaravelOpenVidu\Events
 */
class WebRTCConnectionCreated implements WebhookEventInterface
{
    /**
     * @var string $sessionId
     * Session for which the event was triggered
     * A string with the session unique identifier
     */
    public $sessionId;

    /**
     * @var int $timestamp
     * Time when the event was triggered
     * UTC milliseconds
     */
    public $timestamp;

    /**
     * @var string $participantId
     * Identifier of the participant
     * A string with the participant unique identifier
     */
    public $participantId;

    /**
     * @var string $connection
     * Whether the media connection is an inbound connection (the participant is receiving media from OpenVidu) or an outbound connection (the participant is sending media to OpenVidu)
     * ["INBOUND","OUTBOUND"]
     */
    public $connection;


    /**
     * @var string $receivingFrom
     * If connection is "INBOUND", the participant from whom the media stream is being received
     * A string with the participant (sender) unique identifier
     */
    public $receivingFrom;

    /**
     * @var bool $audioEnabled
     * Whether the media connection has negotiated audio or not
     * [true,false]
     */
    public $audioEnabled;

    /**
     * @var bool $videoEnabled
     * Whether the media connection has negotiated video or not
     * [true,false]
     */
    public $videoEnabled;

    /**
     * @var string $videoSource
     * If videoEnabled is true, the type of video that is being transmitted
     * ["CAMERA","SCREEN"]
     */
    public $videoSource;

    /**
     * @var int $videoFramerate
     * If videoEnabled is true, the framerate of the transmitted video
     * Number of fps
     */
    public $videoFramerate;

    /**
     * @var int $videoDimensions
     * If videoEnabled is true, the dimensions transmitted video
     * String with the dimensions (e.g. "1920x1080")
     */
    public $videoDimensions;

    /**
     * @var $event
     * Openvidu server webhook event
     */
    public $event;

    /**
     * Create a new ParticipantJoined event instance.
     * @param stdClass $data
     */
    public function __construct(stdClass $data)
    {
        $this->sessionId = property_exists($data, 'sessionId') ? $data->sessionId : null;
        $this->timestamp = property_exists($data, 'timestamp') ? $data->timestamp : null;
        $this->participantId = property_exists($data, 'participantId') ? $data->participantId : null;
        $this->receivingFrom = property_exists($data, 'receivingFrom') ? $data->receivingFrom : null;
        $this->audioEnabled = property_exists($data, 'audioEnabled') ? $data->audioEnabled : null;
        $this->videoEnabled = property_exists($data, 'videoEnabled') ? $data->videoEnabled : null;
        $this->videoSource = property_exists($data, 'videoSource') ? $data->videoSource : null;
        $this->videoFramerate = property_exists($data, 'videoFramerate') ? $data->videoFramerate : null;
        $this->videoDimensions = property_exists($data, 'videoDimensions') ? $data->videoDimensions : null;
        $this->event = $data->event;
    }
}