<?php

class ProductManager {
    private $products = [];
    private $sentimentAnalyzer;

    public function __construct(SentimentAnalyzer $sentimentAnalyzer) {
        $this->sentimentAnalyzer = $sentimentAnalyzer;
    }

    public function loadProducts($rows) {
        foreach ($rows as $row) {
            $product = new Product($row[0], $row[1]);
            $sentiment = $this->sentimentAnalyzer->analyze($product->getDescription());
            $product->setSentiment($sentiment);
            $this->products[] = $product;
        }
    }

    public function getProducts() {
        return $this->products;
    }

    public function getMostPositiveProduct() {
        $mostPositiveProduct = null;
        $highestScore = PHP_INT_MIN;

        foreach ($this->products as $product) {
            $score = $this->sentimentAnalyzer->analyzeScore($product->getDescription());
            if ($score > $highestScore) {
                $highestScore = $score;
                $mostPositiveProduct = $product;
            }
        }

        return $mostPositiveProduct;
    }

    public function getMostNegativeProduct() {
        $mostNegativeProduct = null;
        $lowestScore = PHP_INT_MAX;

        foreach ($this->products as $product) {
            $score = $this->sentimentAnalyzer->analyzeScore($product->getDescription());
            if ($score < $lowestScore) {
                $lowestScore = $score;
                $mostNegativeProduct = $product;
            }
        }

        return $mostNegativeProduct;
    }
}
