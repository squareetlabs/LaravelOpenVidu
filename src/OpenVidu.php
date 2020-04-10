<?php

namespace SquareetLabs\LaravelOpenVidu;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Illuminate\Support\Facades\Cache;
use Psr\SimpleCache\InvalidArgumentException;
use SquareetLabs\LaravelOpenVidu\Builders\RecordingBuilder;
use SquareetLabs\LaravelOpenVidu\Enums\Uri;
use SquareetLabs\LaravelOpenVidu\Exceptions\OpenViduException;
use SquareetLabs\LaravelOpenVidu\Exceptions\OpenViduRecordingNotFoundException;
use SquareetLabs\LaravelOpenVidu\Exceptions\OpenViduRecordingResolutionException;
use SquareetLabs\LaravelOpenVidu\Exceptions\OpenViduRecordingStatusException;
use SquareetLabs\LaravelOpenVidu\Exceptions\OpenViduServerRecordingIsDisabledException;
use SquareetLabs\LaravelOpenVidu\Exceptions\OpenViduSessionCantRecordingException;
use SquareetLabs\LaravelOpenVidu\Exceptions\OpenViduSessionHasNotConnectedParticipantsException;
use SquareetLabs\LaravelOpenVidu\Exceptions\OpenViduSessionNotFoundException;

/**
 * Class OpenVidu
 * @package App\SquareetLabs\LaravelOpenVidu
 */
class OpenVidu
{
    /**
     * @var Client
     */
    private $client;
    

    /**
     * @var
     */
    private $config;


    /**
     * SmsUp constructor.
     * @param  array  $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * @param  SessionProperties|null  $properties
     * @return Session
     * @throws Exceptions\OpenViduException
     */
    public function createSession(?SessionProperties $properties = null): Session
    {
        $session = new Session($this->client(), $properties);
        Cache::store('openvidu')->forever($session->getSessionId(), $session->toJson());
        return $session;
    }
    
    /**
     * @param Client $client
     * @return OpenVidu
     */
    public function setClient(Client $client)
    {
        $this->client = $client;
        return $this;
    }

    /**
     * @return Client
     */
    private function client(): Client
    {
        if($this->client){
            return $this->client;
        }
        
        $client = new Client([
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
            'auth' => [
                $this->config['app'], $this->config['secret']
            ],
            'base_uri' => $this->config['domain'].':'.$this->config['port'],
            'debug' => $this->config['debug'],
            'http_errors' => false,
            'verify' => false
        ]);
        return $client;
    }

    /**
     * Starts the recording of a {@see Session}
     * @param  RecordingProperties  $properties
     * @return Recording
     * @throws OpenViduException
     * @throws OpenViduRecordingResolutionException
     * @throws OpenViduServerRecordingIsDisabledException
     * @throws OpenViduSessionCantRecordingException
     * @throws OpenViduSessionHasNotConnectedParticipantsException
     * @throws OpenViduSessionNotFoundException
     * @throws InvalidArgumentException
     * @throws Exceptions\OpenViduInvalidArgumentException
     */
    public function startRecording(RecordingProperties $properties): Recording
    {
        $activeSession = $this->getSession($properties->session());
        if ($activeSession->isBeingRecorded()) {
            $lastRecordingId = $activeSession->getLastRecordingId();
            if (!$lastRecordingId) {
                throw new OpenViduSessionCantRecordingException("The session is not configured for using media routed or has recording problems");
            }
            return $this->getRecording($lastRecordingId);
        }
        $response = $this->client()->post(Uri::RECORDINGS_START, [
            RequestOptions::JSON => $properties->toArray() ?? null
        ]);
        switch ($response->getStatusCode()) {
            case 200:
                $recording = RecordingBuilder::build(json_decode($response->getBody()->getContents(), true));
                
                if ($activeSession != null) {
                    $activeSession->setIsBeingRecorded(true);
                    $activeSession->setLastRecordingId($recording->id);
                }
                return $recording;
            case 404:
                throw new OpenViduSessionNotFoundException();
                break;
            case 406:
                throw new OpenViduSessionHasNotConnectedParticipantsException();
                break;
            case 409:
                throw new OpenViduSessionCantRecordingException("The session is not configured for using media routed or it is already being recorded");
                break;
            case 422:
                throw new OpenViduRecordingResolutionException();
                break;
            case 501:
                throw new OpenViduServerRecordingIsDisabledException();
                break;
            default:
                throw new OpenViduException("Invalid response status code ".$response->getStatusCode(), $response->getStatusCode());
        }
    }

    /**
     * Gets an existing {@see Session}
     * @param  string  $sessionId
     * @return Session
     * @throws OpenViduException
     * @throws OpenViduSessionNotFoundException
     * @throws InvalidArgumentException
     */
    public function getSession(string $sessionId): Session
    {
        if (Cache::store('openvidu')->has($sessionId)) {
            return (new Session($this->client()))->fromJson(Cache::store('openvidu')->get($sessionId));
        }
        throw new OpenViduSessionNotFoundException();
    }


    /**
     * Check if exists {@see Session}
     * @param  string  $sessionId
     * @return bool
     * @throws InvalidArgumentException
     */
    public function existsSession(string $sessionId): bool
    {
        return Cache::store('openvidu')->has($sessionId);
    }

