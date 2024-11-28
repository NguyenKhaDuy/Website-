<?php
//Tiến hành cập nhạt thông tin mới cả danh mục vào csdl
require "../../PHP/database.php";
require "../../PHP/code.php";

// Kiểm tra xem có dữ liệu được gửi đến không
if (isset($_POST['idTopping'], $_POST['idProduct'], $_POST['action'])) {
    $idTopping = $_POST['idTopping'];
    $idProduct = $_POST['idProduct'];
    $isChecked = $_POST['action'];
    $sql = "";
    if($isChecked == "insert"){
        $sql = "INSERT INTO `information_productstopping`(`id_product`, `id_topping`) VALUES ('$idProduct','$idTopping')";
    }
    if($isChecked == "delete"){
        $sql = "DELETE FROM `information_productstopping` WHERE id_product = 1 AND id_topping = 2";
    }

    // Thực thi truy vấn
    if ($conn->query($sql) === TRUE) {
        // Trả về kết quả là 1 nếu thành công
        echo 1;
    } else {
        // Trả về kết quả là 0 nếu thất bại
        echo 0;
    }
} else {
    // Trả về kết quả là -1 nếu dữ liệu không hợp lệ hoặc không đủ
    echo -1;
}
