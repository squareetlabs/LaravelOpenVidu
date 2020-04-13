<?php

namespace SquareetLabs\LaravelOpenVidu;

use JsonSerializable;

/**
 * Class SignalProperties
 * @package SquareetLabs\LaravelOpenVidu
 */
class SignalProperties implements JsonSerializable
{
    /** @var  string */
    private $session;
    /** @var  string */
    private $to;
    /** @var  string */
    private $type;
    /** @var  string */
    private $data;

    /**
     * SignalProperties constructor.
     * @param string $session
     * @param string|null $data
     * @param string|null $type
     * @param string|null $to
     */
    public function __construct(string $session, ?string $data = null, ?string $type = null, ?string $to = null)
    {
        $this->session = $session;
        $this->data = $data;
        $this->type = $type;
        $this->to = $to;
    }

    /**
     * Session name of the recording
     *
     * @return string
     */
    public function session()
    {
        return $this->session;
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
        $array = [
            'session' => $this->session,
            'data' => $this->data,
            'type' => $this->type,
            'to' => $this->to
        ];
        foreach ($array as $key => $value) {
            if (is_null($value) || $value == '') {
                unset($array[$key]);
            }
        }
        return $array;
    }
}
