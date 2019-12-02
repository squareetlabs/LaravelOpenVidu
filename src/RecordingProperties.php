<?php

namespace SquareetLabs\LaravelOpenVidu;

use JsonSerializable;
use SquareetLabs\LaravelOpenVidu\Enums\OutputMode;
use SquareetLabs\LaravelOpenVidu\Enums\RecordingLayout;

/**
 * Class RecordingProperties
 * @package SquareetLabs\LaravelOpenVidu
 */
class RecordingProperties implements JsonSerializable
{
    /** @var  string */
    private $session;
    /** @var  string */
    private $customLayout;
    /** @var  bool */
    private $hasAudio;
    /** @var  bool */
    private $hasVideo;
    /** @var  string */
    private $name;
    /** @var  OutputMode */
    private $outputMode;
    /** @var  RecordingLayout */
    private $recordingLayout;
    /** @var  string */
    private $resolution;

    /**
     * RecordingProperties constructor.
     * @param string $session
     * @param bool $hasAudio
     * @param bool $hasVideo
     * @param string $name
     * @param string $outputMode
     * @param string $recordingLayout
     * @param string $resolution
     * @param string $customLayout
     */
    public function __construct(string $session, bool $hasAudio, bool $hasVideo, string $name, string $outputMode, string $recordingLayout, string $resolution, ?string $customLayout = null)
    {
        $this->session = $session;
        $this->hasAudio = $hasAudio;
        $this->hasVideo = $hasVideo;
        $this->name = $name;
        $this->outputMode = $outputMode;
        if ($this->outputMode === OutputMode::COMPOSED && $this->hasVideo) {
            $this->resolution = $resolution ? $resolution : '1920x1080';
            $this->recordingLayout = $recordingLayout ? $recordingLayout : RecordingLayout::BEST_FIT;

            if ($this->recordingLayout === RecordingLayout::CUSTOM) {
                $this->customLayout = $customLayout;
            }
        }
    }


    /**
     * Defines the name you want to give to the video file. You can access this same
     * value in your clients on recording events (<code>recordingStarted</code>,
     * <code>recordingStopped</code>)
     *
     * @return string
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * Defines the mode of recording: {@see OutputMode::COMPOSED} for a
     * single archive in a grid layout or {@@see OutputMode::INDIVIDUAL}
     * for one archive for each stream.<br>
     * <br>
     *
     * Default to {@see OutputMode::COMPOSED}
     *
     * @return OutputMode|string
     */
    public function outputMode()
    {
        return $this->outputMode;
    }

    /**
     * Defines the layout to be used in the recording.<br>
     * Will only have effect if has been cealled with value {@see OutputMode::COMPOSED}.<br>
     * <br>
     *
     * Default to {@see RecordingLayout#BEST_FIT}
     *
     * @return RecordingLayout|string
     */
    public function recordingLayout()
    {
        return $this->recordingLayout;
    }

    /**
     * If {@see RecordingProperties::$recordingLayout} is
     * set to {@see RecordingLayout::CUSTOM}, this property
     * defines the relative path to the specific custom layout you want to use.<br>
     * See <a href="https://openvidu.io/docs/advanced-features/recording#custom-recording-layouts" target="_blank">Custom recording layouts</a> to learn more
     *
     * @return string|null
     */
    public function customLayout()
    {
        return $this->customLayout;
    }

    /**
     * Defines the resolution of the recorded video.<br>
     * Will only have effect if has been called with value
     * {@see  outputMode::COMPOSED}. For
     * {@see  OutputMode::INDIVIDUAL} all
     * individual video files will have the native resolution of the published
     * stream.<br>
     * <br>
     *
     * Default to "1920x1080"
     * @return string
     */
    public function resolution(): string
    {
        return $this->resolution;
    }

    /**
     * Defines whether to record audio or not. Cannot be set to false at the same
     * time as {@see hasVideo()}.<br>
     * <br>
     *
     * Default to true
     *
     * @return bool
     */
    public function hasAudio()
    {
        return $this->hasAudio;
    }

    /**
     * Defines whether to record video or not. Cannot be set to false at the same
     * time as {@see hasAudio()}.<br>
     * <br>
     *
     * Default to true
     *
     * @return bool
     */
    public function hasVideo()
    {
        return $this->hasVideo;
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
        $array = ['session' => $this->session,
            'hasAudio' => $this->hasAudio,
            'hasVideo' => $this->hasVideo,
            'name' => $this->name,
            'outputMode' => $this->outputMode,
            'recordingLayout' => $this->recordingLayout,
            'resolution' => $this->resolution,
            'customLayout' => $this->customLayout];
        foreach ($array as $key => $value) {
            if (is_null($value) || $value == '')
                unset($array[$key]);
        }
        return $array;
    }
}
