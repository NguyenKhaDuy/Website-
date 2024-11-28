<?php 
//Hàm thêm sản phẩm mới
require "../../PHP/database.php";
require "../../PHP/code.php";
$title = $_POST['title'];
$summary = $_POST['summary'];
$price = $_POST['price'];
$casebook = $_POST['casebook'];
$qty = $_POST['qty'];

// echo $title . $summary . $price . $casebook . $qty . $img;
//Kiểm tra xem có thêm hình ảnh hay chưa
//nếu có hình ảnh rồi thì hình có lỗi không
//nếu không lỗi tiến hành thêm vào csdl
if (isset($_FILES['img'])) {
    $img = $_FILES['img'];
    if ($img['error'] == 0) {
        //di chuyển file ảnh vào thư mục
        move_uploaded_file($img['tmp_name'], '../../PHP/public/img/product/' . $img['name']);
        //set đường dẫn để thêm vào cơ sở dữ liệu
        $imgSrc = 'img/product/' . $img['name'];
        $sql = "INSERT INTO products(img,title,summary,casebook,price,amount,love,count_buying) VALUES ('$imgSrc','$title','$summary','$casebook','$price',$qty,0,0)";
        $conn->query($sql);
        echo "1";
    } else {
        echo var_dump($img);
    }
}
//header('location:' . $_SERVER['HTTP_REFERER']);
