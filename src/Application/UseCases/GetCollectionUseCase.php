<?php
namespace App\Application\UseCases;

use App\Domain\Product;
use App\Domain\ProductNotFoundException;
use App\Domain\ProductRepository;

class GetCollectionUseCase
{

    private ProductRepository $productRepository;

    public function __construct(ProductRepository $repository)
    {
        $this->productRepository = $repository;

    }

    /**
     * @throws ProductNotFoundException
     */
    public function getCollection(GetCollectionRequest $request)
    {
        $product = $this->productRepository->get($request->product_id);
        if (false === $product) {
            throw new ProductNotFoundException();
        }

        $collection_name = $product->getCollectionName($request->collection_id);

        return new GetCollectionResponse($product->getId(), $request->collection_id, $collection_name);
    }
}