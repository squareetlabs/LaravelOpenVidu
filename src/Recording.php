<?php

namespace SquareetLabs\LaravelOpenVidu;
use JsonSerializable;
use SquareetLabs\LaravelOpenVidu\Enums\MediaMode;
use SquareetLabs\LaravelOpenVidu\Enums\OutputMode;
use SquareetLabs\LaravelOpenVidu\Enums\RecordingLayout;
use SquareetLabs\LaravelOpenVidu\Enums\RecordingMode;
use SquareetLabs\LaravelOpenVidu\Enums\RecordingStatus;

/**
 * Class Recording
 * @package SquareetLabs\LaravelOpenVidu
 */
class Recording implements JsonSerializable
{

    /** @var  string */
    private $id;

    /** @var  string */
    private $sessionId;

    /** @var int */
    private $createdAt;

    /** @var int */
    private $size = 0;

    /** @var float */
    private $duration;

    /** @var string */
    private $url;

    /** @var RecordingStatus */
    private $status;


    /** @var RecordingProperties */
    private $recordingProperties;

    /**
     * Session constructor.
     * @param string $id
     * @param string $sessionId
     * @param string $createdAt
     * @param int $size
     * @param float $duration
     * @param string $url
     * @param RecordingProperties|null $recordingProperties
     */
    public function __construct(string $id, string $sessionId, string $createdAt, int $size, ?float $duration, ?string $url, ?RecordingProperties $recordingProperties = null)
    {
        $this->id = $id;
        $this->sessionId = $sessionId;
        $this->createdAt = $createdAt;
        $this->size = $size;
        $this->duration = $duration;
        $this->url = $url;
        $this->recordingProperties = $recordingProperties ? $recordingProperties : $this->getDefaultRecordingProperties();

    }

    /**
     * @return SessionProperties
     */
    private function getDefaultRecordingProperties(): SessionProperties
    {
        return new SessionProperties(MediaMode::ROUTED, RecordingMode::MANUAL, OutputMode::COMPOSED, RecordingLayout::BEST_FIT);
    }

    /**
     * Session associated to the recording
     * @return string
     */
    public function getSessionId(): string
    {
        return $this->sessionId;
    }

    /**
     * Time when the recording started in UTC milliseconds
     * @return int
     */
    public function getCreatedAt(): int
    {
        return $this->createdAt;
    }

    /**
     * Size of the recording in bytes (0 until the recording is stopped)
     * @return int
     */
    public function getSize(): int
    {
        return $this->size;
    }

    /**
     * Duration of the recording in seconds (0 until the recording is stopped)
     * @return float
     */
    public function getDuration(): float
    {
        return $this->duration;
    }

    /**
     * URL of the recording. You can access the file from there. It is
     * <code>null</code> until recording reaches "ready" or "failed" status. If
     * <a href="https://openvidu.io/docs/reference-docs/openvidu-server-params/"
     * target="_blank">OpenVidu Server configuration</a> property
     * <code>openvidu.recording.public-access</code> is false, this path will be
     * secured with OpenVidu credentials
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * Status of the recording
     * @return RecordingStatus
     */
    public function getStatus()
    {
        return $this->status;
    }


    /**
     * Technical properties of the recorded file
     * @return RecordingProperties
     */
    public function getRecordingProperties(): RecordingProperties
    {
        return $this->recordingProperties;
    }

    /**
     * Resolution of the video file. Only defined if OutputMode of the Recording is
     * set to {@see OutputMode::COMPOSED}
     */
    public function getResolution(): string
    {
        return $this->recordingProperties->resolution();
    }

    /**
     * <code>true</code> if the recording has an audio track, <code>false</code>
     * otherwise (currently fixed to true)
     */
    public function hasAudio(): bool
    {
        return $this->recordingProperties->hasAudio();
    }

    /**
     * <code>true</code> if the recording has a video track, <code>false</code>
     * otherwise (currently fixed to true)
     */
    public function hasVideo(): bool
    {
        return $this->recordingProperties->hasVideo();
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->getId();
    }

    /**
     * Recording unique identifier
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }


    /**
     * Convert the model instance to JSON.
     *
     * @param int $options
     * @return string
     *
     */
    public function toJson($options = 0): string
    {
        $json = json_encode($this->jsonSerialize(), $options);
        return $json;
    }

    /**
     * Specify data which should be serialized to JSON
     * @link https://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }

    /**
     * Convert the model instance to an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        $array = ['id' => $this->id, 'sessionId' => $this->sessionId, 'size' => $this->size, 'status' => $this->status,'duration' => $this->duration, 'resolution' => $this->getResolution(),  'hasAudio' => $this->hasAudio(), 'hasVideo' => $this->hasVideo(), 'url' => $this->url, 'createdAt' => $this->createdAt];
        foreach ($array as $key => $value) {
            if (is_null($value) || $value == '')
                unset($array[$key]);
        }
        return $array;
    }
}
