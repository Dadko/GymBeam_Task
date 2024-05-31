<?php

class Product {
    private $name;
    private $description;
    private $cleanDescription;
    private $sentiment;

    public function __construct($name, $description) {
        $this->name = $name;
        $this->description = strip_tags($description);
    }

    public function getName() {
        return $this->name;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getSentiment() {
        return $this->sentiment;
    }

    public function setSentiment($sentiment) {
        $this->sentiment = $sentiment;
    }
}
