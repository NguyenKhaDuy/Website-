<?php
// require "../../database.php";
// require "../../code.php";
//xme thêm thông tin chi tiết của sản phẩm
require "../../PHP/database.php";
require "../../PHP/code.php";
$id = $_POST['id'];
$result = getProductById($id);
$info = $result->fetch_assoc();

$resultIdProduct = getInformationProductDiscountingByIdProduct($id);
$row = $resultIdProduct->fetch_assoc();
?>
<img style="margin:auto;display:block;width:200px;height:250px" src="../PHP/public/<?php echo $info['img'] ?>" alt="">
<table class="table table-bordered">
    <thead>
        <tr>
            <th scope="col">Mục</th>
            <th scope="col">Thông tin</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <th scope="row">Tựa đề</th>
            <td><?php echo $info['title'] ?></td>
        </tr>
        <tr>
            <th scope="row">Tác giả</th>
            <td><?php echo $info['summary'] ?></td>
        </tr>
        <tr>
            <th scope="row">Danh mục</th>
            <td><?php echo $info['casebook'] ?></td>
        </tr>
        <tr>
            <th scope="row">Giá</th>
            <td><?php echo number_format($info['price']) ?>VND</td>
        </tr>
        <tr>
            <th scope="row">Số lượng</th>
            <td><?php echo $info['amount'] ?> Quyển</td>
        </tr>
        <tr>
            <th scope="row">Lượt yêu thích</th>
            <td><?php echo $info['love'] ?></td>
        </tr>
        <tr>
            <th scope="row">Số lượng bán</th>
            <td><?php echo $info['count_buying'] ?></td>
        </tr>
        <tr>
            <th scope="row">Giảm giá</th>
            <td>
                <?php
                if (isset($row['idDiscounting'])) {
                    echo '<span class="role user">Đang giảm giá</span>';
                } else {
                    echo '<span class="role admin">Không có giảm giá</span>';
                }
                ?>
            </td>
        </tr>
    </tbody>
</table>