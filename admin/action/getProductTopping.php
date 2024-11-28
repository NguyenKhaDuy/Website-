<?php
// require "../../database.php";
// require "../../code.php";
require "../../PHP/database.php";
require "../../PHP/code.php";
$numpage = $_POST['num'];
//Hàm lấy ra sản phẩm
?>
<?php
$result = getAllProductToppingGB($numpage);
while ($row = $result->fetch_assoc()) {
    $product = getProductById($row['id_product'])->fetch_assoc();
    $result1 = getProductToppingById($row['id_product']);
    $toppingNames = [];
    while ($row1 = $result1->fetch_assoc()) {
        $topping = getInfoToppingId($row1['id_topping'])->fetch_assoc();
        $toppingNames[] = $topping['nametopping'];
    }
?>
    <tr id="tr<?php echo $product['id'] ?>">
        <td><?php echo $product['id'] ?></td>
        <td><?php echo $product['title'] ?></td>
        <td><?php echo implode('<br>', $toppingNames); ?></td>
        <td>
            <div class="table-data-feature">
                <button onclick="updateProductTopping(<?php echo $product['id'] ?>)" style="margin:2px;" type="button" class="btn btn-secondary  mb-1" data-toggle="modal" data-target="#updateProductTopping">
                    <i class="zmdi zmdi-edit"></i>
                </button>
                <button style="margin:2px;" class="btn btn-secondary  mb-1" data-toggle="tooltip" data-placement="top" onclick="deleteProductTopping(<?php echo $product['id'] ?>)" title="Delete">
                    <i class="zmdi zmdi-delete"></i>
                </button>
            </div>
        </td>
    </tr>
<?php
}
?>