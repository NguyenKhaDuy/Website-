<?php
require "../../PHP/database.php";
require "../../PHP/code.php";
$result = getInfoToppingId($_GET['id']);
$row = $result->fetch_assoc();
//cập nhật lại thông tin danh mục vừa mới sủa đổi
?>
<td><?php echo $row['nametopping'] ?></td>
<td><?php echo $row['pricetopping'] ?></td>
<td>
    <div class="table-data-feature">
        <button onclick="updateTopping(<?php echo $row['idtopping'] ?>)" style="margin:2px;" type="button" class="btn btn-secondary  mb-1" data-toggle="modal" data-target="#updateTopping">
            <i class="zmdi zmdi-edit"></i>
        </button>
        <button style="margin:2px;" class="btn btn-secondary  mb-1" data-toggle="tooltip" data-placement="top" title="Delete" onclick="deleteTopping(<?php echo $row['idtoping']  ?>)">
            <i class="zmdi zmdi-delete"></i>
        </button>
    </div>
</td>