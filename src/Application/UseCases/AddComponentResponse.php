<?php
namespace App\Application\UseCases;


class AddComponentResponse {
    public function __construct(public $product_id, public $collection_id, public $component_id, public $component_name, public $component_price, public $component_is_in_stock) {}
}
