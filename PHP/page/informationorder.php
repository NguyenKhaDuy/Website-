<?php
require "component/public/bradcaump.php";
$idPackage = $_GET['id'];
$idUser = $_SESSION['idUser'];
$sql = "SELECT * FROM informationorder WHERE idPackage = '$idPackage'"; //lấy chi tiết sp đơn hàng
$result = $conn->query($sql);
$total = 0;
$order = getOrderById($idPackage)->fetch_assoc(); // lấy thông tin đơn hàng 
?>


<table class="table table-bordered" style="width:80%; margin:5px auto">
    <tr class="table-info">
        <th>id Sản phẩm</th>
        <th>Tên sản phẩm</th>
        <th>Ảnh</th>
        <th>Giá</th>
        <th>Số lượng</th>
        <th>Giảm Giá</th>
    </tr>
    <?php
    while ($row = $result->fetch_assoc()) {
        $info = getProductById($row['idProduct'])->fetch_assoc();
        $total += $info['price'] * $row['qty'];
    ?>

        <tr>
            <td><a href="?page=product&id=<?php echo $row['idProduct'] ?>"><?php echo $row['idProduct'] ?></a></td>
            <td><a href="?page=product&id=<?php echo $row['idProduct'] ?>"><?php echo $info['title'] ?></a></td>
            <td><a href="?page=product&id=<?php echo $row['idProduct'] ?>"><img style="width:100px;height:140px" src="public/<?php echo $info['img'] ?>" alt=""></a></td>
            <td><?php echo number_format($info['price']) ?>VND</td>
            <td><?php echo $row['qty'] ?></td>
            <td>Không có giảm giá</td>
        </tr>

    <?php
    } ?>
    <?php
    $result = getdiscountingInformationOrder($idPackage);
    while ($row = $result->fetch_assoc()) {
        $info = getProductById($row['idProduct'])->fetch_assoc();
        $discounting = getDiscountingById($row['idDiscounting'])->fetch_assoc();
    ?>
        <tr>
            <td><a href="?page=product&id=<?php echo $row['id'] ?>"><?php echo $row['idProduct'] ?></a></td>
            <td><a href="?page=product&id=<?php echo $orw['id'] ?>"><?php echo $info['title'] ?></a></td>
            <td><a href="?page=product&id=<?php echo $row['id'] ?>"><img style="width:100px;height:140px" src="public/<?php echo $info['img'] ?>" alt=""></a></td>
            <td><?php echo number_format($row['price']) ?>VND</td>
            <td><?php echo $row['qty'] ?></td>
            <td><?php echo $discounting['title'] ?>(<?php echo $discounting['percent'] ?>%)</td>
        </tr>

    <?php } ?>

    <tr>
        <td colspan="6" style="overflow:hidden"><a style="float:left" href="<?php echo $_SERVER['HTTP_REFERER'] ?>">Trở lại</a><a style="float:right">Tổng cộng:<?php echo number_format($order['total'] - $order['total_discounting']) ?>VND</a> </td>
    </tr>
</table>