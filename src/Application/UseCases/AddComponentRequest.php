<?php
namespace App\Application\UseCases;


class AddComponentRequest {
    public function __construct(public $product_id, public $collection_id, public $component_name, public $component_price) {}
}
