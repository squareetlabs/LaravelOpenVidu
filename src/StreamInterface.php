<?php

namespace SquareetLabs\LaravelOpenVidu;


/**
 * Interface StreamInterface
 * @package SquareetLabs\LaravelOpenVidu
 */
interface StreamInterface
{
    /** @return  string */
    public function getRtspUri();

    /** @return  string */
    public function getType();

    /** @return  bool */
    public function getAdaptativeBitrate();

    /** @return  bool */
    public function getOnlyPlayWithSubscribers();

    /** @return  string */
    public function getData();
}