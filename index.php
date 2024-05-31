<?php

require 'vendor/autoload.php';
require 'src/CSVLoader.php';
require 'src/SentimentAnalyzer.php';
require 'src/Product.php';
require 'src/ProductManager.php';

$filename = 'dataset-gymbeam-product-descriptions-eng.csv';

$csvLoader = new CSVLoader($filename);
$rows = $csvLoader->load();

$sentimentAnalyzer = new SentimentAnalyzer();
$productManager = new ProductManager($sentimentAnalyzer);
$productManager->loadProducts($rows);

$products = $productManager->getProducts();
$mostPositiveProduct = $productManager->getMostPositiveProduct();
$mostNegativeProduct = $productManager->getMostNegativeProduct();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GymBeam Product Sentiments</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">GymBeam Product Sentiments</h1>
        <h2>Most Positive Product</h2>
        <?php if ($mostPositiveProduct): ?>
            <div class="card mb-4 text-success">
                <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($mostPositiveProduct->getName()); ?></h5>
                    <p class="card-text"><?= htmlspecialchars($mostPositiveProduct->getDescription()); ?></p>
                </div>
            </div>
        <?php else: ?>
            <p>No positive products found.</p>
        <?php endif; ?>

        <h2>Most Negative Product</h2>
        <?php if ($mostNegativeProduct): ?>
            <div class="card mb-4 text-danger">
                <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($mostNegativeProduct->getName()); ?></h5>
                    <p class="card-text"><?= htmlspecialchars($mostNegativeProduct->getDescription()); ?></p>
                </div>
            </div>
        <?php else: ?>
            <p>No negative products found.</p>
        <?php endif; ?>

        <h2>All Products</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Product Name</th>
                    <th scope="col">Description</th>
                    <th scope="col">Sentiment</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                    <tr class="<?= $product->getSentiment() === 'Pos' ? 'text-success' : ($product->getSentiment() === 'Neg' ? 'text-danger' : ''); ?>">
                        <td><?= htmlspecialchars($product->getName()); ?></td>
                        <td><?= htmlspecialchars($product->getDescription()); ?></td>
                        <td><?= htmlspecialchars($sentimentAnalyzer->translateSentiment($product->getSentiment())); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
