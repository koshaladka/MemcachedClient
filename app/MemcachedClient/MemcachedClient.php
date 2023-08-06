<?php

namespace App\MemcachedClient;

class MemcachedClient
{
    private $socket;

    public function __construct()
    {
        $this->socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        if ($this->socket === false) {
            throw new \RuntimeException("Failed to create socket");
        }

        $connected = @socket_connect($this->socket, 'memcached', 11211); // Замена '127.0.0.1' на 'memcached'
        if (!$connected) {
            throw new \RuntimeException("Failed to connect to Memcached server");
        }
    }

    public function set($key, $value, $expiry)
    {
        $command = "set $key 0 $expiry " . strlen($value) . "\r\n$value\r\n";
        socket_write($this->socket, $command, strlen($command));

        $response = socket_read($this->socket, 1024);
        // Обработка ответа сервера Memcached

        if (strpos($response, 'STORED') === false) {
            throw new \RuntimeException("Failed to set value in Memcached");
        }
    }

    public function get($key)
    {
        $command = "get $key\r\n";
        socket_write($this->socket, $command, strlen($command));

        $response = socket_read($this->socket, 1024);
        // Обработка ответа сервера Memcached и извлечение значения

        if (preg_match("/^VALUE\s+$key\s+\d+\s+(\d+)\r\n(.*)\r\nEND\r\n/s", $response, $matches)) {
            $valueLength = (int) $matches[1];
            $value = substr($matches[2], 0, $valueLength);
            return $value;
        } else {
            return false; // Ключ не найден
        }
    }

    public function delete($key)
    {
        $command = "delete $key\r\n";
        socket_write($this->socket, $command, strlen($command));

        $response = socket_read($this->socket, 1024);
        // Обработка ответа сервера Memcached

        if (strpos($response, 'DELETED') === false) {
            throw new \RuntimeException("Failed to delete value from Memcached");
        }
    }

    public function __destruct()
    {
        socket_close($this->socket);
    }
}
