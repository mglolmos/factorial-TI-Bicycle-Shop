<?php
namespace App\Tests\e2e;

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;


class CategoryTest extends TestCase
{
    private Client $client;

    public function setUp(): void
    {
        $this->client = new Client(['headers' => ['Content-Type' => 'application/json']]);
    }

    public function testCategory(): void
    {
        $response = $this->client->get('http://nginx/category');
        $this->assertEquals(200, $response->getStatusCode());

    }

}