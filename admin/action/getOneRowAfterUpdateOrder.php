<?php
require "../../PHP/database.php";
require "../../PHP/code.php";
$result = getOrderById($_GET['id']);
$row = $result->fetch_assoc();
$user = getUserByIdUser($row['idUser'])->fetch_assoc();
//cập nhật lại thông tin đơn hàng vừa mới sủa đổi
?>
<td><?php echo $row['id'] ?></td>
<td><?php echo $user['username']  ?></td>
<td><?php echo $row['datetime'] ?></td>
<?php if ($row['delivery'] == 1) echo '<td disabled class="process"><input type="checkbox" checked>Đã xử lí</td>';
else echo '<td id="tdcheck' . $row['id'] . '" class="denied"><input onclick="processOrder(' . $row['id'] . ')" type="checkbox">Chưa xử lí</td>'; ?>
<td>
    <div class="table-data-feature">
        <button onclick="updateOrder(<?php echo $row['id'] ?>)" style="margin:2px;" type="button" class="btn btn-secondary  mb-1" data-toggle="modal" data-target="#updateOrder">
            <i class="zmdi zmdi-edit"></i>
        </button>
        <button style="margin:2px;" class="btn btn-secondary  mb-1" data-toggle="tooltip" data-placement="top" title="Delete" onclick="deleteOrder(<?php echo $row['id']  ?>)">
            <i class="zmdi zmdi-delete"></i>
        </button>
        <button style="margin:2px;" type="button" class="btn btn-secondary  mb-1" data-toggle="modal" data-target="#moreOrder" onclick="moreOrder(<?php echo $row['id'] ?>,<?php echo $row['idUser'] ?>)">
            <i class="zmdi zmdi-more"></i>
        </button>
    </div>
</td>