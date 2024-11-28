<?php
require "../code.php";
require "../database.php";
session_start();

$id = $_GET['id'];
$quantity = $_GET['quantity'];
$size = isset($_GET['size']) ? $_GET['size'] : 'S';
$toppings = isset($_GET['toppings']) ? json_decode($_GET['toppings'], true) : [];

// Lấy thông tin sản phẩm từ database
$newProduct = getProductById($id)->fetch_assoc();

if ($quantity <= $newProduct['amount']) {
    // Tính giá theo size
    $multiplier = 1;
    switch($size) {
        case 'M':
            $multiplier = 1.2;
            break;
        case 'L':
            $multiplier = 1.4;
            break;
        default:
            $multiplier = 1;
    }
    
    // Cập nhật giá theo size
    $newProduct['price'] = $newProduct['price'] * $multiplier;
    
    // Thêm thông tin size vào sản phẩm
    $newProduct['size'] = $size;
    
    // Tính tổng giá topping
    $toppingPrice = 0;
    if (!empty($toppings)) {
        $toppingInfo = [];
        foreach ($toppings as $toppingId) {
            $sql = "SELECT nametopping, pricetopping FROM topping WHERE idtopping = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $toppingId);
            $stmt->execute();
            $result = $stmt->get_result();
            $toppingData = $result->fetch_assoc();
            
            $toppingInfo[] = [
                'id' => $toppingId,
                'name' => $toppingData['nametopping'],
                'price' => $toppingData['pricetopping']
            ];
            $toppingPrice += $toppingData['pricetopping'];
        }
        $newProduct['toppings'] = $toppingInfo;
    } else {
        $newProduct['toppings'] = [];
    }
    
    // Cập nhật giá cuối cùng (bao gồm size và topping)
    $newProduct['final_price'] = $newProduct['price'] + $toppingPrice;
    
    // Tạo key duy nhất cho sản phẩm
    $cartKey = $id . '_' . $size . '_' . implode('_', $toppings);
    
    if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
        $newProduct['qty'] = $quantity;
        $_SESSION['cart'][$cartKey] = $newProduct;
    } else {
        if (array_key_exists($cartKey, $_SESSION['cart'])) {
            $newQuantity = $_SESSION['cart'][$cartKey]['qty'] + $quantity;
            if ($newQuantity <= $newProduct['amount']) {
                $_SESSION['cart'][$cartKey]['qty'] = $newQuantity;
            } else {
                echo "0";
                exit;
            }
        } else {
            $newProduct['qty'] = $quantity;
            $_SESSION['cart'][$cartKey] = $newProduct;
        }
    }
    
    echo "1";
} else {
    echo "0";
}
