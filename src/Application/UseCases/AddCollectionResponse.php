<?php
namespace App\Application\UseCases;


class AddCollectionResponse {
    public function __construct(public $product_id, public $collection_id, public $collection_name) {}
}
