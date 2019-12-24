<?php

namespace SquareetLabs\LaravelOpenVidu\Events;


/**
 * Class WebRTCConnectionCreated
 * @package SquareetLabs\LaravelOpenVidu\Events
 */
class WebRTCConnectionDestroyed
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
     * @var int $startTime
     * Time when the media connection was established
     * UTC milliseconds
     */
    public $startTime;

    /**
     * @var int $duration
     * Total duration of the media connection
     * Seconds
     */
    public $duration;

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
     * @var  string $reason
     * How the WebRTC connection was destroyed
     *["unsubscribe","unpublish","disconnect","forceUnpublishByUser","forceUnpublishByServer","forceDisconnectByUser","forceDisconnectByServer","sessionClosedByServer","networkDisconnect","openviduServerStopped","mediaServerDisconnect"]
     */
    public $reason;

    /**
     * @var string $event
     * Openvidu server webhook event
     */
    public $event;


    /**
     * Create a new SessionCreated event instance.
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->sessionId = $data['sessionId'];
        $this->timestamp = $data['timestamp'];
        $this->participantId = $data['participantId'];
        if (array_key_exists('receivingFrom', $data)) {
            $this->receivingFrom = $data['receivingFrom'];
        }
        $this->audioEnabled = $data['audioEnabled'];
        $this->videoEnabled = $data['videoEnabled'];
        if (array_key_exists('videoSource', $data)) {
            $this->videoSource = $data['videoSource'];
            $this->videoFramerate = $data['videoFramerate'];
            $this->videoDimensions = $data['videoDimensions'];
        }
        $this->startTime = $data['startTime'];
        $this->duration = $data['duration'];
        $this->reason = $data['reason'];
        $this->event = $data['event'];
    }
}