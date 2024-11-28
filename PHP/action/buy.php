<?php
$giamgia = 20000;
require "../database.php";
require "../code.php";
session_start();

// Nhận dữ liệu từ AJAX
$cusName = $_POST['name'];
$cusPhone = $_POST['phone'];
$cusAddress = $_POST['address'];

// Hàm mua đặt hàng sản phẩm
$total = 0;
$total_discounting = 0;
$temp = 0;
$discounting_today = getDiscountingToday()->fetch_assoc();

foreach ($_SESSION['cart'] as $value) {
    $total += $value['price'] * $value['qty'];
    $percent = 0;
    if (checkProductIsDiscounting($value['id'])) {
        $percent = $discounting_today['percent'];
        $total_discounting +=  $value['price'] * $value['qty'] * $percent / 100;
    }
}

// Nếu đã đăng nhập thì mua được, ngược lại yêu cầu đăng nhập
if (isset($_SESSION['idUser'])) {
    $sql = "INSERT INTO orders (idUser, cusName, cusPhone, cusAddress, delivery, total, total_discounting) 
            VALUES ('{$_SESSION['idUser']}', '$cusName', '$cusPhone', '$cusAddress', '0', '$total', '$total_discounting')";
    $conn->query($sql);

    $last_id = $conn->insert_id;

    // Lặp qua từng sản phẩm trong giỏ hàng và thêm vào bảng thông tin đơn hàng
    foreach ($_SESSION['cart'] as $value) {
        if (!checkProductIsDiscounting($value['id'])) {
            $sql = "INSERT INTO informationorder(idPackage, idProduct, qty, price) 
                    VALUES ('$last_id', '{$value['id']}', '{$value['qty']}', '{$value['price']}')";
        } else {
            $sql = "INSERT INTO informationorder_discounting(idOrder, idDiscounting, idProduct, price, qty) 
                    VALUES ('$last_id', '{$discounting_today['id']}', '{$value['id']}', {$value['price']}, '{$value['qty']}')";
        }
        $conn->query($sql);
        unset($_SESSION['cart'][$value['id']]);
    }
    echo "1";  // Thông báo thanh toán thành công
} else {
    echo "0";  // Nếu chưa đăng nhập
}
