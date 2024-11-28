<?php
session_start();
require "../code.php";
require "../database.php";

$total = 0;
$discounting = 0;
$discounting_today = getDiscountingToday()->fetch_assoc();

// Tính toán lại tổng tiền và giảm giá
if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $product) {
        $total += $product['final_price'] * $product['qty']; // Sử dụng final_price thay vì price
        $discounting += checkProductIsDiscounting($product['id']) ? 
            ($product['final_price'] * $product['qty']) * ($discounting_today['percent'] / 100) : 0;
    }
}

// HTML cho box package
?>
<h3 class="onder__title">Đơn hàng của bạn</h3>
<ul class="order__total">
    <li>Tổng cộng:</li>
    <li><?php echo number_format($total) ?>VND</li>
</ul>
<ul class="order__total">
    <li>Giảm giá: </li>
    <li><?php echo number_format($discounting) ?>VND</li>
</ul>
<ul class="total__amount">
    <li>Tạm tính: <span><?php echo number_format($total - $discounting) ?>VND</span></li>
</ul>
<button type="button" style="display:block; margin:auto" class="btn btn-success" onclick="buy()">Thanh toán</button>