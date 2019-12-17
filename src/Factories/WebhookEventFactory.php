<?php

namespace SquareetLabs\LaravelOpenVidu\Factories;

use SquareetLabs\LaravelOpenVidu\Events\ParticipantJoined;
use SquareetLabs\LaravelOpenVidu\Events\ParticipantLeft;
use SquareetLabs\LaravelOpenVidu\Events\RecordingStatusChanged;
use SquareetLabs\LaravelOpenVidu\Events\SessionCreated;
use SquareetLabs\LaravelOpenVidu\Events\SessionDestroyed;
use SquareetLabs\LaravelOpenVidu\Events\WebhookEventInterface;
use SquareetLabs\LaravelOpenVidu\Events\WebRTCConnectionCreated;
use SquareetLabs\LaravelOpenVidu\Events\WebRTCConnectionDestroyed;

/**
 * Class WebhookEventFactory
 * @package SquareetLabs\LaravelOpenVidu\Factories
 */
class WebhookEventFactory
{
    public static function create(string $webhookEvent): WebhookEventInterface
    {
        $object = json_decode($webhookEvent);
        switch ($object->event) {
            case 'sessionCreated':
                return new SessionCreated($object);
                break;
            case 'sessionDestroyed':
                return new SessionDestroyed($object);
                break;
            case 'participantJoined':
                return new ParticipantJoined($object);
                break;
            case 'participantLeft':
                return new ParticipantLeft($object);
                break;
            case 'webrtcConnectionCreated':
                return new WebRTCConnectionCreated($object);
                break;
            case 'webrtcConnectionDestroyed':
                return new WebRTCConnectionDestroyed($object);
                break;
            case 'recordingStatusChanged':
                return new RecordingStatusChanged($object);
                break;
        }
    }
}