<?php
namespace App\Application\UseCases;

use App\Domain\Collection;
use App\Domain\Component;
use App\Domain\ProductRepository;
use App\Domain\Utilities\Id;
use App\Domain\Utilities\Name;
use App\Domain\Utilities\Price;

class AddComponentUseCase {

    private ProductRepository $productRepository;

    public function __construct(ProductRepository $repository) {
        $this->productRepository = $repository;
    }

    public function addComponent(AddComponentRequest $request)
    {
        $component = new Component(new Name($request->component_name), Price::fromString($request->component_price));
        $product = $this->productRepository->get($request->product_id);
        $product->addComponent(new Id($request->collection_id), $component);

        $this->productRepository->persist($product);

        return new AddComponentResponse(
            $product->getId()->getValue(),
            $request->collection_id,
            $component->getId()->getValue(),
            $component->getName()->getNameValue(),
            $component->getPrice()->getValue(),
            $component->isInStock()
        );
    }

}