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
                new SessionCreated($object);
                break;
            case 'sessionDestroyed':
                new SessionDestroyed($object);
                break;
            case 'participantJoined':
                new ParticipantJoined($object);
                break;
            case 'participantLeft':
                new ParticipantLeft($object);
                break;
            case 'webrtcConnectionCreated':
                new WebRTCConnectionCreated($object);
                break;
            case 'webrtcConnectionDestroyed':
                new WebRTCConnectionDestroyed($object);
                break;
            case 'recordingStatusChanged':
                new RecordingStatusChanged($object);
                break;
        }
    }
}