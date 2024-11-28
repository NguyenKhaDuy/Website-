<?php
//Hàm thêm danh mục 
require "../../PHP/database.php";
require "../../PHP/code.php";
// $idtopping = $_POST['nametopping'];
$idProduct = $_POST['idproduct'];

$idTopping = isset($_POST['idTopping']) ? json_decode($_POST['idTopping'], true) : [];

for ($i = 0; $i < count($idTopping); $i++) {
    $sql = "INSERT INTO `information_productstopping`(`id_product`, `id_topping`) VALUES ('$idProduct','$idTopping[$i]')";
    $conn->query($sql);
}

echo 1;
