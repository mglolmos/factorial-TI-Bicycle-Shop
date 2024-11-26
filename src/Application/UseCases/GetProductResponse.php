<?php
namespace App\Application\UseCases;


class GetProductResponse {
    public function __construct(public $product_id, public $name) {}
}
