<?php

namespace SquareetLabs\LaravelOpenVidu;

use JsonSerializable;

/**
 * Class IPCameraOptions
 * @package SquareetLabs\LaravelOpenVidu
 */
class IPCameraOptions implements JsonSerializable, StreamInterface
{
    /** @var  string */
    private $rtspUri;
    /** @var  string */
    private $type;
    /** @var  bool */
    private $adaptativeBitrate;
    /** @var  bool */
    private $onlyPlayWithSubscribers;
    /** @var  string */
    private $data;

    /**
     * IPCameraOptions constructor.
     * @param  string  $rtspUri
     * @param  string|null  $type
     * @param  bool|null  $adaptativeBitrate
     * @param  bool|null  $onlyPlayWithSubscribers
     * @param  string|null  $data
     */
    public function __construct(string $rtspUri, ?string $type = null, ?bool $adaptativeBitrate = true, ?bool $onlyPlayWithSubscribers = true, ?string $data = null)
    {
        $this->rtspUri = $rtspUri;
        $this->type = $type;
        $this->adaptativeBitrate = $adaptativeBitrate;
        $this->onlyPlayWithSubscribers = $onlyPlayWithSubscribers;
        $this->data = $data;
    }

    /**
     * Convert the model instance to JSON.
     *
     * @param  int  $options
     * @return string
     *
     */
    public function toJson($options = 0): string
    {
        return json_encode($this->jsonSerialize(), $options);
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
        $array = ['rtspUri' => $this->rtspUri, 'type' => $this->type, 'adaptativeBitrate' => $this->adaptativeBitrate, 'onlyPlayWithSubscribers' => $this->onlyPlayWithSubscribers, 'data' => $this->data];
        foreach ($array as $key => $value) {
            if (is_null($value) || $value == '') {
                unset($array[$key]);
            }
        }
        return $array;
    }

    /** @return  string */
    public function getRtspUri()
    {
        return $this->rtspUri;
    }

    /** @return  string */
    public function getType()
    {
        return $this->type;
    }

    /** @return  bool */
    public function getAdaptativeBitrate()
    {
        return $this->adaptativeBitrate;
    }

    /** @return  bool */
    public function getOnlyPlayWithSubscribers()
    {
        return $this->onlyPlayWithSubscribers;
    }

    /** @return  string */
    public function getData()
    {
        return $this->data;
    }
}
