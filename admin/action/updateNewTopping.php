<?php
//hiện danh mục vừa mới thêm vào 
require "../../PHP/database.php";
require "../../PHP/code.php";

$sql = 'SELECT MAX(idtopping) FROM topping';
$result = $conn->query($sql);
$id = $result->fetch_assoc();
$row = getInfoToppingId($id['MAX(idtopping)'])->fetch_assoc();
?>
<tr id="tr<?php echo $row['idtopping'] ?>">
    <td><?php echo $row['nametopping'] ?></td>
    <td><?php echo $row['pricetopping'] ?></td>
    <td>
        <div class="table-data-feature">
            <div class="table-data-feature">
                <button onclick="updateTopping(<?php echo $row['idtopping'] ?>)" style="margin:2px;" type="button" class="btn btn-secondary  mb-1" data-toggle="modal" data-target="#updateCase">
                    <i class="zmdi zmdi-edit"></i>
                </button>
                <button style="margin:2px;" class="btn btn-secondary  mb-1" data-toggle="tooltip" data-placement="top" title="Delete" onclick="deleteTopping(<?php echo $row['idtopping']  ?>)">
                    <i class="zmdi zmdi-delete"></i>
                </button>
            </div>
        </div>
    </td>
</tr>