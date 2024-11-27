<?php
namespace App\Domain;

interface ProductRepository {
    public function get($product_id): Product;
    public function persist(Product $product);
}