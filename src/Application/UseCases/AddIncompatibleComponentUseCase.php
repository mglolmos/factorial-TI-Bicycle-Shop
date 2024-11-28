<?php
namespace App\Application\UseCases;


use App\Domain\ProductRepository;
use App\Domain\Utilities\Id;
use App\Domain\Utilities\Uuid;

class AddIncompatibleComponentUseCase {


    private ProductRepository $productRepository;

    public function __construct(ProductRepository $repository)
    {
        $this->productRepository = $repository;
    }

    public function addIncompatibleComponent(AddIncompatibleComponentRequest $request)
    {
        $product = $this->productRepository->get(new Uuid($request->product_id));

        $product->addIncompatibleComponent(
            new Id($request->collection_id1),
            new Id($request->collection_id1),
            new Id($request->collection_id2),
            new Id($request->collection_id2)
        );

        $product = $this->productRepository->persist($product);

        // TODO: Add response
    }
}