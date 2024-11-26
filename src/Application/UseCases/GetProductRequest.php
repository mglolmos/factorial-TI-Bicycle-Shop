<?php
namespace App\Application\UseCases;


class GetProductRequest {
    public function __construct(public $product_id) {}
}
