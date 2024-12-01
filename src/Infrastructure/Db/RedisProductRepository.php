<?php
namespace App\Infrastructure\Db;

use App\Domain\Product;
use App\Domain\ProductNotFoundException;
use App\Domain\ProductRepository;
use App\Domain\Utilities\Uuid;
use Predis\Client;

class RedisProductRepository implements ProductRepository
{

    private const PREFIX = 'product_';

    private $client;
    public function __construct()
    {
        $this->client = new Client([
            'scheme' => 'tcp',
            'host'  => 'redis',
            'port'  => 6379,
        ]);

    }

    public function get(Uuid $product_id): Product
    {
        $response = unserialize($this->client->get(self::PREFIX . $product_id->getValue()));
        if (false === $response) {
            throw new ProductNotFoundException();
        }

        return $response;
    }

    public function persist(Product $product)
    {
        $this->client->set(self::PREFIX . $product->getId()->getValue(), serialize($product));
    }

    public function delete(Uuid $product_id)
    {
        $this->client->del(self::PREFIX . $product_id->getValue());
    }
}