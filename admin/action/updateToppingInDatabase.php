<?php
//Tiến hành cập nhạt thông tin mới cả danh mục vào csdl
require "../../PHP/database.php";
require "../../PHP/code.php";

// Kiểm tra xem có dữ liệu được gửi đến không
if (isset($_POST['id'], $_POST['nametopping'], $_POST['pricetopping'])) {
    $pricetopping = $_POST['pricetopping'];
    $nametopping = $_POST['nametopping'];
    $id = $_POST['id'];

    $sql = "UPDATE topping SET nametopping = '$nametopping', pricetopping ='$pricetopping' WHERE idtopping ='$id'";

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
