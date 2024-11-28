
<?php
//Hàm đăng xuất tải khoản
// Xóa các biến session liên quan đến thông tin người dùng
session_start();
unset($_SESSION['username']);
unset($_SESSION['password']);
unset($_SESSION['firstname']);
unset($_SESSION['lastname']);
unset($_SESSION['dob']);
unset($_SESSION['sex']);
unset($_SESSION['email']);
unset($_SESSION['idUser']);
unset($_SESSION['admin']);
// Xóa biến session liên quan đến giỏ hàng
unset($_SESSION['cart']);
