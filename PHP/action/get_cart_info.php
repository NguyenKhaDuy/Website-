<?php
require "../database.php";
require "../code.php";
session_start();

$total = 0;
$discounting = 0;
$products = [];
$discounting_today = getDiscountingToday()->fetch_assoc();

foreach ($_SESSION['cart'] as $product) {
    $total += $product['price'] * $product['qty'];
    $discounting += checkProductIsDiscounting($product['id']) ? ($product['price'] * $product['qty']) * ($discounting_today['percent'] / 100) : 0;
    $products[] = [
        'title' => $product['title'],
        'price' => $product['price'],
        'qty' => $product['qty'],
        'total' => $product['price'] * $product['qty']
    ];
}

echo json_encode([
    'total' => $total,
    'discounting' => $discounting,
    'products' => $products
]);
