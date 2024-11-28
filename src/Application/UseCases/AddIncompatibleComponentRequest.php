<?php
namespace App\Application\UseCases;


class AddIncompatibleComponentRequest {
    public function __construct(public $product_id, public $collection_id1, public $component_id1, public $collection_id2, public $component_id2) {}
}
