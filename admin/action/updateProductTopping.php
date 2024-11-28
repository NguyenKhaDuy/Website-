<?php
require "../../PHP/database.php";
require "../../PHP/code.php";
// echo $_GET['id'];
//cập nhật đơn hàng
//lấy thông tin đơn hàng hiện lên form
$id = $_GET['id'];
$result = getProductById($id)->fetch_assoc();
?>
<input id="idProductInput" type="text" hidden name="id" value="<?php echo $id ?>">

<div class="form-group">
    <label for="title" class=" form-control-label"><b>Tên sản phẩm</b></label><br>
    <label for="title" class=" form-control-label"><?php echo $result['title'] ?></label>
</div>
<div class="form-group">
    <label for="price" class=" form-control-label"><b>Topping</b></label><br>

    <?php
    // Fetch all toppings
    $toppings = getTopping()->fetch_all(MYSQLI_ASSOC);

    // Fetch all product toppings once
    $productToppings = [];
    $productToppingResult = getAllProductToppingById($id);
    while ($row = $productToppingResult->fetch_assoc()) {
        $productToppings[] = $row['id_topping'];
    }

    // Generate checkboxes
    foreach ($toppings as $topping) {
        $isChecked = in_array($topping['idtopping'], $productToppings);
    ?>
        <div style="display: flex;">
            <input style="width: 15px;" value="<?php echo $topping['idtopping']; ?>" <?php if ($isChecked) echo 'checked'; ?> class="form-control" type="checkbox" name="idtopping" id="idtopping">
            <label style="margin: 0 0 0 10px;" for="<?php echo htmlspecialchars($topping['idtopping']); ?>">
                <?php echo htmlspecialchars($topping['nametopping']); ?>
            </label>
        </div>
    <?php
    }
    ?>

</div>

<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
    <button type="button" class="btn btn-primary" id="btnChinhSua" onclick="updateRowProductTopping()">Chỉnh sửa</button>
</div>