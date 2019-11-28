<?php

namespace SquareetLabs\LaravelOpenVidu;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
use Illuminate\Support\Facades\Event;
use SquareetLabs\LaravelOpenVidu\Enums\MediaMode;
use SquareetLabs\LaravelOpenVidu\Enums\OpenViduRole;
use SquareetLabs\LaravelOpenVidu\Enums\OutputMode;
use SquareetLabs\LaravelOpenVidu\Enums\RecordingLayout;
use SquareetLabs\LaravelOpenVidu\Enums\RecordingMode;
use SquareetLabs\LaravelOpenVidu\Enums\Uri;
use SquareetLabs\LaravelOpenVidu\Events\SessionDeleted;
use SquareetLabs\LaravelOpenVidu\Exceptions\OpenViduException;
use SquareetLabs\LaravelOpenVidu\Exceptions\OpenViduSessionCantCloseException;
use SquareetLabs\LaravelOpenVidu\Exceptions\OpenViduSessionCantCreateException;
use SquareetLabs\LaravelOpenVidu\Exceptions\OpenViduTokenCantCreateException;

/**
 * Class Session
 * @package SquareetLabs\LaravelOpenVidu
 */
class Session
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
    private $activeConnections;


    /**
     * Session constructor.
     * @param Client $client
     * @param SessionProperties|null $properties
     * @throws OpenViduSessionCantCreateException
     * @throws OpenViduException
     */
    public function __construct(Client $client, ?SessionProperties $properties = null)
    {
        $this->client = $client;
        $this->properties = $properties ? $properties : $this->getDefaultSessionProperties();
        try {
            $this->sessionId = $this->getSessionId();
        } catch (OpenViduSessionCantCreateException $e) {
            throw $e;
        }
    }

    /**
     * @return SessionProperties
     */
    private function getDefaultSessionProperties(): SessionProperties
    {
        return new SessionProperties(MediaMode::ROUTED, RecordingMode::MANUAL, OutputMode::COMPOSED, RecordingLayout::BEST_FIT);
    }

    /**
     * @return string
     * @throws OpenViduSessionCantCreateException
     * @throws OpenViduException
     */
    public function getSessionId()
    {
        if (!$this->hasSessionId()) {
            $response = $this->client->post(Uri::SESSION_URI, [
                RequestOptions::JSON => $this->properties->toArray()
            ]);
            if ($response->getStatusCode() == 200) {
                return json_decode($response->getBody()->getContents())->id;
            } else if ($response->getStatusCode() == 409) {
                return $this->properties->getCustomSessionId();
            } else {
                $result = json_decode($response->getBody()->getContents());
                if ($result && isset($result['message'])) {
                    throw new OpenViduException($result['message'], $response->getStatusCode());
                }
                throw new OpenViduException("Invalid response status code " . $response->getStatusCode(), $response->getStatusCode());
            }
        }
    }

    /**
     * The following values are considered empty:
     * <ul><li>"" (an empty string)</li>
     * <li>0 (0 as an integer)</li>
     * <li>0.0 (0 as a float)</li>
     * <li>"0" (0 as a string)</li>
     * <li>NULL</li>
     * <li>FALSE </li>
     * <li>array() (an empty array)</li></ul>
     * @return bool
     */
    private function hasSessionId(): bool
    {
        return !empty($this->sessionId);
    }

    /**
     ** Gets a new token associated to Session object with default values for
     * {@link SquareetLabs\LaravelOpenVidu|TokenOptions}. This always translates into a
     * new request to OpenVidu Server
     *
     * @param TokenOptions|null $tokenOptions
     * @return string The generated token
     * @throws OpenViduException
     * @throws GuzzleException
     */
    public function generateToken(?TokenOptions $tokenOptions = null)
    {
        if (!$this->hasSessionId()) {
            $this->getSessionId();
        }
        try {
            if (!$tokenOptions) {
                $tokenOptions = $this->getDefaultTokenOptions();
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
     * @return TokenOptions
     */
    private function getDefaultTokenOptions(): TokenOptions
    {
        return new TokenOptions(OpenViduRole::PUBLISHER);
    }

    /**
     * Gracefully closes the Session: unpublishes all streams and evicts every
     * participant
     */
    public function close()
    {
        try {
            $response = $this->client->delete(Uri::SESSION_URI . '/' . $this->sessionId);
            if ($response->getStatusCode() === 200) {
                Event::fire(new SessionDeleted($this->sessionId));
            }
        } catch (Exception $e) {
            throw new OpenViduSessionCantCloseException("Could not close session", $e);
        }
    }

    /**
     * Returns the list of active connections to the session. <strong>This value
     * will remain unchanged since the last time method
     * {@link SquareetLabs\LaravelOpenVidu\Session#fetch()} was called</strong>.
     * Exceptions to this rule are:
     * <ul>
     * <li>Calling {@link SquareetLabs\LaravelOpenVidu\Session#forceUnpublish(String)}
     * updates each affected Connection status</li>
     * <li>Calling {@link SquareetLabs\LaravelOpenVidu\Session#forceDisconnect(String)}
     * updates each affected Connection status</li>
     * </ul>
     * <br>
     * To get the list of active connections with their current actual value, you
     * must call first {@link SquareetLabs\LaravelOpenVidu\Session#fetch()} and then
     * {@link SquareetLabs\LaravelOpenVidu\Session#f#getActiveConnections()}
     */
    public function activeConnections(): array
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
     * @param bool $recording
     */
    public function setIsBeingRecorded(bool $recording)
    {
        $this->recording = $recording;
    }

    /**
     * @return string
     * @throws OpenViduSessionCantCreateException
     * @throws GuzzleException
     * @throws OpenViduException
     */
    public function __toString(): string
    {
        return $this->getSessionId();
    }


    /**
     * Returns the properties defining the session
     */
    public function getProperties(): SessionProperties
    {
        return $this->properties;
    }
}
