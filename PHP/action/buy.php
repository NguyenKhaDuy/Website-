<?php
$giamgia = 20000;
require "../database.php";
require "../code.php";
session_start();

// Nhận dữ liệu từ AJAX
$cusName = $_POST['name'];
$cusPhone = $_POST['phone'];
$cusAddress = $_POST['address'];
$products = json_decode($_POST['products'], true);
// Hàm mua đặt hàng sản phẩm
$total = 0;
$total_discounting = 0;
$temp = 0;
$discounting_today = getDiscountingToday()->fetch_assoc();

foreach ($products as $value) {
    $total += $value['price'] * $value['qty'];
    $percent = 0;
    if (checkProductIsDiscounting($value['id'])) {
        $percent = $discounting_today['percent'];
        $total_discounting +=  $value['price'] * $value['qty'] * $percent / 100;
    }
}

// foreach ($_SESSION['cart'] as $value) {
//     $total += $value['price'] * $value['qty'];
//     $percent = 0;
//     if (checkProductIsDiscounting($value['id'])) {
//         $percent = $discounting_today['percent'];
//         $total_discounting +=  $value['price'] * $value['qty'] * $percent / 100;
//     }
// }

// Nếu đã đăng nhập thì mua được, ngược lại yêu cầu đăng nhập
if (isset($_SESSION['idUser'])) {
    $sql = "INSERT INTO orders (idUser, cusName, cusPhone, cusAddress, delivery, total, total_discounting) 
            VALUES ('{$_SESSION['idUser']}', '$cusName', '$cusPhone', '$cusAddress', '0', '$total', '$total_discounting')";
    $conn->query($sql);

    $last_id = $conn->insert_id;

    foreach($products as $product){
        if (!checkProductIsDiscounting($product['id'])) {
            $sql = "INSERT INTO informationorder(idPackage, idProduct, qty, price, idsize) 
                    VALUES ('$last_id', '{$product['id']}', '{$product['qty']}', '{$product['price']}', '{$product['idsize']}')";
        } else {
            $sql = "INSERT INTO informationorder_discounting(idOrder, idDiscounting, idProduct, price, qty, idsize) 
                    VALUES ('$last_id', '{$discounting_today['id']}', '{$product['id']}', {$product['price']}, '{$product['qty']}', '{$product['idsize']}')";
        }

        $conn->query($sql);

        if($product['toppings'] != null){
            //nếu nhiều topping thì sử dụng vòng lập ở đây 
            foreach ($product['toppings'] as $topping) {
                $sqlTopping = "INSERT INTO `orders_topping`(`id_product`, `id_topping`, `idOrder`) VALUES ('{$product['id']}',$topping[id],'$last_id')";
                $conn->query($sqlTopping);
            }
        }
        
    }

    unset($_SESSION['cart']); // Xóa giỏ hàng


    // Lặp qua từng sản phẩm trong giỏ hàng và thêm vào bảng thông tin đơn hàng
    // foreach ($_SESSION['cart'] as $value) {
    //     if (!checkProductIsDiscounting($value['id'])) {
    //         $sql = "INSERT INTO informationorder(idPackage, idProduct, qty, price, idsize) 
    //                 VALUES ('$last_id', '{$value['id']}', '{$value['qty']}', '{$value['price']}')";
    //     } else {
    //         $sql = "INSERT INTO informationorder_discounting(idOrder, idDiscounting, idProduct, price, qty, idsize) 
    //                 VALUES ('$last_id', '{$discounting_today['id']}', '{$value['id']}', {$value['price']}, '{$value['qty']}')";
    //     }
    //     $conn->query($sql);
    //     //nếu nhiều topping thì sử dụng vòng lập ở đây 
    //     $sqlTopping = "INSERT INTO `orders_topping`(`id_product`, `id_topping`, `idOrder`) VALUES ('{$value['id']}',1,'$last_id')";
    //     $conn->query($sqlTopping);
    //     unset($_SESSION['cart'][$value['id']]);
    // }
    echo "1";  // Thông báo thanh toán thành công
} else {
    echo "0";  // Nếu chưa đăng nhập
}
