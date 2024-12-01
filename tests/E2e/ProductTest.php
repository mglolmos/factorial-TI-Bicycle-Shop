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

    public function testCreateGetAndDeleteProduct(): void
    {
        // Arrange: Create product
        $product_id = Uuid::generateToString();
        $product_name = 'Product Test' . $product_id;
        // Act
        $response = $this->client->post('http://nginx/product', [
            RequestOptions::FORM_PARAMS => [
                'product_id' => $product_id,
                'name' => $product_name
            ],
        ]);
        // Assert
        $this->assertEquals(201, $response->getStatusCode());

        // Act: Get product
        $response = $this->client->get('http://nginx/product/' . $product_id);
        // Assert
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals($product_id, self::getOutputFromResponse($response, 'product_id'));
        $this->assertEquals($product_name, self::getOutputFromResponse($response, 'name'));

        // Act: Delete product
        $response = $this->client->delete('http://nginx/product/' . $product_id);
        // Assert
        $this->assertEquals(204, $response->getStatusCode());

        // Act: Get product, expected 404
        try {
             $this->client->get('http://nginx/product/' . $product_id);
        } catch (RequestException $exception) {
            // Assert
            $this->assertEquals(404, $exception->getResponse()->getStatusCode());
            return;
        }
        $this->fail('Expected a 404 Not Found response, but the request was successful.');
    }

    public function testProductNotFoundShouldAnswer404(): void
    {
        try {
            // Arrange
            $product_id = Uuid::generateToString();
            // Act: Get product, expected 404
            $this->client->get('http://nginx/product/' . $product_id);
        } catch (RequestException $exception) {
            // Assert
            $this->assertEquals(404, $exception->getResponse()->getStatusCode());
            return;
        }

        $this->fail('Expected a 404 Not Found response, but the request was successful.');
    }

    public function testAddAndGetCollection(): void
    {
        // Arrange
        $product_id = $this->createProduct();
        $collection_name = 'Collection name';

        // Act: Create collection
        $response = $this->client->post('http://nginx/product/' . $product_id . '/collection', [
            RequestOptions::FORM_PARAMS => [
                'name' => $collection_name
            ],
        ]);
        // Assert
        $this->assertEquals(201, $response->getStatusCode());
        $this->assertEquals($product_id, self::getOutputFromResponse($response, 'product_id'));
        $this->assertEquals('collection_name', self::getOutputFromResponse($response, 'collection_id') );
        $this->assertEquals($collection_name, self::getOutputFromResponse($response, 'collection_name') );

        // Arrange
        $collection_id = self::getOutputFromResponse($response, 'collection_id');

        // Act: Get collection
        $response = $this->client->get('http://nginx/product/' . $product_id . '/collection/' . $collection_id);
        // Assert
        $this->assertEquals($collection_id, self::getOutputFromResponse($response, 'collection_id') );
        $this->assertEquals($collection_name, self::getOutputFromResponse($response, 'collection_name') );
    }

    public function testGetAndGetComponent(): void
    {
        // Arrange
        $product_id = $this->createProduct();
        $collection_id = $this->addCollection($product_id, 'Collection Test');
        $component_name = 'Component name';
        $component_price = 100;

        // Act: Get component
        $response = $this->client->post('http://nginx/product/' . $product_id . '/collection/' . $collection_id . '/component', [
            RequestOptions::FORM_PARAMS => [
                'name' => $component_name,
                'price' => $component_price
            ],
        ]);
        // Assert
        $this->assertEquals(201, $response->getStatusCode());
        $this->assertEquals($product_id, self::getOutputFromResponse($response, 'product_id'));
        $this->assertEquals('component_name', self::getOutputFromResponse($response, 'component_id') );
        $this->assertEquals($component_name, self::getOutputFromResponse($response, 'component_name') );

        // Arrange
        $component_id = self::getOutputFromResponse($response, 'component_id');

        // Act: Get component
        $response = $this->client->get('http://nginx/product/' . $product_id . '/collection/' . $collection_id . '/component/' . $component_id);
        // Assert
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