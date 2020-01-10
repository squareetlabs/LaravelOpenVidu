<?php

namespace SquareetLabs\LaravelOpenVidu;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Illuminate\Support\Facades\Cache;
use JsonSerializable;
use SquareetLabs\LaravelOpenVidu\Builders\ConnectionBuilder;
use SquareetLabs\LaravelOpenVidu\Builders\PublisherBuilder;
use SquareetLabs\LaravelOpenVidu\Builders\SessionPropertiesBuilder;
use SquareetLabs\LaravelOpenVidu\Enums\MediaMode;
use SquareetLabs\LaravelOpenVidu\Enums\OpenViduRole;
use SquareetLabs\LaravelOpenVidu\Enums\OutputMode;
use SquareetLabs\LaravelOpenVidu\Enums\RecordingLayout;
use SquareetLabs\LaravelOpenVidu\Enums\RecordingMode;
use SquareetLabs\LaravelOpenVidu\Enums\Uri;
use SquareetLabs\LaravelOpenVidu\Exceptions\OpenViduConnectionNotFoundException;
use SquareetLabs\LaravelOpenVidu\Exceptions\OpenViduException;
use SquareetLabs\LaravelOpenVidu\Exceptions\OpenViduSessionNotFoundException;
use SquareetLabs\LaravelOpenVidu\Exceptions\OpenViduTokenCantCreateException;

/**
 * Class Session
 * @package SquareetLabs\LaravelOpenVidu
 */
class Session implements JsonSerializable
{
    /** @var  Client */
    private $client;

    /** @var  string */
    private $sessionId;

    /** @var SessionProperties */
    private $properties;

    /** @var bool */
    private $recording;

    /** @var array */
    private $activeConnections = [];

    /** @var int */
    private $createdAt;

    /**
     * Session constructor.
     * @param  Client  $client
     * @param  SessionProperties|null  $properties
     * @throws OpenViduException
     */
    public function __construct(Client $client, ?SessionProperties $properties = null)
    {
        $this->client = $client;
        $this->properties = $properties ? $properties : new SessionProperties(MediaMode::ROUTED, RecordingMode::MANUAL, OutputMode::COMPOSED, RecordingLayout::BEST_FIT);
        $this->sessionId = $this->getSessionId();
    }

    /**
     * @return string
     * @throws OpenViduException
     */
    public function getSessionId()
    {
        if (empty($this->sessionId)) {
            $response = $this->client->post(Uri::SESSION_URI, [
                RequestOptions::JSON => $this->properties->toArray()
            ]);
            switch ($response->getStatusCode()) {
                case 200:
                    return json_decode($response->getBody()->getContents())->id;
                case 409:
                    return $this->properties->getCustomSessionId();
                default:
                    throw new OpenViduException("Invalid response status code ".$response->getStatusCode(), $response->getStatusCode());
            }
        } else {
            return $this->sessionId;
        }
    }

    /**
     ** Gets a new token associated to Session object with default values for
     * {@see TokenOptions}. This always translates into a
     * new request to OpenVidu Server
     *
     * @param  TokenOptions|null  $tokenOptions
     * @return string The generated token
     * @throws OpenViduException
     */
    public function generateToken(?TokenOptions $tokenOptions = null)
    {
        $this->getSessionId();
        try {
            if (!$tokenOptions) {
                $tokenOptions = new TokenOptions(OpenViduRole::PUBLISHER);;
            }
            $response = $this->client->post(Uri::TOKEN_URI, [
                RequestOptions::JSON => array_merge($tokenOptions->toArray(), ['session' => $this->sessionId])
            ]);
            return json_decode($response->getBody()->getContents());
        } catch (Exception $e) {
            throw new OpenViduTokenCantCreateException($e->getMessage(), $e);
        }
    }

