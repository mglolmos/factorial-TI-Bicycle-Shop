<?php
namespace App\Application\UseCases;

use App\Domain\Collection;
use App\Domain\Product;
use App\Domain\ProductNotFoundException;
use App\Domain\ProductRepository;

class AddCollectionUseCase {

    private ProductRepository $productRepository;

    public function __construct(ProductRepository $repository) {
        $this->productRepository = $repository;
    }

    public function addCollection(AddCollectionRequest $request)
    {
        $collection = new Collection($request->collection_name);
        $product = $this->productRepository->get($request->product_id);
        if (false === $product) {
            throw new ProductNotFoundException();
        }
        $product->addCollection($collection);
        $this->productRepository->persist($product);
        return new AddCollectionResponse($product->getId(), $collection->getId(), $collection->getName());
    }

}