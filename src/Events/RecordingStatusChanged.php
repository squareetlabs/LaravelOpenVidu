<?php

namespace SquareetLabs\LaravelOpenVidu\Events;

use Illuminate\Queue\SerializesModels;
use stdClass;

/**
 * Class RecordingStatusChanged
 * @package SquareetLabs\LaravelOpenVidu\Events
 */
class RecordingStatusChanged implements WebhookEventInterface
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
     * @var int $startTime
     * Time when the recording started
     * UTC milliseconds
     */
    public $startTime;

    /**
     * @var string $id
     * Unique identifier of the recording
     * A string with the recording unique identifier
     */
    public $id;

    /**
     * @var string $name
     * Name given to the recording file
     * A string with the recording name
     */
    public $name;


    /**
     * @var string $outputMode
     * Output mode of the recording (COMPOSED or INDIVIDUAL)
     * A string with the recording output mode
     */
    public $outputMode;


    /**
     * @var bool $hasAudio
     * Wheter the recording file has audio or not
     *    [true,false]
     */
    public $hasAudio;

    /**
     * @var bool $hasVideo
     * Wheter the recording file has video or not
     *    [true,false]
     */
    public $hasVideo;

    /**
     * @var string $recordingLayout
     * The type of layout used in the recording. Only defined if outputMode is COMPOSED and hasVideo is true
     *  A RecordingLayout value (BEST_FIT, PICTURE_IN_PICTURE, CUSTOM ...)
     */
    public $recordingLayout;

    /**
     * @var string $resolution
     * Resolution of the recorded file. Only defined if outputMode is COMPOSED and hasVideo is true
     * A string with the width and height of the video file in pixels. e.g. "1280x720"
     */
    public $resolution;

    /**
     * @var int $size
     * The size of the video file. 0 until status is stopped
     * Bytes
     */
    public $size;

    /**
     * @var int $duration
     * Duration of the video file. 0 until status is stopped
     * Seconds
     */
    public $duration;

    /**
     * @var string $status
     * Status of the recording
     * ["started","stopped","ready","failed"]
     */
    public $status;

    /**
     * @var $reason
     * Why the recording stopped. Only defined when status is stopped or ready
     * ["recordingStoppedByServer","lastParticipantLeft","sessionClosedByServer","automaticStop","openviduServerStopped","mediaServerDisconnect"]
     */
    public $reason;

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
        $this->startTime = property_exists($data, 'startTime') ? $data->startTime : null;;
        $this->id = property_exists($data, 'id') ? $data->id : null;
        $this->name = property_exists($data, 'name') ? $data->name : null;
        $this->outputMode = property_exists($data, 'outputMode') ? $data->outputMode : null;
        $this->hasAudio = property_exists($data, 'hasAudio') ? $data->hasAudio : null;
        $this->hasVideo = property_exists($data, 'hasVideo') ? $data->hasVideo : null;
        $this->recordingLayout = property_exists($data, 'recordingLayout') ? $data->recordingLayout : null;
        $this->resolution = property_exists($data, 'resolution') ? $data->resolution : null;
        $this->size = property_exists($data, 'size') ? $data->size : null;
        $this->duration = property_exists($data, 'duration') ? $data->duration : null;
        $this->status = property_exists($data, 'status') ? $data->status : null;
        $this->reason = property_exists($data, 'reason') ? $data->reason : null;
        $this->event = $data->event;
    }
}