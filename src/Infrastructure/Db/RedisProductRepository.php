<?php
namespace App\Infrastructure\Db;

use App\Domain\Product;
use App\Domain\ProductNotFoundException;
use App\Domain\ProductRepository;
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

    public function get($product_id): Product
    {
        $response = unserialize($this->client->get(self::PREFIX . $product_id));
        if (false === $response) {
            throw new ProductNotFoundException();
        }

        return $response;
    }

    public function persist(Product $product)
    {
        $this->client->set(self::PREFIX . $product->getId(), serialize($product));
    }
}