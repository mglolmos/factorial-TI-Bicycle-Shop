<?php
namespace App\Tests\E2e;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\RequestOptions;
use PHPUnit\Framework\TestCase;


class ProductTest extends TestCase
{
    private Client $client;

    public function setUp(): void
    {
        $this->client = new Client(['headers' => ['Content-Type' => 'application/json']]);
    }

    public function testCreateAndGetProduct(): void
    {
        $response = $this->client->post('http://nginx/product', [
            RequestOptions::FORM_PARAMS => [
                    'product_id' => '1',
                    'name' => 'Product Test'
            ],
        ]);

        $this->assertEquals(201, $response->getStatusCode());

        $queryParams = ['product_id' => '1'];
        $response = $this->client->get('http://nginx/product', ['query' => $queryParams]);
        $this->assertEquals(200, $response->getStatusCode());

        $body = $response->getBody();
        $data = json_decode($body, true);
        $this->assertEquals('1', $data['product_id']);
        $this->assertEquals('Product Test', $data['name']);
    }

    public function testProductNotFoundShouldAnswer404(): void
    {
        try {
            $queryParams = ['product_id' => '100'];
            $this->client->get('http://nginx/product', ['query' => $queryParams]);
        } catch (RequestException $exception) {
            $this->assertEquals(404, $exception->getResponse()->getStatusCode());
            return;
        }

        $this->fail('Expected a 404 Not Found response, but the request was successful.');
    }




}