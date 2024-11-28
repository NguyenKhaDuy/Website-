<?php
//Hàm thêm danh mục 
require "../../PHP/database.php";
require "../../PHP/code.php";
$nametopping = $_POST['nametopping'];
$pricetopping = $_POST['pricetopping'];

$sql = "INSERT INTO topping(nametopping, pricetopping) VALUES ('$nametopping','$pricetopping')";
$conn->query($sql);
echo 1;
