<?php
namespace App\Application\UseCases;

use App\Domain\ProductNotFoundException;
use App\Domain\ProductRepository;
use App\Domain\Utilities\Uuid;

class DeleteProductUseCase
{
    private ProductRepository $productRepository;

    public function __construct(ProductRepository $repository)
    {
        $this->productRepository = $repository;
    }

    /**
     * @throws ProductNotFoundException
     */
    public function deleteProduct(DeleteProductRequest $request)
    {
        $product = $this->productRepository->get(new Uuid($request->product_id));
        $this->productRepository->delete($product->getId());
    }


}