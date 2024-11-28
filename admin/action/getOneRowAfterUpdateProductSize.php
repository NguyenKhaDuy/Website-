<?php
require "../../PHP/database.php";
require "../../PHP/code.php";
$result = getInfoProductSizeId($_GET['id']);
$row = $result->fetch_assoc();
//cập nhật lại thông tin sản phẩm vừa mới sủa đổi
?>
<td><?php echo $row['id'] ?></td>
<td><?php echo $row['title'] ?></td>
<td><?php echo $row['size'] ?></td>
<td><?php echo number_format($row['price']) ?>VND</td>
<td>
    <div class="table-data-feature">
        <button onclick="updateProductSize(<?php echo $row['id'] ?>)" style="margin:2px;" type="button" class="btn btn-secondary  mb-1" data-toggle="modal" data-target="#updateProductSize">
            <i class="zmdi zmdi-edit"></i>
        </button>
        <button style="margin:2px;" class="btn btn-secondary  mb-1" data-toggle="tooltip" data-placement="top" onclick="deleteProduct(<?php echo $row['id'] ?>)" title="Delete">
            <i class="zmdi zmdi-delete"></i>
        </button>
    </div>
</td>