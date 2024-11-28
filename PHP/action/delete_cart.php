<?php
session_start();
$cartKey = $_POST['cartKey'];

if (isset($_SESSION['cart'][$cartKey])) {
    unset($_SESSION['cart'][$cartKey]);
    echo "1"; // Xóa thành công
} else {
    echo "0"; // Không tìm thấy sản phẩm
}
 