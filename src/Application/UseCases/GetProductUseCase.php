<?php
namespace App\Application\UseCases;

use App\Domain\Product;
use App\Domain\ProductNotFoundException;
use App\Domain\ProductRepository;

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
        $product = $this->productRepository->get($request->product_id);
        return new GetProductResponse($product->getId(), $product->getName());
    }


}