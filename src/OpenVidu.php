<?php

namespace SquareetLabs\LaravelOpenVidu;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use SquareetLabs\LaravelOpenVidu\Builders\RecordingBuilder;
use SquareetLabs\LaravelOpenVidu\Enums\Uri;
use SquareetLabs\LaravelOpenVidu\Events\SessionDeleted;
use SquareetLabs\LaravelOpenVidu\Exceptions\OpenViduException;

/**
 * Class LaravelOpenVidu
 * @package App\SquareetLabs\LaravelOpenVidu
 */
class OpenVidu
{

    /**
     * @var
     */
    private $config;
    /**
     * Array of active sessions. **This value will remain unchanged since the last time method [[LaravelOpenVidu.fetch]]
     * was called**. Exceptions to this rule are:
     *
     * - Calling [[Session.fetch]] updates that specific Session status
     * - Calling [[Session.close]] automatically removes the Session from the list of active Sessions
     * - Calling [[Session.forceDisconnect]] automatically updates the inner affected connections for that specific Session
     * - Calling [[Session.forceUnpublish]] also automatically updates the inner affected connections for that specific Session
     * - Calling [[LaravelOpenVidu.startRecording]] and [[LaravelOpenVidu.stopRecording]] automatically updates the recording status of the
     * Session ([[Session.recording]])
     *
     * To get the array of active sessions with their current actual value, you must call [[LaravelOpenVidu.fetch]] before consulting
     * property [[activeSessions]]
     */
    private $activeSessions;

    /**
     * SmsUp constructor.
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * @param SessionProperties|null $properties
     * @return Session
     * @throws Exceptions\OpenViduSessionCantCreateException
     * @throws Exceptions\OpenViduException
     */
    public function createSession(?SessionProperties $properties = null): Session
    {
        $session = new Session($this->client(), $properties);
        $this->activeSessions[$session->getSessionId()] = $session;
        return $session;
    }

    /**
     * @return Client
     */
    private function client(): Client
    {
        $client = new Client([
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
            'auth' => [
                $this->config['app'], $this->config['secret']
            ],
            'base_uri' => $this->config['domain'] . ':' . $this->config['port'],
            'debug' => $this->config['debug'],
            'http_errors' => false,
            'verify' => false
        ]);
        return $client;
    }

    /**
     * Starts the recording of a {@link io.openvidu.java.client.Session}
     *
     * @param RecordingProperties The configuration for this recording
     *   <ul>
     *   <li><code>404</code>: no session exists for the passed <i>sessionId</i></li>
     *   <li><code>406</code>: the session has no connected participants</li>
     *   <li><code>422</code>: "resolution" parameter exceeds acceptable values (for both width and height, min 100px and max 1999px) or trying to start a recording with both "hasAudio" and "hasVideo" to false</li>
     *   <li><code>409</code>: the session is not configured for using {@link SquareetLabs\LaravelOpenVidu\Enums\MediaMode#ROUTED} or it is already being recorded</li>
     *   <li><code>501</code>: OpenVidu Server recording module is disabled (<i>openvidu.recording</i> property set to <i>false</i>)</li>
     *   </ul>
     * @return Recording
     * @throws OpenViduException
     */
    public function startRecording(?RecordingProperties $properties = null): Recording
    {
        $response = $this->client()->post(Uri::RECORDINGS_START, [
            RequestOptions::JSON => $properties->toArray()
        ]);
        if ($response->getStatusCode() == 200) {
            $recording = RecordingBuilder::build(json_decode($response->getBody()->getContents()));
            $activeSession = $this->getSession($recording->getSessionId());
            if ($activeSession != null) {
                $activeSession->setIsBeingRecorded(true);
            }
            return $recording;
        } else {
            $result = json_decode($response->getBody()->getContents());
            if ($result && isset($result['message'])) {
                throw new OpenViduException($result['message'], $response->getStatusCode());
            }
            throw new OpenViduException("Invalid response status code " . $response->getStatusCode(), $response->getStatusCode());
        }
    }

    public function getSession(string $sessionId): ?Session
    {
        if (array_key_exists($sessionId, $this->activeSessions)) {
            return $this->activeSessions[$sessionId];
        }
        return null;
    }

