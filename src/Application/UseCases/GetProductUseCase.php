<?php
namespace App\Application\UseCases;

use App\Domain\Product;
use App\Domain\ProductNotFoundException;
use App\Domain\ProductRepository;
use App\Domain\Utilities\Uuid;

class GetProductUseCase
{

    private ProductRepository $productRepository;

    public function __construct(ProductRepository $repository)
    {
        $this->productRepository = $repository;

    }

    /**
     * @throws ProductNotFoundException
     */
    public function getProduct(GetProductRequest $request)
    {
        $product = $this->productRepository->get(new Uuid($request->product_id));
        return new GetProductResponse($product->getId()->getValue(), $product->getName()->getNameValue());
    }


}