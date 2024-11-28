 <?php
    require "../../PHP/database.php";
    require "../../PHP/code.php";
    $result = getAllProductToppingByIdGB($_GET['id'])->fetch_assoc();
    $product = getProductById($result['id_product'])->fetch_assoc();
    $toppingNames = [];
    $result1 = getAllProductToppingById($_GET['id']);
    while ($row = $result1->fetch_assoc()) {
        $topping = getInfoToppingId($row['id_topping'])->fetch_assoc();
        $toppingNames[] = $topping['nametopping'];
    }
?>
 <td><?php echo $product['id'] ?></td>
 <td><?php echo $product['title'] ?></td>
 <td><?php echo implode('<br>', $toppingNames); ?></td>
 <td>
     <div class="table-data-feature">
         <button onclick="updateProductTopping(<?php echo $product['id'] ?>)" style="margin:2px;" type="button" class="btn btn-secondary  mb-1" data-toggle="modal" data-target="#updateProductTopping">
             <i class="zmdi zmdi-edit"></i>
         </button>
         <button style="margin:2px;" class="btn btn-secondary  mb-1" data-toggle="tooltip" data-placement="top" onclick="deleteProduct(<?php echo $row['id'] ?>)" title="Delete">
             <i class="zmdi zmdi-delete"></i>
         </button>
     </div>
 </td>