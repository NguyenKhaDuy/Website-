<?php
//cập nhật trạng thái đơn hàng 
$id = $_GET['id'];
require "../../PHP/database.php";
$sql = "UPDATE orders SET delivery='1' WHERE id = '$id' ";
$conn->query($sql);

