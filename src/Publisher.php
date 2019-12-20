<?php

namespace SquareetLabs\LaravelOpenVidu;

use JsonSerializable;

/**
 * Class Connection
 * @package SquareetLabs\LaravelOpenVidu
 * This is a backend representation of a published media stream (see [OpenVidu Browser Stream class](/api/openvidu-browser/classes/stream.html)
 * {@see Connection::getPublishers()}
 */
class Publisher implements JsonSerializable
{

    /** @var  string
     * Unique identifier of the Stream {@link https://api/openvidu-browser/classes/stream.html} associated to this Publisher.
     * Each Publisher is paired with only one Stream, so you can identify each Publisher by its
     * Stream.streamId {@link https://api/openvidu-browser/classes/stream.html#streamid}
     */
    private $streamId;

    /** @var int
     * Timestamp when this connection was established, in UTC milliseconds (ms since Jan 1, 1970, 00:00:00 UTC)
     */
    private $createdAt;


    /** @var bool
     * See properties of Stream {@link https://api/openvidu-browser/classes/stream.html} object in OpenVidu Browser library to find out more
     */
    private $hasAudio;


    /** @var  bool
     * See properties of Stream {@link https://api/openvidu-browser/classes/stream.html}object in OpenVidu Browser library to find out more
     */
    private $hasVideo;


    /** @var  bool
     * See properties of Stream {@link https://api/openvidu-browser/classes/stream.html} object in OpenVidu Browser library to find out more
     */
    private $audioActive;


    /** @var  bool
     * See properties of Stream {@link https://api/openvidu-browser/classes/stream.html} object in OpenVidu Browser library to find out more
     */
    private $videoActive;


    /**
     * @var int
     * See properties of Stream {@link https://api/openvidu-browser/classes/stream.html} object in OpenVidu Browser library to find out more
     */
    private $frameRate;


    /**
     * @var string
     * See properties of Stream {@link https://api/openvidu-browser/classes/stream.html} object in OpenVidu Browser library to find out more
     */
    private $typeOfVideo;


    /**
     * var string
     * See properties of Stream {@link https://api/openvidu-browser/classes/stream.html} object in OpenVidu Browser library to find out more
     */
    private $videoDimensions;


    /**
     * Publisher constructor.
     * @param string $streamId
     * @param int $createdAt
     * @param bool $hasAudio
     * @param bool $hasVideo
     * @param bool $audioActive
     * @param bool $videoActive
     * @param int $frameRate
     * @param string $typeOfVideo
     * @param string $videoDimensions
     */
    public function __construct(string $streamId, int $createdAt, bool $hasAudio, bool $hasVideo, bool $audioActive, bool $videoActive, int $frameRate, string $typeOfVideo, string $videoDimensions)
    {
        $this->streamId = $streamId;
        $this->createdAt = $createdAt;
        $this->hasAudio = $hasAudio;
        $this->hasVideo = $hasVideo;
        $this->audioActive = $audioActive;
        $this->videoActive = $videoActive;
        $this->frameRate = $frameRate;
        $this->typeOfVideo = $typeOfVideo;
        $this->videoDimensions = $videoDimensions;

    }

    /**
     * @return int
     */
    public function getCreatedAt(): int
    {
        return $this->createdAt;
    }

    /**
     * @return bool
     */
    public function hasAudio(): bool
    {
        return $this->hasAudio;
    }

    /**
     * @return bool
     */
    public function hasVideo(): bool
    {
        return $this->hasVideo;
    }

    /**
     * @return bool
     */
    public function isAudioActive(): bool
    {
        return $this->audioActive;
    }

    /**
     * @return bool
     */
    public function isVideoActive(): bool
    {
        return $this->videoActive;
    }

    /**
     * @return int
     */
    public function getFrameRate(): int
    {
        return $this->frameRate;
    }

    /**
     * @return string
     */
    public function getTypeOfVideo(): string
    {
        return $this->typeOfVideo;
    }

    /**
     * @return string
     */
    public function getVideoDimensions(): string
    {
        return $this->videoDimensions;
    }

    public function __toString(): string
    {
        return $this->getStreamId();
    }

    /**
     * @return string
     */
    public function getStreamId(): string
    {
        return $this->streamId;
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
        $array = ['streamId' => $this->streamId,
            'createdAt' => $this->createdAt,
            'hasAudio' => $this->hasAudio,
            'hasVideo' => $this->hasVideo,
            'audioActive' => $this->audioActive,
            'videoActive' => $this->videoActive,
            'frameRate' => $this->frameRate,
            'typeOfVideo' => $this->typeOfVideo,
            'videoDimensions' => $this->videoDimensions];
        foreach ($array as $key => $value) {
            if (is_null($value) || $value == '')
                unset($array[$key]);
        }
        return $array;
    }

    /**
     * @param Publisher $other
     * @return bool
     */
    public function equalTo(Publisher $other): bool
    {
        return (
            $this->streamId === $other->getStreamId() &&
            $this->createdAt === $other->getCreatedAt() &&
            $this->hasAudio === $other->hasAudio() &&
            $this->hasVideo === $other->hasVideo() &&
            $this->audioActive === $other->isAudioActive() &&
            $this->videoActive === $other->isVideoActive() &&
            $this->frameRate === $other->getFrameRate() &&
            $this->typeOfVideo === $other->getTypeOfVideo() &&
            $this->videoDimensions === $other->getVideoDimensions()
        );
    }
}
