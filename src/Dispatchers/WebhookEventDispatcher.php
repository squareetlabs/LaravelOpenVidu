<?php

namespace SquareetLabs\LaravelOpenVidu\Dispatchers;

use Illuminate\Support\Facades\Event;
use SquareetLabs\LaravelOpenVidu\Events\ParticipantJoined;
use SquareetLabs\LaravelOpenVidu\Events\ParticipantLeft;
use SquareetLabs\LaravelOpenVidu\Events\RecordingStatusChanged;
use SquareetLabs\LaravelOpenVidu\Events\SessionCreated;
use SquareetLabs\LaravelOpenVidu\Events\SessionDestroyed;
use SquareetLabs\LaravelOpenVidu\Events\WebRTCConnectionCreated;
use SquareetLabs\LaravelOpenVidu\Events\WebRTCConnectionDestroyed;

/**
 * Class WebhookEventFactory
 * @package SquareetLabs\LaravelOpenVidu\Factories
 */
class WebhookEventDispatcher
{
    public static function dispatch(array $webhookEvent)
    {
        switch ($webhookEvent['event']) {
            case 'sessionCreated':
                Event::dispatch(new SessionCreated($webhookEvent));
                break;
            case 'sessionDestroyed':
                Event::dispatch(new SessionDestroyed($webhookEvent));
                break;
            case 'participantJoined':
                Event::dispatch(new ParticipantJoined($webhookEvent));
                break;
            case 'participantLeft':
                Event::dispatch(new ParticipantLeft($webhookEvent));
                break;
            case 'webrtcConnectionCreated':
                Event::dispatch(new WebRTCConnectionCreated($webhookEvent));
                break;
            case 'webrtcConnectionDestroyed':
                Event::dispatch(new WebRTCConnectionDestroyed($webhookEvent));
                break;
            case 'recordingStatusChanged':
                Event::dispatch(new RecordingStatusChanged($webhookEvent));
                break;
        }
    }
}