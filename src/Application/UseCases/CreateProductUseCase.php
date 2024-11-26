<?php
namespace App\Application\UseCases;

use App\Domain\Product;
use App\Domain\ProductRepository;

class CreateProductUseCase {

    private ProductRepository $productRepository;

    public function __construct(ProductRepository $repository) {
        $this->productRepository = $repository;

    }

    public function createProduct(CreateProductRequest $request)
    {
        $product = new Product($request->product_id, $request->name);

        $this->productRepository->persist($product);

    }


}