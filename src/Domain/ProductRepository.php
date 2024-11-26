<?php
namespace App\Domain;

interface ProductRepository {
    public function get($product_id);
    public function persist(Product $product);
}