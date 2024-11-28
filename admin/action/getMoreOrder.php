<?php
// require "../../database.php";
// require "../../code.php";
//Hàm xem chi tiết thông tin đơn đặt hàng
require "../../PHP/database.php";
require "../../PHP/code.php";
$id = $_GET['id'];
$idUser = $_GET['idUser'];
$result = getInformationOrder($id, $idUser);
$order = getOrderById($id)->fetch_assoc();
$total_discouting = $order['total_discounting'];
$tong = 0;
?>
<p>Ngày đặt: <?php echo $order['datetime'] ?></p>
<p>Xử lý: <?php if ($order['delivery']) echo "Đã xử lý";
            else echo "Chưa xử lý" ?></p>
<table class="table table-bordered">
    <thead>
        <tr>
            <th scope="col">Mã sản phẩm</th>
            <th scope="col">Hình ảnh</th>
            <th scope="col">Tên sản phẩm</th>
            <th scope="col">Size</th>
            <th scope="col">Giá</th>
            <th scope="col">Số lượng</th>
            <th scope="col">Topping</th>
            <th scope="col">Giá Topping</th>
            <th scope="col">Giảm giá</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $result->fetch_assoc()) {
            $product = getProductById($row['idProduct'])->fetch_assoc();
            $size = getSizeId($row['idsize'])->fetch_assoc();
            // Fetch toppings associated with the current product order
            $orderToppingsResult = getOderTopping($row['idPackage'], $row['idProduct']);
            $toppingNames = [];
            $tongTopping = 0;
            while ($toppingRow = $orderToppingsResult->fetch_assoc()) {
                $topping = getInfoToppingId($toppingRow['id_topping'])->fetch_assoc();
                $toppingNames[] = $topping['nametopping'];
                $tongTopping += $topping['pricetopping'];
            }

            $tong += $row['price'] * $row['qty'] + $tongTopping;
        ?>
            <tr>
                <td><?php echo $product['id'] ?></td>
                <td><img style="width:100px;height:160px" src="../PHP/public/<?php echo $product['img'] ?>" alt=""></td>
                <td><?php echo $product['title'] ?></td>
                <td><?php echo $size['size'] ?></td>
                <td><?php echo number_format($row['price']) ?>VND</td>
                <td><?php echo $row['qty'] ?></td>
                <td><?php echo implode('<br>', $toppingNames); ?></td>
                <td><?php echo $tongTopping ?></td>
                <td><?php echo 0 ?></td>
            </tr>
        <?php
        } ?>

        <?php
        $productOrderDiscountingResult = getProductOdersDiscounting($id); // Fetch result set
        while ($row = $productOrderDiscountingResult->fetch_assoc()) {
            $product = getProductById($row['idProduct'])->fetch_assoc();
            $idDiscounting = $row['idDiscounting'];
            $discounting = getDiscountingById($idDiscounting)->fetch_assoc();
            $size = getSizeId($row['idsize'])->fetch_assoc();

            // Fetch toppings associated with the current product order
            $orderToppingsResult = getOderTopping($row['idOrder'], $row['idProduct']);
            $toppingNames = [];
            $tongTopping = 0;
            while ($toppingRow = $orderToppingsResult->fetch_assoc()) {
                $topping = getInfoToppingId($toppingRow['id_topping'])->fetch_assoc();
                $toppingNames[] = $topping['nametopping'];
                $tongTopping += $topping['pricetopping'];
            }

            $tong += $row['price'] * $row['qty'] + $tongTopping;

        ?>
            <tr>
                <td><?php echo $row['idProduct'] ?></td>
                <td><img style="width:100px;height:160px" src="../PHP/public/<?php echo htmlspecialchars($product['img']) ?>" alt=""></td>
                <td><?php echo htmlspecialchars($product['title']) ?></td>
                <td><?php echo $size['size'] ?></td>
                <td><?php echo number_format($row['price']) ?> VND</td>
                <td><?php echo $row['qty'] ?></td>
                <td><?php echo implode('<br>', $toppingNames); ?></td>
                <td><?php echo $tongTopping ?></td>
                <td><?php echo ($row['price'] * $discounting['percent']) / 100 ?></td>
            </tr>
        <?php
        }
        ?>


        <tr>
            <td colspan="4">Tổng tiển: <?php echo number_format($tong - $total_discouting);  ?>VND</td>
        </tr>
    </tbody>
</table>