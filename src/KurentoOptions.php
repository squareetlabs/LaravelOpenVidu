<?php

namespace SquareetLabs\LaravelOpenVidu;

use JsonSerializable;

/**
 * Class KurentoOptions
 * @package SquareetLabs\LaravelOpenVidu
 */
class KurentoOptions implements JsonSerializable
{
    /** @var  int */
    private $videoMaxRecvBandwidth;
    /** @var  int */
    private $videoMinRecvBandwidth;
    /** @var  int */
    private $videoMaxSendBandwidth;
    /** @var  int */
    private $videoMinSendBandwidth;
    /** @var  array */
    private $allowedFilters = [];

    /**
     * KurentoOptions constructor.
     * @param  int|null  $videoMaxRecvBandwidth
     * @param  int|null  $videoMinRecvBandwidth
     * @param  int|null  $videoMaxSendBandwidth
     * @param  int|null  $videoMinSendBandwidth
     * @param  array|null  $allowedFilters
     */
    public function __construct(?int $videoMaxRecvBandwidth = null, ?int $videoMinRecvBandwidth = null, ?int $videoMaxSendBandwidth = null, ?int $videoMinSendBandwidth = null, ?array $allowedFilters = null)
    {
        $this->videoMaxRecvBandwidth = $videoMaxRecvBandwidth;
        $this->videoMinRecvBandwidth = $videoMinRecvBandwidth;
        $this->videoMaxSendBandwidth = $videoMaxSendBandwidth;
        $this->videoMinSendBandwidth = $videoMinSendBandwidth;
        $this->allowedFilters = $allowedFilters;
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
        $array = ['videoMaxRecvBandwidth' => $this->videoMaxRecvBandwidth, 'videoMinRecvBandwidth' => $this->videoMinRecvBandwidth, 'videoMaxSendBandwidth' => $this->videoMaxSendBandwidth, 'videoMinSendBandwidth' => $this->videoMinSendBandwidth];
        foreach ($this->allowedFilters as $allowed_filter) {
            $array['allowedFilters'][] = $allowed_filter;
        }
        foreach ($array as $key => $value) {
            if (is_null($value) || $value == '') {
                unset($array[$key]);
            }
        }
        return $array;
    }

}