    /**
     * Stops the recording of a {@see Session}
     * @param  string  $recordingId  The `id` property of the {@see Recording} you want to stop
     * @return Recording
     * @throws OpenViduException
     * @throws OpenViduRecordingNotFoundException
     * @throws OpenViduRecordingStatusException
     * @throws OpenViduSessionNotFoundException
     * @throws InvalidArgumentException
     * @throws Exceptions\OpenViduInvalidArgumentException
     */
    public function stopRecording(string $recordingId): Recording
    {        
        $response = $this->client()->post(Uri::RECORDINGS_STOP.'/'.$recordingId);
        switch ($response->getStatusCode()) {
            case 200:
                $recording = RecordingBuilder::build(json_decode($response->getBody()->getContents(), true));
                $activeSession = $this->getSession($recording->getSessionId());
                if ($activeSession != null) {
                    $activeSession->setIsBeingRecorded(false);
                    $activeSession->setLastRecordingId(null);
                }
                return $recording;
            case 404:
                throw new OpenViduRecordingNotFoundException();
                break;
            case 406:
                throw new OpenViduRecordingStatusException("The recording has `starting` status. Wait until `started` status before stopping the recording.");
                break;
            default:
                throw new OpenViduException("Invalid response status code ".$response->getStatusCode(), $response->getStatusCode());
        }
    }

    /**
     * Gets an existing {@see Recording}
     * @param  string  $recordingId  The `id` property of the {@see Recording} you want to retrieve
     * @return string
     * @throws OpenViduException
     * @throws OpenViduRecordingNotFoundException
     * @throws Exceptions\OpenViduInvalidArgumentException
     */
    public function getRecording(string $recordingId)
    {
        $response = $this->client()->get(Uri::RECORDINGS_URI.'/'.$recordingId);
        switch ($response->getStatusCode()) {
            case 200:
                $recording = RecordingBuilder::build(json_decode($response->getBody()->getContents(), true));
                return $recording;
            case 404:
                throw new OpenViduRecordingNotFoundException();
                break;
            default:
                throw new OpenViduException("Invalid response status code ".$response->getStatusCode(), $response->getStatusCode());
        }
    }

    /**
     * Gets an array with all existing recordings
     * @return array
     * @throws OpenViduException
     * @throws Exceptions\OpenViduInvalidArgumentException
     */
    public function getRecordings(): array
    {
        $recordings = [];
        $response = $this->client()->get(Uri::RECORDINGS_URI);
        switch ($response->getStatusCode()) {
            case 200:
                $items = json_decode($response->getBody()->getContents(), true);
                foreach ($items as $item) {
                    $recordings[] = RecordingBuilder::build($item);
                }
                return $recordings;
            default:
                throw new OpenViduException("Invalid response status code ".$response->getStatusCode(), $response->getStatusCode());
        }
    }


    /**
     * Deletes a {@see Recording}. The recording must have status `stopped`, `ready` or `failed`
     * @param  string  $recordingId  The `id` property of the {@see Recording} you want to delete
     * @return bool
     * @throws OpenViduException
     * @throws OpenViduRecordingNotFoundException
     * @throws OpenViduRecordingStatusException
     */
    public function deleteRecording(string $recordingId): bool
    {
        $response = $this->client()->delete(Uri::RECORDINGS_URI.'/'.$recordingId);

        switch ($response->getStatusCode()) {
            case 200:
                return true;
            case 404:
                throw new OpenViduRecordingNotFoundException();
                break;
            case 409:
                throw new OpenViduRecordingStatusException("The recording has `started` status. Stop it before deletion.");
                break;
            default:
                throw new OpenViduException("Invalid response status code ".$response->getStatusCode(), $response->getStatusCode());
        }
    }

    /**
     * Returns the list of active sessions. <strong>This value will remain unchanged
     * since the last time method {@link SquareetLabs\LaravelOpenVidu#fetch()}
     * was called</strong>. Exceptions to this rule are:
     * <ul>
     * <li>Calling {@see Session::fetch} updates that
     * specific Session status</li>
     * <li>Calling {@see Session::close()} automatically
     * removes the Session from the list of active Sessions</li>
     * <li>Calling
     * {@see Session::forceDisconnect(string)}
     * automatically updates the inner affected connections for that specific
     * Session</li>
     * <li>Calling {@see Session::forceUnpublish(string)}
     * also automatically updates the inner affected connections for that specific
     * Session</li>
     * <li>Calling {@see OpenVidu::startRecording(string)}
     * and {@see LaravelOpenVidu::stopRecording(string)}
     * automatically updates the recording status of the Session
     * </ul>
     * <br>
     * To get the list of active sessions with their current actual value, you must
     * call first {@see OpenVidu::fetch()} and then
     * {@see OpenVidu::getActiveSessions()}
     * @throws OpenViduException
     */
    public function getActiveSessions(): array
    {
        try {
            return Cache::store('openvidu')->getAll();
        } catch (Exception $e) {
            throw new OpenViduException("Make sure you have correctly configured the openvidu cache driver.", 500);
        }
    }
}

