<?php

class Challenge {
    private $size;
    private $label;
    private $price;
    private $profitTarget;
    private $dailyDrawdown;
    private $maxDrawdown;
    private $profitSplit;
    private $isPopular;

    public function __construct($size, $label, $price, $target, $daily, $max, $split, $popular = false) {
        $this->size = $size;
        $this->label = $label;
        $this->price = $price;
        $this->profitTarget = $target;
        $this->dailyDrawdown = $daily;
        $this->maxDrawdown = $max;
        $this->profitSplit = $split;
        $this->isPopular = $popular;
    }

    public function getSize() { return $this->size; }
    public function getLabel() { return $this->label; }
    public function getPrice() { return $this->price; }
    public function getProfitTarget() { return $this->profitTarget; }
    public function getDailyDrawdown() { return $this->dailyDrawdown; }
    public function getMaxDrawdown() { return $this->maxDrawdown; }
    public function getProfitSplit() { return $this->profitSplit; }
    public function isPopular() { return $this->isPopular; }

    public function setPrice($price) { $this->price = $price; }
    public function setPopular($popular) { $this->isPopular = $popular; }

    public function getNumericSize() {
        return (int) preg_replace('/[^0-9]/', '', $this->size);
    }

    public function getNumericPrice() {
        return (int) preg_replace('/[^0-9]/', '', $this->price);
    }

    public function getCategory() {
        $num = $this->getNumericSize();
        if ($num <= 25000) return 'starter';
        return 'pro';
    }
}
