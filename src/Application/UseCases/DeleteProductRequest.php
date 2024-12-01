<?php
namespace App\Application\UseCases;


class DeleteProductRequest {
    public function __construct(public $product_id) {}
}