    /**
     * @param string $recordingId
     * @return Recording
     * @throws OpenViduException
     */
    public function stopRecording(string $recordingId): Recording
    {
        $response = $this->client()->post(Uri::RECORDINGS_STOP . '/' . $recordingId);
        if ($response->getStatusCode() == 200) {
            $recording = RecordingBuilder::build(json_decode($response->getBody()->getContents()));
            $activeSession = $this->getSession($recording->getSessionId());
            if ($activeSession != null) {
                $activeSession->setIsBeingRecorded(false);
            }
            return $recording;
        } else {
            $result = json_decode($response->getBody()->getContents());
            if ($result && isset($result['message'])) {
                throw new OpenViduException($result['message'], $response->getStatusCode());
            }
            throw new OpenViduException("Invalid response status code " . $response->getStatusCode(), $response->getStatusCode());
        }
    }

    /**
     * @param string $recordingId
     * @return Recording
     * @throws OpenViduException
     */
    public function getRecording(string $recordingId): string
    {
        $response = $this->client()->get(Uri::RECORDINGS_URI . '/' . $recordingId);
        if ($response->getStatusCode() == 200) {
            $recording = RecordingBuilder::build(json_decode($response->getBody()->getContents()));
            return $recording;
        } else {
            $result = json_decode($response->getBody()->getContents());
            if ($result && isset($result['message'])) {
                throw new OpenViduException($result['message'], $response->getStatusCode());
            }
            throw new OpenViduException("Invalid response status code " . $response->getStatusCode(), $response->getStatusCode());
        }
    }

    /**
     * @return array
     * @throws OpenViduException
     */
    public function getRecordings(): array
    {
        $recordings = [];
        $response = $this->client()->get(Uri::RECORDINGS_URI);
        if ($response->getStatusCode() == 200) {
            $items = json_decode($response->getBody()->getContents());
            foreach ($items as $item) {
                $recordings[] = RecordingBuilder::build($item);
            }
            return $recordings;
        } else {
            $result = json_decode($response->getBody()->getContents());
            if ($result && isset($result['message'])) {
                throw new OpenViduException($result['message'], $response->getStatusCode());
            }
            throw new OpenViduException("Invalid response status code " . $response->getStatusCode(), $response->getStatusCode());
        }
    }

    /**
     * @param string $recordingId
     * @return bool
     * @throws OpenViduException
     */
    public function deleteRecording(string $recordingId): bool
    {
        $response = $this->client()->delete(Uri::RECORDINGS_URI . '/' . $recordingId);
        if ($response->getStatusCode() != 200) {
            $result = json_decode($response->getBody()->getContents());
            if ($result && isset($result['message'])) {
                throw new OpenViduException($result['message'], $response->getStatusCode());
            }
            throw new OpenViduException("Invalid response status code " . $response->getStatusCode(), $response->getStatusCode());
        } else return true;
    }

    /**
     * Returns the list of active sessions. <strong>This value will remain unchanged
     * since the last time method {@link SquareetLabs\LaravelOpenVidu#fetch()}
     * was called</strong>. Exceptions to this rule are:
     * <ul>
     * <li>Calling {@link io.openvidu.java.client.Session#fetch()} updates that
     * specific Session status</li>
     * <li>Calling {@link io.openvidu.java.client.Session#close()} automatically
     * removes the Session from the list of active Sessions</li>
     * <li>Calling
     * {@link SquareetLabs\LaravelOpenVidu\Session#forceDisconnect(Connection)}
     * automatically updates the inner affected connections for that specific
     * Session</li>
     * <li>Calling {@link SquareetLabs\LaravelOpenVidu\Session#forceUnpublish(Publisher)}
     * also automatically updates the inner affected connections for that specific
     * Session</li>
     * <li>Calling {@link io.openvidu.java.client.OpenVidu#startRecording(String)}
     * and {@link SquareetLabs\LaravelOpenVidu#stopRecording(String)}
     * automatically updates the recording status of the Session
     * ({@link SquareetLabs\LaravelOpenVidu\Session#isBeingRecorded()})</li>
     * </ul>
     * <br>
     * To get the list of active sessions with their current actual value, you must
     * call first {@link SquareetLabs\LaravelOpenVidu#fetch()} and then
     * {@link SquareetLabs\LaravelOpenVidu#getActiveSessions()}
     */
    public function getActiveSessions(): array
    {
        return array_values($this->activeSessions);
    }

    /**
     * Handle the event.
     * @param SessionDeleted $event
     */
    public function handle(SessionDeleted $event)
    {
        unset($this->activeSessions[$event->sessionId]);
    }
}

