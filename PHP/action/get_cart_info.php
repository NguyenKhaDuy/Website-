<?php
require "../database.php";
require "../code.php";
session_start();

$total = 0;
$discounting = 0;
$tongtopping = 0;
$products = [];
$discounting_today = getDiscountingToday()->fetch_assoc();

foreach ($_SESSION['cart'] as $product) {

    if($product['toppings'] != null){
        foreach ($product['toppings'] as $topping) {
            $tongtopping += $topping['price'];
        }
    }
    
    $total += $product['price'] * $product['qty'];
    $size = getSizeId($product['size'])->fetch_assoc();
    $discounting += checkProductIsDiscounting($product['id']) ? ($product['price'] * $product['qty']) * ($discounting_today['percent'] / 100) : 0;
    $products[] = [
        'id' => $product['id'],
        'title' => $product['title'],
        'price' => $product['price'],
        'qty' => $product['qty'],
        'total' => $product['price'] * $product['qty'],
        'idsize' => $product['size'],
        'size' => $size,
        'toppings' => $product['toppings']
    ];
}

echo json_encode([
    'total' => $total + $tongtopping,
    'discounting' => $discounting,
    'products' => $products
]);
