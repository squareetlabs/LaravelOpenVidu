<?php

namespace SquareetLabs\LaravelOpenVidu;

use GuzzleHttp\Exception\GuzzleException;
use SquareetLabs\LaravelOpenVidu\Enums\MediaMode;
use SquareetLabs\LaravelOpenVidu\Enums\OutputMode;
use SquareetLabs\LaravelOpenVidu\Enums\RecordingLayout;
use SquareetLabs\LaravelOpenVidu\Enums\RecordingMode;
use SquareetLabs\LaravelOpenVidu\Exceptions\OpenViduSessionCantCreateException;

/**
 * Class Recording
 * @package SquareetLabs\LaravelOpenVidu
 */
class Recording
{

    /** @var  string */
    private $id;

    /** @var  string */
    private $sessionId;

    /** @var int */
    private $createdAt;

    /** @var int */
    private $size;

    /** @var float */
    private $duration;

    /** @var string */
    private $url;

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
     * @return string
     */
    public function getSessionId(): string
    {
        return $this->sessionId;
    }

    /**
     * @return int
     */
    public function getCreatedAt(): int
    {
        return $this->createdAt;
    }

    /**
     * @return int
     */
    public function getSize(): int
    {
        return $this->size;
    }

    /**
     * @return float
     */
    public function getDuration(): float
    {
        return $this->duration;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return RecordingProperties
     */
    public function getRecordingProperties(): RecordingProperties
    {
        return $this->recordingProperties;
    }

    /**
     * Resolution of the video file. Only defined if OutputMode of the Recording is
     * set to {@link io.openvidu.java.client.Recording.OutputMode#COMPOSED}
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
     * @throws OpenViduSessionCantCreateException
     * @throws GuzzleException
     */
    public function __toString(): string
    {
        return $this->getId();
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }


}