    /**
     * Gracefully closes the Session: unpublishes all streams and evicts every
     * participant
     * @throws OpenViduException
     */
    public function close()
    {
        $response = $this->client->delete(Uri::SESSION_URI.'/'.$this->sessionId);
        switch ($response->getStatusCode()) {
            case 204:
                Cache::store('openvidu')->forget($this->sessionId);
                return true;
            case 404:
                throw new OpenViduSessionNotFoundException();
                break;
            default:
                throw new OpenViduException("Invalid response status code ".$response->getStatusCode(), $response->getStatusCode());
        }
    }

    /**
     * Updates every property of the Session with the current status it has in
     * OpenVidu Server. This is especially useful for getting the list of active
     * connections to the Session
     * ({@see getActiveConnections()}) and use
     * those values to call
     * {@see forceDisconnect(Connection)} or
     * {@link forceUnpublish(Publisher)}. <br>
     *
     * To update every Session object owned by OpenVidu object, call
     * {@see fetch()}
     *
     * @return bool true if the Session status has changed with respect to the server,
     * false if not. This applies to any property or sub-property of the object
     */

    public function fetch()
    {
        $response = $this->client->get(Uri::SESSION_URI.'/'.$this->sessionId, [
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
                'Accept' => 'application/json',
            ]
        ]);
        if ($response->getStatusCode() === 200) {
            $beforeJSON = $this->toJson();
            $this->fromJson($response->getBody()->getContents());
            $afterJSON = $this->toJson();
            if ($beforeJSON !== $afterJSON) {
                Cache::store('openvidu')->update($this->sessionId, $this->toJson());
                return true;
            }
        }
        return false;
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
        $array = ['sessionId' => $this->sessionId, 'properties' => $this->properties->toArray(), 'recording' => $this->recording, 'createdAt' => $this->createdAt];
        foreach ($this->activeConnections as $connection) {
            $array['activeConnections'][] = $connection->toArray();
        }

