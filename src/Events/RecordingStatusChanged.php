<?php

namespace SquareetLabs\LaravelOpenVidu\Events;

use Illuminate\Queue\SerializesModels;

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
     * Create a new SessionCreated event instance.
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->sessionId = array_key_exists('sessionId', $data) ? $data['sessionId'] : null;
        $this->timestamp = array_key_exists('timestamp', $data) ? $data['timestamp'] : null;
        $this->participantId = array_key_exists('participantId', $data) ? $data['participantId'] : null;
        $this->startTime = array_key_exists('startTime', $data) ? $data['startTime'] : null;
        $this->id = array_key_exists('id', $data) ? $data['id'] : null;
        $this->name = array_key_exists('name', $data) ? $data['name'] : null;
        $this->outputMode = array_key_exists('outputMode', $data) ? $data['outputMode'] : null;
        $this->hasAudio = array_key_exists('hasAudio', $data) ? $data['hasAudio'] : null;
        $this->hasVideo = array_key_exists('hasVideo', $data) ? $data['hasVideo'] : null;
        $this->recordingLayout = array_key_exists('recordingLayout', $data) ? $data['recordingLayout'] : null;
        $this->resolution = array_key_exists('resolution', $data) ? $data['resolution'] : null;
        $this->size = array_key_exists('size', $data) ? $data['size'] : null;
        $this->duration = array_key_exists('duration', $data) ? $data['duration'] : null;
        $this->status = array_key_exists('status', $data) ? $data['status'] : null;
        $this->reason = array_key_exists('reason', $data) ? $data['reason'] : null;
        $this->event = $data['event'];
    }
}