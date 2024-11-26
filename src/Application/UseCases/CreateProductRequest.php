<?php
namespace App\Application\UseCases;


class CreateProductRequest {
    public function __construct(public $product_id, public $name) {}
}
