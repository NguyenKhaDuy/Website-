<?php
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$phone_number = $_POST['phone_number'];
$gender = $_POST['gender'];
$date = $_POST['date'];
$address = $_POST['address'];
$img = "img/user/defaultavata.jpg";

require "../database.php";
$sql = "SELECT * FROM users WHERE username = '$username'";
//Hàm đăng kí tải khoản người dùng
$result = $conn->query($sql);
//Nếu username tồn tại thì thông báo người dùng tồn tại
if ($result->num_rows == 0) {
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);
    //Nếu email tồn tại thì không thể đăng kí ngược lại thì thêm người dùng vào table user
    if ($result->num_rows == 0) {
        $sql = "INSERT INTO users (img,username,password,firstname,lastname,email,dob,sex,admin,phone_number,address) VALUES ('$img','$username','$password','$firstname','$lastname','$email','$date','$gender','0','{$phone_number}','{$address}')";
        $conn->query($sql);
        // echo $sql;
    } else {
        echo "email"; //tìm thấy email
    }
} else {
    echo "username"; // tìm tấy username
}
          