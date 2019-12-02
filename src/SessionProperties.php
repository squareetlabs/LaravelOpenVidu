<?php

namespace SquareetLabs\LaravelOpenVidu;

use InvalidArgumentException;
use JsonSerializable;
use SquareetLabs\LaravelOpenVidu\Enums\OutputMode;
use SquareetLabs\LaravelOpenVidu\Enums\RecordingLayout;
use SquareetLabs\LaravelOpenVidu\Enums\RecordingMode;

/**
 * Class SessionProperties
 * @package SquareetLabs\LaravelOpenVidu
 */
class SessionProperties implements JsonSerializable
{
    /** @var  string */
    private $mediaMode;

    /** @var  string
     * {@see RecordingMode}
     */
    private $recordingMode;
    /** @var  string
     * {@see OutputMode}
     */
    private $defaultOutputMode;
    /** @var  string
     * {@see RecordingLayout}
     */
    private $defaultRecordingLayout;

    /** @var  string */
    private $defaultCustomLayout;

    /** @var  string */
    private $customSessionId;


    /**
     * SessionProperties constructor.
     * @param string $mediaMode
     * @param string $recordingMode
     * @param string $defaultOutputMode
     * @param string $defaultRecordingLayout
     * @param string $defaultCustomLayout
     * @param string $customSessionId
     */
    public function __construct(string $mediaMode, string $recordingMode, string $defaultOutputMode, ?string $defaultRecordingLayout, ?string $customSessionId = null, ?string $defaultCustomLayout = null)
    {
        if ($defaultRecordingLayout == RecordingLayout::CUSTOM && empty($defaultCustomLayout)) {
            throw new InvalidArgumentException("If you pass the value \"CUSTOM\" for the parameter \"$defaultRecordingLayout\" you must indicate a value for the parameter \"$defaultCustomLayout\".");
        }
        $this->mediaMode = $mediaMode;
        $this->recordingMode = $recordingMode;
        $this->defaultOutputMode = $defaultOutputMode;
        $this->defaultRecordingLayout = $defaultRecordingLayout;
        $this->defaultCustomLayout = $defaultCustomLayout;
        $this->customSessionId = $customSessionId;
    }

    /**
     * @return string
     */
    public function getCustomSessionId(): string
    {
        return $this->customSessionId;
    }

    /**
     * @return string
     */
    public function getMediaMode(): string
    {
        return $this->mediaMode;
    }

    /**
     * @return string
     */
    public function getRecordingMode(): string
    {
        return $this->recordingMode;
    }

    /**
     * @return string
     */
    public function getDefaultOutputMode(): string
    {
        return $this->defaultOutputMode;
    }

    /**
     * @return string
     */
    public function getDefaultRecordingLayout(): string
    {
        return $this->defaultRecordingLayout;
    }

    /**
     * @return string
     */
    public function getDefaultCustomLayout(): string
    {
        return $this->defaultCustomLayout;
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
        $array = ['mediaMode' => $this->mediaMode,
            'recordingMode' => $this->recordingMode,
            'defaultOutputMode' => $this->defaultOutputMode,
            'defaultRecordingLayout' => $this->defaultRecordingLayout,
            'defaultCustomLayout' => $this->defaultCustomLayout,
            'customSessionId' => $this->customSessionId];
        foreach ($array as $key => $value) {
            if (is_null($value) || $value == '')
                unset($array[$key]);
        }
        return $array;
    }
}
