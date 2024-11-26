<?php
namespace App\Tests\E2e;

use App\Domain\Utilities\Id;
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
        $product_id = Id::generateToString();
        $product_name = 'Product Test' . $product_id;
        $response = $this->client->post('http://nginx/product', [
            RequestOptions::FORM_PARAMS => [
                'product_id' => $product_id,
                'name' => $product_name
            ],
        ]);

        $this->assertEquals(201, $response->getStatusCode());

        $queryParams = ['product_id' => $product_id];
        $response = $this->client->get('http://nginx/product', ['query' => $queryParams]);
        $this->assertEquals(200, $response->getStatusCode());

        $body = $response->getBody();
        $data = json_decode($body, true);
        $this->assertEquals($product_id, $data['product_id']);
        $this->assertEquals($product_name, $data['name']);
    }

    public function testProductNotFoundShouldAnswer404(): void
    {
        try {
            $queryParams = ['product_id' => Id::generateToString()];
            $this->client->get('http://nginx/product', ['query' => $queryParams]);
        } catch (RequestException $exception) {
            $this->assertEquals(404, $exception->getResponse()->getStatusCode());
            return;
        }

        $this->fail('Expected a 404 Not Found response, but the request was successful.');
    }




}