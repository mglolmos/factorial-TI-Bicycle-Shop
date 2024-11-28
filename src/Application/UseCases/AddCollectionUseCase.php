<?php
namespace App\Application\UseCases;

use App\Domain\Collection;
use App\Domain\ProductRepository;
use App\Domain\Utilities\Name;

class AddCollectionUseCase {

    private ProductRepository $productRepository;

    public function __construct(ProductRepository $repository) {
        $this->productRepository = $repository;
    }

    public function addCollection(AddCollectionRequest $request)
    {
        $collection = new Collection(new Name($request->collection_name));
        $product = $this->productRepository->get($request->product_id);
        $product->addCollection($collection);

        $this->productRepository->persist($product);

        return new AddCollectionResponse($product->getId()->getValue(), $collection->getId()->getValue(), $collection->getName()->getNameValue());
    }

}