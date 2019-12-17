<?php

namespace SquareetLabs\LaravelOpenVidu;

use JsonSerializable;
use SquareetLabs\LaravelOpenVidu\Enums\OpenViduRole;

/**
 * Class Connection
 * @package SquareetLabs\LaravelOpenVidu
 */
class Connection implements JsonSerializable
{

    /** @var  string
     * Identifier of the connection. You can call [[Session.forceDisconnect]] passing this property as parameter
     */
    private $connectionId;

    /** @var int
     * Timestamp when this connection was established, in UTC milliseconds (ms since Jan 1, 1970, 00:00:00 UTC)
     */
    private $createdAt;


    /** @var  string
     * Role of the connection {@see OpenViduRole}
     */
    private $role;


    /** @var string
     * Token associated to the connection
     */
    private $token;

    /** @var string
     * <a href="/docs/openvidu-pro/" target="_blank" style="display: inline-block; background-color: rgb(0, 136, 170); color: white; font-weight: bold; padding: 0px 5px; margin-right: 5px; border-radius: 3px; font-size: 13px; line-height:21px; font-family: Montserrat, sans-serif">PRO</a>
     * Geo location of the connection, with the following format: `"CITY, COUNTRY"` (`"unknown"` if it wasn't possible to locate it)
     */
    private $location;

    /** @var string
     * A complete description of the platform used by the participant to connect to the session
     */
    private $platform;

    /** @var string
     * Data associated to the connection on the server-side. This value is set with {@uses TokenOptions::$data} when calling {@see Session::generateToken()}
     */
    private $serverData;

    /** @var string
     * Data associated to the connection on the client-side. This value is set with second parameter of method
     * {@method Session.connect}(/api/openvidu-browser/classes/session.html#connect) in OpenVidu Browser
     */
    private $clientData;

    /** @var array
     * Array of Publisher objects this particular Connection is publishing to the Session (each Publisher object has one Stream, uniquely
     * identified by its `streamId`). You can call {@uses Session::forceUnpublish} passing any of this values as parameter
     */
    private $publishers = [];

    /** @var array
     *  Array of streams (their `streamId` properties) this particular Connection is subscribed to. Each one always corresponds to one
     * Publisher of some other Connection: each string of this array must be equal to one [[Publisher.streamId]] of other Connection
     */
    private $subscribers = [];

    /**
     * Connection constructor.
     * @param string $connectionId
     * @param int $createdAt
     * @param string $role
     * @param string $token
     * @param string $location
     * @param string $platform
     * @param string $serverData
     * @param string $clientData
     * @param array $publishers
     * @param array $subscribers
     */
    public function __construct(string $connectionId, int $createdAt, string $role, string $token, string $location, string $platform, string $serverData, string $clientData, array $publishers, array $subscribers)
    {
        $this->connectionId = $connectionId;
        $this->createdAt = $createdAt;
        $this->role = $role;
        $this->token = $token;
        $this->location = $location;
        $this->platform = $platform;
        $this->serverData = $serverData;
        $this->clientData = $clientData;
        $this->publishers = $publishers;
        $this->subscribers = $subscribers;

    }

    /**
     * @return string
     */
    public function getRole(): string
    {
        return $this->role;
    }

    /**
     * @return int
     */
    public function getCreatedAt(): int
    {
        return $this->createdAt;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @return string
     */
    public function getLocation(): string
    {
        return $this->location;
    }

    /**
     * @return string
     */
    public function getPlatform(): string
    {
        return $this->platform;
    }

    /**
     * @return string
     */
    public function getServerData(): string
    {
        return $this->serverData;
    }

    /**
     * @return string
     */
    public function getClientData(): string
    {
        return $this->clientData;
    }

    /**
     * @return array
     */
    public function getPublishers(): array
    {
        return $this->publishers;
    }

    /**
     * @return array
     */
    public function getSubscribers(): array
    {
        return $this->subscribers;
    }

    public function __toString(): string
    {
        return $this->getConnectionId();
    }

    /**
     * @return string
     */
    public function getConnectionId(): string
    {
        return $this->connectionId;
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
        $array = ['connectionId' => $this->connectionId,
            'createdAt' => $this->createdAt,
            'role' => $this->role,
            'token' => $this->token,
            'location' => $this->location,
            'platform' => $this->platform,
            'serverData' => $this->serverData,
            'clientData' => $this->clientData,
            'subscribers' => $this->subscribers];
        foreach ($this->publishers as $publisher) {
            $array['publishers'][] = $publisher->toArray();
        }


        foreach ($array as $key => $value) {
            if (is_null($value) || $value == '')
                unset($array[$key]);
        }
        return $array;
    }

    /**
     * @param Connection $other
     * @return bool
     */
    public function equal(Connection $other): bool
    {
        $equals = (
            $this->connectionId === $other->connectionId &&
            $this->createdAt === $other->createdAt &&
            $this->role === $other->role &&
            $this->token === $other->token &&
            $this->location === $other->location &&
            $this->platform === $other->platform &&
            $this->serverData === $other->serverData &&
            $this->clientData === $other->clientData &&
            count($this->subscribers) === count($other->subscribers) &&
            count($this->publishers) === count($other->publishers));

        if ($equals) {
            $equals = json_encode($this->subscribers) === json_encode($other->subscribers);
            if ($equals) {
                $i = 0;
                while ($equals && $i < count($this->publishers)) {
                    $equals = $this->publishers[$i]->equalTo($other->publishers[$i]);
                    $i++;
                }
                return $equals;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
