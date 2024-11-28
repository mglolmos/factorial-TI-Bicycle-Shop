<?php
namespace App\Application\UseCases;

use App\Domain\Product;
use App\Domain\ProductNotFoundException;
use App\Domain\ProductRepository;
use App\Domain\Utilities\Id;
use App\Domain\Utilities\Uuid;

class GetComponentUseCase
{

    private ProductRepository $productRepository;

    public function __construct(ProductRepository $repository)
    {
        $this->productRepository = $repository;

    }

    /**
     * @throws ProductNotFoundException
     */
    public function getComponent(GetComponentRequest $request)
    {
        $product = $this->productRepository->get(new Uuid($request->product_id));
        $collection_id = new Id($request->collection_id);
        $component_id = new Id($request->component_id);

        $component_name = $product->getComponentName($collection_id, $component_id);
        $component_price = $product->getComponentPrice($collection_id, $component_id);
        $component_is_in_stock = $product->isComponentInStock($collection_id, $component_id);


        return new GetComponentResponse(
            $product->getId()->getValue(),
            $request->collection_id,
            $request->component_id,
            $component_name->getNameValue(),
            $component_price->getValue(),
            $component_is_in_stock
        );
    }
}