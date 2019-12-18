<?php

namespace SquareetLabs\LaravelOpenVidu\Events;

use Illuminate\Queue\SerializesModels;

/**
 * Class WebRTCConnectionCreated
 * @package SquareetLabs\LaravelOpenVidu\Events
 */
class WebRTCConnectionDestroyed implements WebhookEventInterface
{
    use SerializesModels;
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
     * @var $startTime
     * Time when the media connection was established
     * UTC milliseconds
     */
    public $startTime;

    /**
     * @var $duration
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
     * @var $reason
     * How the WebRTC connection was destroyed
     *["unsubscribe","unpublish","disconnect","forceUnpublishByUser","forceUnpublishByServer","forceDisconnectByUser","forceDisconnectByServer","sessionClosedByServer","networkDisconnect","openviduServerStopped","mediaServerDisconnect"]
     */
    public $reason;

    /**
     * @var $event
     * Openvidu server webhook event
     */
    public $event;


    /**
     * Create a new SessionCreated event instance.
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->sessionId = array_key_exists('sessionId', $data) ? $data['sessionId'] : null;
        $this->timestamp = array_key_exists('timestamp', $data) ? $data['timestamp'] : null;
        $this->participantId = array_key_exists('participantId', $data) ? $data['participantId'] : null;
        $this->receivingFrom = array_key_exists('receivingFrom', $data) ? $data['receivingFrom'] : null;
        $this->audioEnabled = array_key_exists('audioEnabled', $data) ? $data['audioEnabled'] : null;
        $this->videoEnabled = array_key_exists('videoEnabled', $data) ? $data['videoEnabled'] : null;
        $this->videoSource = array_key_exists('videoSource', $data) ? $data['videoSource'] : null;
        $this->videoFramerate = array_key_exists('videoFramerate', $data) ? $data['videoFramerate'] : null;
        $this->videoDimensions = array_key_exists('videoDimensions', $data) ? $data['videoDimensions'] : null;
        $this->startTime = array_key_exists('startTime', $data) ? $data['startTime'] : null;
        $this->duration = array_key_exists('duration', $data) ? $data['duration'] : null;
        $this->reason = array_key_exists('reason', $data) ? $data['reason'] : null;
        $this->event = $data['event'];
    }
}