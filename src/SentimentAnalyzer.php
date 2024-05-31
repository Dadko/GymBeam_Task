<?php

use PHPInsight\Sentiment;

class SentimentAnalyzer {
    private $sentiment;

    public function __construct() {
        $this->sentiment = new Sentiment();
    }

    public function analyze($text) {
        $class = $this->sentiment->categorise($text);
        return ucfirst($class);
    }

    public function analyzeScore($text) {
        $scores = $this->sentiment->score($text);
        return $scores['pos'] - $scores['neg'];
    }

    public function translateSentiment($sentiment) {
        switch ($sentiment) {
            case 'Pos':
                return 'Positive';
            case 'Neg':
                return 'Negative';
            case 'Neu':
                return 'Neutral';
            default:
                return ucfirst($sentiment);
        }
    }
}
