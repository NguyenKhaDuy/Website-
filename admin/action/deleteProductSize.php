<?php
//xóa sản phẩm
require "../../PHP/database.php";
$id = $_POST['id'];
$sql = "DELETE FROM information_productssize WHERE id = '$id'";
$conn->query($sql);
echo "1";