        foreach ($array as $key => $value) {
            if (is_null($value) || $value == '') {
                unset($array[$key]);
            }
        }
        return $array;
    }

    /**
     * @param  string  $json
     * @return Session
     */
    public function fromJson(string $json): Session
    {
        return $this->fromArray(json_decode($json, true));
    }

    /**
     * @param  array  $sessionArray
     * @return Session
     */
    public function fromArray(array $sessionArray): Session
    {
        $this->sessionId = $sessionArray['sessionId'];
        $this->createdAt = $sessionArray['createdAt'] ?? null;
        $this->recording = $sessionArray['recording'] ?? null;

        if (array_key_exists('properties', $sessionArray)) {
            $this->properties = SessionPropertiesBuilder::build($sessionArray['properties']);
        }

        $this->activeConnections = [];
        if (array_key_exists('connections', $sessionArray)) {
            foreach ($sessionArray['connections'] as $connection) {
                $publishers = [];
                $ensure = $connection['content'] ?? $connection;
                foreach ($ensure['publishers'] as $publisher) {
                    $publishers[] = PublisherBuilder::build($publisher);
                }
                $subscribers = [];
                foreach ($ensure->subscribers as $subscriber) {
                    $subscribers[] = $subscriber->streamId;
                }
                $this->activeConnections[] = ConnectionBuilder::build($ensure, $publishers, $subscribers);
            }
        }
        return $this;
    }

    /**
     * Forces the user with Connection `connectionId` to leave the session. OpenVidu Browser will trigger the proper events on the client-side
     * (`streamDestroyed`, `connectionDestroyed`, `sessionDisconnected`) with reason set to `"forceDisconnectByServer"`
     *
     *
     * @param  string  $connectionId
     * @throws OpenViduException
     */
    public function forceDisconnect(string $connectionId)
    {
        $response = $this->client->delete(Uri::SESSION_URI.'/'.$this->sessionId.'/connection/'.$connectionId, [
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
                'Accept' => 'application/json',
            ]
        ]);
        switch ($response->getStatusCode()) {
            case 204:
                $this->leaveSession($connectionId);
                Cache::store('openvidu')->update($this->sessionId, $this->toJson());
                break;
            case 400:
                throw new OpenViduSessionNotFoundException();
                break;
            case 404:
                throw new OpenViduConnectionNotFoundException();
                break;
            default:
                throw new OpenViduException("Invalid response status code ".$response->getStatusCode(), $response->getStatusCode());
        }
    }

    /**
     * Get `connection` parameter from activeConnections array {@see Connection::getConnectionId()} for getting each `connectionId` property).
     * Remember to call {@see fetch()} before to fetch the current actual properties of the Session from OpenVidu Server
     * @param  string  $connectionId
     */

    private function leaveSession(string $connectionId)
    {
        $connectionClosed = null;
        $this->activeConnections = array_filter($this->activeConnections, function (Connection $connection) use (&$connectionClosed, $connectionId) {
            if ($connection->getConnectionId() !== $connectionId) {
                return true;
            }
            $connectionClosed = $connection;
            return false;
        });
        if ($connectionClosed != null) {
            foreach ($connectionClosed->getPublishers() as $publisher) {
                foreach ($this->activeConnections as $con) {
                    $con->unsubscribe($publisher->getStreamId());
                }
            }
        }
    }

    /**
     * Forces some user to unpublish a Stream. OpenVidu Browser will trigger the
     * proper events on the client-side (<code>streamDestroyed</code>) with reason
     * set to "forceUnpublishByServer". <br>
     *
     * You can get <code>streamId</code> parameter with
     * {@see Session::getActiveConnections()} and then for
     * each Connection you can call
     * {@see  Connection::getPublishers()}. Finally
     * {@see Publisher::getStreamId()}) will give you the
     * <code>streamId</code>. Remember to call
     * {@see fetch()} before to fetch the current
     * actual properties of the Session from OpenVidu Server
     *
     * @param  string  $streamId
     * @return void
     * @throws OpenViduConnectionNotFoundException
     * @throws OpenViduException
     * @throws OpenViduSessionNotFoundException
     */
    public function forceUnpublish(string $streamId)
    {
        $response = $this->client->delete(Uri::SESSION_URI.'/'.$this->sessionId.'/stream/'.$streamId, [
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
                'Accept' => 'application/json',
            ]
        ]);
        switch ($response->getStatusCode()) {
            case 204:
                foreach ($this->activeConnections as $connection) {
                    $connection->unpublish($streamId);
                    $connection->unsubscribe($streamId);
                }
                Cache::store('openvidu')->update($this->sessionId, $this->toJson());
                break;
            case 400:
                throw new OpenViduSessionNotFoundException();
                break;
            case 404:
                throw new OpenViduConnectionNotFoundException();
                break;
            default:
                throw new OpenViduException("Invalid response status code ".$response->getStatusCode(), $response->getStatusCode());
        }
    }

    /**
     * Returns the list of active connections to the session. <strong>This value
     * will remain unchanged since the last time method
     * {@see fetch()} was called</strong>.
     * Exceptions to this rule are:
     * <ul>
     * <li>Calling {@see Session::forceUnpublish(string)}
     * updates each affected Connection status</li>
     * <li>Calling {@see Session::forceDisconnect(string)}
     * updates each affected Connection status</li>
     * </ul>
     * <br>
     * To get the list of active connections with their current actual value, you
     * must call first {@see Session::fetch()} and then
     * {@see Session::getActiveConnections()}
     */
    public function getActiveConnections(): array
    {
        return $this->activeConnections;
    }

    /**
     * Returns whether the session is being recorded or not
     */
    public function isBeingRecorded(): bool
    {
        return $this->recording;
    }

    /**
     * Set value
     * @param  bool  $recording
     */
    public function setIsBeingRecorded(bool $recording)
    {
        $this->recording = $recording;
        Cache::store('openvidu')->update($this->sessionId, $this->toJson());
    }

    /**
     * @return string
     * @throws OpenViduException
     */
    public function __toString(): string
    {
        return $this->getSessionId();
    }
}
