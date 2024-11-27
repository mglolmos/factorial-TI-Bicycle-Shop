<?php
namespace App\Application\UseCases;

use App\Domain\Product;
use App\Domain\ProductNotFoundException;
use App\Domain\ProductRepository;

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
        $product = $this->productRepository->get($request->product_id);

        $component_name = $product->getComponentName($request->collection_id, $request->component_id);
        $component_price = $product->getComponentPrice($request->collection_id, $request->component_id);
        $component_is_in_stock = $product->isComponentInStock($request->collection_id, $request->component_id);


        return new GetComponentResponse($product->getId(), $request->collection_id, $request->component_id, $component_name, $component_price, $component_is_in_stock);
    }
}