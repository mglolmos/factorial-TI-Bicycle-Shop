<?php
namespace App\Application\UseCases;


class AddCollectionRequest {
    public function __construct(public $product_id, public $collection_name) {}
}
