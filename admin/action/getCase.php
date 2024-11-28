<?php
// require "../../database.php";
// require "../../code.php";
require "../../PHP/database.php";
require "../../PHP/code.php";
$numpage = $_POST['num'];
//Hàm lấy ra sản phẩm
?>
<?php
$result = getCase($numpage);
while ($row = $result->fetch_assoc()) {
?>
    <tr id="tr<?php echo $row['casebook'] ?>">
        <td><?php echo $row['casebook'] ?></td>
        <td><?php echo $user['name']  ?></td>
        <td>
            <div class="table-data-feature">
                <button class="item" data-toggle="tooltip" data-placement="top" title="Edit">
                    <i class="zmdi zmdi-edit"></i>
                </button>
                <button class="item" data-toggle="tooltip" data-placement="top" title="Delete">
                    <i class="zmdi zmdi-delete"></i>
                </button>
            </div>
        </td>
    </tr>
<?php
}
?>