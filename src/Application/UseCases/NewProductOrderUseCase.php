<?php
namespace App\Application\UseCases;

use App\Domain\Product;
use App\Domain\ProductOrder;
use App\Domain\ProductRepository;
use App\Domain\Utilities\Name;
use App\Domain\Utilities\Uuid;

class NewProductOrderUseCase {

    private ProductRepository $productRepository;

    public function __construct(ProductRepository $repository) {
        $this->productRepository = $repository;

    }

    public function newProductOrderUseCase(NewProductOrderRequest $request)
    {
        $product = $this->productRepository->get(new Uuid($request->product_id));
        $product_order = new ProductOrder($product, $request->components_selected);
        $product_order->checkIfOrderHasInvalidComponents();

        $price = $product_order->getPrice();

        // TODO: Once the product order is valid and the price is calculated, you can choose to store it in the orders table, emit an event, and/or return the information.
    }
}