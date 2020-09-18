<?php

namespace SquareetLabs\LaravelOpenVidu;

use JsonSerializable;

/**
 * Class Subscriber
 * @package SquareetLabs\LaravelOpenVidu
 * This is a backend representation of a published media stream (see [OpenVidu Browser Stream class](/api/openvidu-browser/classes/stream.html)
 * {@see Connection::getPublishers()}
 */
class Subscriber implements JsonSerializable
{

    /** @var  string
     * Unique identifier of the Stream {@link https://api/openvidu-browser/classes/stream.html} associated to this Subscriber.
     */
    private $streamId;

    /** @var  string
     * Unique identifier of the Stream {@link https://api/openvidu-browser/classes/stream.html} associated to the Publisher.
     * Each Publisher is paired with only one Stream, so you can identify each Publisher by its
     * Stream.streamId {@link https://api/openvidu-browser/classes/stream.html#streamid}
     */
    private $publisherStreamId;

    /** @var int
     * Timestamp when this connection was established, in UTC milliseconds (ms since Jan 1, 1970, 00:00:00 UTC)
     */
    private $createdAt;

    /**
     * Publisher constructor.
     * @param  string  $streamId
     * @param  string  $publisherStreamId
     * @param  int  $createdAt
     */
    public function __construct(string $streamId, string $publisherStreamId, int $createdAt)
    {
        $this->streamId = $streamId;
        $this->publisherStreamId = $publisherStreamId;
        $this->createdAt = $createdAt;
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
     * @return string
     */
    public function getPublisherStreamId(): string
    {
        return $this->publisherStreamId;
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
        $array = [
            'streamId' => $this->streamId,
            'publisherStreamId' => $this->publisherStreamId,
            'createdAt' => $this->createdAt
        ];
        foreach ($array as $key => $value) {
            if (is_null($value) || $value == '') {
                unset($array[$key]);
            }
        }
        return $array;
    }

    /**
     * @param  Publisher  $other
     * @return bool
     */
    public function equalTo(Publisher $other): bool
    {
        return (
            $this->streamId === $other->getStreamId() &&
            $this->createdAt === $other->getCreatedAt() &&
            $this->publisherStreamId === $other->publisherStreamId()
        );
    }

    /**
     * @return int
     */
    public function getCreatedAt(): int
    {
        return $this->createdAt;
    }
}
