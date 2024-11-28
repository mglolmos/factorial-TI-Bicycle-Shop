<?php
namespace App\Domain;

use App\Domain\Utilities\Id;
use App\Domain\Utilities\Price;
use App\Domain\Utilities\Uuid;
use App\Domain\Utilities\Name;

class ProductOrder {
    private Uuid $id;

    private Product $product;

    /**
     * @var Id[]
     */
    private array $componentsSelected = [];

    public function __construct(Product $product, array $componentsSelected)
    {
        $this->product = $product;
        $this->componentsSelected = $componentsSelected;
    }

    public function checkIsACorrectOrder()
    {
        try {
            foreach ($this->componentsSelected as $collection_id => $component_id) {
                $component = $this->product->getComponent(new Id($collection_id), new Id($component_id));
                foreach ($this->componentsSelected as $collection_id_target => $component_id_target) {
                    if (!$component->isCompatibleWith(new Id($collection_id_target), new Id($component_id_target))) {
                        return false;
                    }
                }
            }
            return true;
        } catch (CollectionInvalidException|ComponentInvalidException $exception) {
            return false;
        }
    }

    public function getPrice(): Price
    {
        $price = 0;
        foreach ($this->componentsSelected as $collection_id => $component_id) {
            $component = $this->product->getComponent(new Id($collection_id), new Id($component_id));
            $price += $component->getPrice()->getValue();
        }
        return Price::fromInt($price);
    }
}