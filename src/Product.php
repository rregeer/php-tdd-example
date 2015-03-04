<?php

namespace TDD;

class Product
{
    private $productId;
    private $name;
    private $salesPrice;

    public function setName($value) {
        $this->name = (string)$value;
    }

    public function getName() {
        return $this->name;
    }

    public function setProductId($value) {
        $this->productId = (string)$value;
    }

    public function getProductId() {
        return $this->productId;
    }

    public function setSalesPrice($value) {
        $this->salesPrice = (string)$value;
    }

    public function getSalesPrice() {
        return $this->salesPrice;
    }
}