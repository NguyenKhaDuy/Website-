<?php
require "../database.php";
require "../code.php";
session_start();

$idProduct = $_POST['id'];
//Hàm thêm sản phẩm vào giỏ hàng ở trang homepage
$newProduct = getProductById($idProduct)->fetch_assoc();
// if so luong san pham khong vuot qua thi add no vao thang session
//else
if (!isset($_SESSION['cart']) || $_SESSION['cart'] == null) {
    $_SESSION['cart'][$idProduct] = $newProduct;
    $_SESSION['cart'][$idProduct]['qty'] = 1;
    $_SESSION['cart'][$idProduct]['size'] = 1;
    $_SESSION['cart'][$idProduct]['toppings'] = null;
    $_SESSION['cart'][$idProduct]['final_price'] = $_SESSION['cart'][$idProduct]['price'];
} else {
    if (array_key_exists($idProduct, $_SESSION['cart'])) {
        $_SESSION['cart'][$idProduct]['qty'] += 1;
    } else {
        $_SESSION['cart'][$idProduct] = $newProduct;
        $_SESSION['cart'][$idProduct]['qty'] = 1;
        $_SESSION['cart'][$idProduct]['size'] = 1;
        $_SESSION['cart'][$idProduct]['toppings'] = null;
        $_SESSION['cart'][$idProduct]['final_price'] = $_SESSION['cart'][$idProduct]['price'];
    }
}
$session->close();
