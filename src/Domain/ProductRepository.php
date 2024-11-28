<?php
namespace App\Domain;

use App\Domain\Utilities\Uuid;

interface ProductRepository {
    public function get(Uuid $product_id): Product;
    public function persist(Product $product);
}