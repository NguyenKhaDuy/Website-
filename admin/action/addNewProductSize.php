<?php 
//Hàm thêm sản phẩm mới
require "../../PHP/database.php";
require "../../PHP/code.php";
$id_product = $_POST['id_product'];
$id_size = $_POST['id_size'];
$price = $_POST['price'];


$sql = "INSERT INTO information_productssize(id_product, id_size, price) VALUES ('$id_product','$id_size', '$price')";
$conn->query($sql);
echo 1;
