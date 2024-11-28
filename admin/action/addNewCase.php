<?php
//Hàm thêm danh mục 
require "../../PHP/database.php";
require "../../PHP/code.php";
$casebook = $_POST['casebook'];
$nameCase = $_POST['name'];

$sql = "INSERT INTO cases(casebook, name) VALUES ('$casebook','$nameCase')";
$conn->query($sql);
echo 1;
