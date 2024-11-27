<?php
namespace App\Tests\E2e;

use App\Domain\Utilities\Uuid;
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
        $product_id = Uuid::generateToString();
        $product_name = 'Product Test' . $product_id;
        $response = $this->client->post('http://nginx/product', [
            RequestOptions::FORM_PARAMS => [
                'product_id' => $product_id,
                'name' => $product_name
            ],
        ]);

        $this->assertEquals(201, $response->getStatusCode());

        $response = $this->client->get('http://nginx/product/' . $product_id);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals($product_id, self::getOutputFromResponse($response, 'product_id'));
        $this->assertEquals($product_name, self::getOutputFromResponse($response, 'name'));
    }

    public function testProductNotFoundShouldAnswer404(): void
    {
        try {
            $product_id = Uuid::generateToString();
            $this->client->get('http://nginx/product/' . $product_id);
        } catch (RequestException $exception) {
            $this->assertEquals(404, $exception->getResponse()->getStatusCode());
            return;
        }

        $this->fail('Expected a 404 Not Found response, but the request was successful.');
    }

    public function testAddAndGetCollection(): void
    {
        $product_id = $this->createProduct();
        $collection_name = 'Collection name';

        $response = $this->client->post('http://nginx/product/' . $product_id . '/collection', [
            RequestOptions::FORM_PARAMS => [
                'name' => $collection_name
            ],
        ]);
        $this->assertEquals(201, $response->getStatusCode());
        $this->assertEquals($product_id, self::getOutputFromResponse($response, 'product_id'));
        $this->assertEquals('collection_name', self::getOutputFromResponse($response, 'collection_id') );
        $this->assertEquals($collection_name, self::getOutputFromResponse($response, 'collection_name') );

        $collection_id = self::getOutputFromResponse($response, 'collection_id');

        $response = $this->client->get('http://nginx/product/' . $product_id . '/collection/' . $collection_id);
        $this->assertEquals($collection_id, self::getOutputFromResponse($response, 'collection_id') );
        $this->assertEquals($collection_name, self::getOutputFromResponse($response, 'collection_name') );
    }

    public function testGetAndGetComponent(): void
    {
        $product_id = $this->createProduct();
        $collection_id = $this->addCollection($product_id, 'Collection Test');
        $component_name = 'Component name';
        $component_price = 100;

        $response = $this->client->post('http://nginx/product/' . $product_id . '/collection/' . $collection_id . '/component', [
            RequestOptions::FORM_PARAMS => [
                'name' => $component_name,
                'price' => $component_price
            ],
        ]);

        $this->assertEquals(201, $response->getStatusCode());
        $this->assertEquals($product_id, self::getOutputFromResponse($response, 'product_id'));
        $this->assertEquals('component_name', self::getOutputFromResponse($response, 'component_id') );
        $this->assertEquals($component_name, self::getOutputFromResponse($response, 'component_name') );

        $component_id = self::getOutputFromResponse($response, 'component_id');

        $response = $this->client->get('http://nginx/product/' . $product_id . '/collection/' . $collection_id . '/component/' . $component_id);
        $this->assertEquals($component_id, self::getOutputFromResponse($response, 'component_id') );
        $this->assertEquals($component_name, self::getOutputFromResponse($response, 'component_name') );
        $this->assertEquals($component_price, self::getOutputFromResponse($response, 'component_price') );
        $this->assertEquals(true, self::getOutputFromResponse($response, 'component_is_in_stock') );
    }

    private function createProduct()
    {
        $product_id = Uuid::generateToString();
        $product_name = 'Product Test' . $product_id;
        $this->client->post('http://nginx/product', [
            RequestOptions::FORM_PARAMS => [
                'product_id' => $product_id,
                'name' => $product_name
            ],
        ]);

        $response = $this->client->get('http://nginx/product/'. $product_id);

        return self::getOutputFromResponse($response, 'product_id');
    }

    private function addCollection($product_id, $collection_name)
    {
        $response = $this->client->post('http://nginx/product/' . $product_id . '/collection', [
            RequestOptions::FORM_PARAMS => [
                'name' => $collection_name
            ],
        ]);

        $collection_id = self::getOutputFromResponse($response, 'collection_id');
        $response = $this->client->get('http://nginx/product/' . $product_id . '/collection/' . $collection_id);

        return self::getOutputFromResponse($response, 'collection_id');
    }

    private static function getOutputFromResponse($response, $key)
    {
        $body = $response->getBody();
        $data = json_decode($body, true);
        return $data[$key];
    }
}