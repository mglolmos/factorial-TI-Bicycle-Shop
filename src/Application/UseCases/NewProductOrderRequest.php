<?php
namespace App\Application\UseCases;


class NewProductOrderRequest {
    public function __construct(public $product_id, public array $components_selected) {}
}
