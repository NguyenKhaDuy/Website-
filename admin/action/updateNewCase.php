<?php
//hiện danh mục vừa mới thêm vào 
require "../../PHP/database.php";
require "../../PHP/code.php";

$sql = 'SELECT MAX(id) FROM cases';
$result = $conn->query($sql);
$id = $result->fetch_assoc();
$row = getInfoCasebookId($id['MAX(id)'])->fetch_assoc();
?>
<tr id="tr<?php echo $row['id'] ?>">
    <td><?php echo $row['name'] ?></td>
    <td><?php echo $row['casebook'] ?></td>
    <td>
        <div class="table-data-feature">
            <div class="table-data-feature">
                <button onclick="updateCase(<?php echo $row['id'] ?>)" style="margin:2px;" type="button" class="btn btn-secondary  mb-1" data-toggle="modal" data-target="#updateCase">
                    <i class="zmdi zmdi-edit"></i>
                </button>
                <button style="margin:2px;" class="btn btn-secondary  mb-1" data-toggle="tooltip" data-placement="top" title="Delete" onclick="deleteCase(<?php echo $row['id']  ?>)">
                    <i class="zmdi zmdi-delete"></i>
                </button>
            </div>
        </div>
    </td>
</tr>