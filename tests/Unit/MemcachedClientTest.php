<?php

namespace Tests\Unit;

use App\MemcachedClient\MemcachedClient;
use PHPUnit\Framework\TestCase;

class MemcachedClientTest extends TestCase
{
    public function test_set_and_get()
    {
        $client = new MemcachedClient();
        $client->set('key', 'xyz', 3600);

        $value = $client->get('key');

        $this->assertEquals('xyz', trim($value));
    }

    public function test_delete()
    {
        $client = new MemcachedClient();
        $client->set('key', 'xyz', 3600);

        $client->delete('key');

        $this->assertFalse($client->get('key'));
    }
}
