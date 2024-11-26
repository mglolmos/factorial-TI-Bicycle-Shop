<?php
namespace App\Infrastructure\Db;

use App\Domain\Product;
use App\Domain\ProductRepository;
use Predis\Client;

class RedisProductRepository implements ProductRepository
{

    private $client;
    public function __construct()
    {
        $this->client = new Client([
            'scheme' => 'tcp',
            'host'  => 'redis',
            'port'  => 6379,
        ]);

    }

    public function get($product_id)
    {
        return unserialize($this->client->get($product_id));
    }

    public function persist(Product $product)
    {
        $this->client->set($product->getId(), serialize($product));
    }
}