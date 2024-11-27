<?php
namespace App\Application\UseCases;

use App\Domain\Collection;
use App\Domain\Component;
use App\Domain\ProductRepository;

class AddComponentUseCase {

    private ProductRepository $productRepository;

    public function __construct(ProductRepository $repository) {
        $this->productRepository = $repository;
    }

    public function addComponent(AddComponentRequest $request)
    {
        $component = new Component($request->component_name, $request->component_price);
        $product = $this->productRepository->get($request->product_id);
        $product->addComponent($request->collection_id, $component);

        $this->productRepository->persist($product);

        return new AddComponentResponse($product->getId(), $request->collection_id, $component->getId(), $component->getName(), $component->getPrice(), $component->isInStock());
    }

}