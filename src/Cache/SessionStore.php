<?php

namespace SquareetLabs\LaravelOpenVidu\Cache;

use Closure;
use Exception;
use Illuminate\Cache\RetrievesMultipleKeys;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Database\PostgresConnection;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\InteractsWithTime;
use Illuminate\Support\Str;
use Throwable;

class SessionStore implements Store
{
    use InteractsWithTime, RetrievesMultipleKeys;

    /**
     * The database connection instance.
     *
     * @var ConnectionInterface
     */
    protected $connection;

    /**
     * The name of the cache table.
     *
     * @var string
     */
    protected $table;

    /**
     * Create a new database store.
     *
     * @param  ConnectionInterface  $connection
     * @param  string  $table
     */
    public function __construct(ConnectionInterface $connection, $table)
    {
        $this->table = $table;
        $this->connection = $connection;
    }

    /**
     * Update an item from the cache by key.
     *
     * @param  string  $key
     * @param $value
     * @return mixed
     */
    public function update($key, $value)
    {
        if ($this->table()->where('key', '=', $key)->exists()) {
            $value = $this->serialize($value);
            $this->table()->where('key', $key)->update(compact('value'));
            return $this->get($key);
        }
        return;
    }

    /**
     * Get a query builder for the cache table.
     *
     * @return Builder
     */
    protected function table()
    {
        return $this->connection->table($this->table);
    }

    /**
     * Serialize the given value.
     *
     * @param  mixed  $value
     * @return string
     */
    protected function serialize($value)
    {
        $result = serialize($value);

        if ($this->connection instanceof PostgresConnection && Str::contains($result, "\0")) {
            $result = base64_encode($result);
        }

        return $result;
    }

    /**
     * Retrieve an item from the cache by key.
     *
     * @param  string  $key
     * @return mixed
     */
    public function get($key)
    {
        $cache = $this->table()->where('key', '=', $key)->first();
        // If we have a cache record we will check the expiration time against current
        // time on the system and see if the record has expired. If it has, we will
        // remove the records from the database table so it isn't returned again.
        if (is_null($cache)) {
            return;
        }

        $cache = is_array($cache) ? (object) $cache : $cache;

        // If this cache expiration date is past the current time, we will remove this
        // item from the cache. Then we will return a null value since the cache is
        // expired. We will use "Carbon" to make this comparison with the column.
        if ($this->currentTime() >= $cache->expiration) {
            $this->forget($key);

            return;
        }

        return $this->unserialize($cache->value);
    }

    /**
     * Remove an item from the cache.
     *
     * @param  string  $key
     * @return bool
     */
    public function forget($key)
    {
        $this->table()->where('key', '=', $key)->delete();

        return true;
    }

    /**
     * Unserialize the given value.
     *
     * @param  string  $value
     * @return mixed
     */
    protected function unserialize($value)
    {
        if ($this->connection instanceof PostgresConnection && !Str::contains($value, [':', ';'])) {
            $value = base64_decode($value);
        }

        return unserialize($value);
    }

    /**
     * Retrieve all items from the cache.
     *
     * @return mixed
     */
    public function getAll()
    {

        $cache = $this->table()->get();

        // If we have a cache record we will check the expiration time against current
        // time on the system and see if the record has expired. If it has, we will
        // remove the records from the database table so it isn't returned again.
        if (is_null($cache)) {
            return;
        }

        $cache = is_array($cache) ? (object) $cache : $cache;
        // If this cache expiration date is past the current time, we will remove this
        // item from the cache. Then we will return a null value since the cache is
        // expired. We will use "Carbon" to make this comparison with the column.
        $entries = [];
        foreach ($cache as $entry) {
            if ($this->currentTime() >= $entry->expiration) {
                $this->forget($entry->key);
            } else {
                $entries[] = $this->unserialize($entry->value);
            }


        }
        return $entries;
    }

    /**
     * Increment the value of an item in the cache.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return int|bool
     * @throws Throwable
     */
    public function increment($key, $value = 1)
    {
        return $this->incrementOrDecrement($key, $value, function ($current, $value) {
            return $current + $value;
        });
    }

    /**
     * Increment or decrement an item in the cache.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @param  Closure  $callback
     * @return int|bool
     * @throws Throwable
     */
    protected function incrementOrDecrement($key, $value, Closure $callback)
    {
        return $this->connection->transaction(function () use ($key, $value, $callback) {


            $cache = $this->table()->where('key', $key)
                ->lockForUpdate()->first();

            // If there is no value in the cache, we will return false here. Otherwise the
            // value will be decrypted and we will proceed with this function to either
            // increment or decrement this value based on the given action callbacks.
            if (is_null($cache)) {
                return false;
            }

            $cache = is_array($cache) ? (object) $cache : $cache;

            $current = $this->unserialize($cache->value);

            // Here we'll call this callback function that was given to the function which
            // is used to either increment or decrement the function. We use a callback
            // so we do not have to recreate all this logic in each of the functions.
            $new = $callback((int) $current, $value);

            if (!is_numeric($current)) {
                return false;
            }

            // Here we will update the values in the table. We will also encrypt the value
            // since database cache values are encrypted by default with secure storage
            // that can't be easily read. We will return the new value after storing.
            $this->table()->where('key', $key)->update([
                'value' => $this->serialize($new),
            ]);

            return $new;
        });
    }

    /**
     * Decrement the value of an item in the cache.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return int|bool
     * @throws Throwable
     */
    public function decrement($key, $value = 1)
    {
        return $this->incrementOrDecrement($key, $value, function ($current, $value) {
            return $current - $value;
        });
    }

    /**
     * Store an item in the cache indefinitely.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return bool
     */
    public function forever($key, $value)
    {
        return $this->put($key, $value, 315360000);
    }

    /**
     * Store an item in the cache for a given number of seconds.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @param  int  $seconds
     * @return bool
     */
    public function put($key, $value, $seconds)
    {

        $value = $this->serialize($value);

        $expiration = $this->getTime() + $seconds;

        try {
            return $this->table()->insert(compact('key', 'value', 'expiration'));
        } catch (Exception $e) {
            $result = $this->table()->where('key', $key)->update(compact('value', 'expiration'));

            return $result > 0;
        }
    }

    /**
     * Get the current system time.
     *
     * @return int
     */
    protected function getTime()
    {
        return $this->currentTime();
    }

    /**
     * Remove all items from the cache.
     *
     * @return bool
     */
    public function flush()
    {
        $this->table()->delete();

        return true;
    }

    /**
     * Get the underlying database connection.
     *
     * @return ConnectionInterface
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * Get the cache key prefix.
     *
     * @return string
     */
    public function getPrefix()
    {
        return '';
    }

    /**
     * Retrieve multiple items from the cache by key.
     *
     * Items not found in the cache will have a null value.
     *
     * @param  array  $keys
     * @return void
     */
    public function many(array $keys)
    {
        // TODO: Implement many() method.
    }

    /**
     * Store multiple items in the cache for a given number of seconds.
     *
     * @param  array  $values
     * @param  int  $seconds
     * @return void
     */
    public function putMany(array $values, $seconds)
    {
        // TODO: Implement putMany() method.
    }
}
