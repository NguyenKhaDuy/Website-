<?php
session_start();
require "../database.php";
require "../code.php";

// Cập nhật giỏ hàng
if (isset($_POST['id']) && isset($_POST['qty'])) {
    $num_products = getProductById($_POST['id'])->fetch_assoc();
    if($_POST['qty'] > $num_products['amount']){
        echo 1;
    }else{
        $id = $_POST['id'];
        $qty = $_POST['qty'];

        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['qty'] = $qty;
        }

        $total = 0;
        $discounting = 0;

        foreach ($_SESSION['cart'] as $product) {
            $total += $product['price'] * $product['qty'];
            // Giảm giá nếu có
            // $discounting += checkProductIsDiscounting($product['id']) ? ($product['price'] * $product['qty']) * ($discounting_today['percent'] / 100) : 0;
        }

        // Trả về thông tin giỏ hàng mới (tổng giỏ hàng và giảm giá)
        echo json_encode(['total' => $total, 'discounting' => $discounting]);
    }
}
