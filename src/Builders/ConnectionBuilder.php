<?php
/**
 * Created by theQuizProject <https://www.thequizproject.com>
 * Developer: Jacobo Cantorna Cigarrán <https://es.linkedin.com/in/jacobocantornacigarran>
 * Date: 20/12/2019
 * Time: 20:50
 */

namespace SquareetLabs\LaravelOpenVidu\Builders;


use SquareetLabs\LaravelOpenVidu\Connection;

class ConnectionBuilder
{
    /**
     * @param array $properties
     * @param array $publishers
     * @param array $subscribers
     * @return Connection
     */
    public static function build(array $properties, ?array $publishers = [], ?array $subscribers = [])
    {
        return new Connection($connectionArray['connectionId'] ?? null,
            $connectionArray['createdAt'] ?? null,
            $connectionArray['role'] ?? null,
            $connectionArray['token'] ?? null,
            $connectionArray['location'] ?? null,
            $connectionArray['platform'] ?? null,
            $connectionArray['serverData'] ?? null,
            $connectionArray['clientData'] ?? null,
            $publishers,
            $subscribers
        );
    }
}