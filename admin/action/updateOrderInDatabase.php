<?php

require "../../PHP/database.php";
require "../../PHP/code.php";
//cập nhật thông tin đơn hàng
//lấy thông tin đơn hàng hiện lên form
// Kiểm tra xem có dữ liệu được gửi đến không
if (isset($_POST['idUser'], $_POST['datetime'], $_POST['total'], $_POST['delivery'], $_POST['total_discounting'], $_POST['id'])) {
    $idUser = $_POST['idUser'];
    $datetime = $_POST['datetime'];
    $total = $_POST['total'];
    $delivery = $_POST['delivery'];
    $total_discounting = $_POST['total_discounting'];
    $id = $_POST['id'];

    $sql = "UPDATE orders SET idUser = '$idUser', datetime ='$datetime', total='$total', delivery='$delivery',total_discounting='$total_discounting' WHERE id ='$id'";

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
?>