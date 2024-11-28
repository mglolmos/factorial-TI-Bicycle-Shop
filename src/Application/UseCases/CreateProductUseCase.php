<?php
namespace App\Application\UseCases;

use App\Domain\Product;
use App\Domain\ProductRepository;
use App\Domain\Utilities\Name;
use App\Domain\Utilities\Uuid;

class CreateProductUseCase {

    private ProductRepository $productRepository;

    public function __construct(ProductRepository $repository) {
        $this->productRepository = $repository;

    }

    public function createProduct(CreateProductRequest $request)
    {
        $product = new Product(new Uuid($request->product_id), new Name($request->name));

        $this->productRepository->persist($product);

    }


}