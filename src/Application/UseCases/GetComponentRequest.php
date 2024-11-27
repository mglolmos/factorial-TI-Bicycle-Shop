<?php
namespace App\Application\UseCases;


class GetComponentRequest {
    public function __construct(public $product_id, public $collection_id, public $component_id) {}
}
