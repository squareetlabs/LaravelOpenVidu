<?php

namespace SquareetLabs\LaravelOpenVidu;

use JsonSerializable;

/**
 * Class TokenOptions
 * @package SquareetLabs\LaravelOpenVidu
 */
class TokenOptions implements JsonSerializable
{
    /** @var  string */
    private $data;
    /** @var  string */
    private $role;

    /**
     * TokenOptions constructor.
     * @param string $role
     * @param string $data
     */
    public function __construct(string $role, ?string $data = null)
    {
        $this->role = $role;
        $this->data = $data;
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
        $array = ['role' => $this->role, 'data' => $this->data];
        foreach ($array as $key => $value) {
            if (is_null($value) || $value == '')
                unset($array[$key]);
        }
        return $array;
    }

}
