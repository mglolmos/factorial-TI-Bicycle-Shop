<?php
namespace App\Application\UseCases;

use App\Domain\Product;
use App\Domain\ProductNotFoundException;
use App\Domain\ProductRepository;
use App\Domain\Utilities\Id;
use App\Domain\Utilities\Uuid;

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
        $product = $this->productRepository->get(new Uuid($request->product_id));

        $collection_name = $product->getCollectionName(new Id($request->collection_id));

        return new GetCollectionResponse($product->getId()->getValue(), $request->collection_id, $collection_name->getNameValue());
    }
}