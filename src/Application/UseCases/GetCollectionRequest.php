<?php
namespace App\Application\UseCases;


class GetCollectionRequest {
    public function __construct(public $product_id, public $collection_id) {}
}
