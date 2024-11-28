<?php
require "../../PHP/database.php";
require "../../PHP/code.php";
//cập nhật đơn hàng
//lấy thông tin đơn hàng hiện lên form
$id = $_GET['id'];
$result = getOrderById($id)->fetch_assoc();
?>
<input type="text" hidden name="id" value="<?php echo $id ?>">

<div class="form-group">
    <label for="price" class=" form-control-label">Id User</label>
    <select name="idUser" id="select" class="form-control">
        <?php
        $user = getAllUserNoNumpage();
        while ($row = $user->fetch_assoc()) {
        ?>
            <option <?php if ($result['idUser'] == $row['id']) {
                        echo "selected";
                    } ?> value="<?php echo $row['id'] ?>"><?php echo $row['username'] ?></option>
        <?php
        } ?>
    </select>
</div>

<div class="form-group">
    <label for="title" class=" form-control-label">Thời gian đặt hàng</label>
    <input value="<?php echo $result['datetime'] ?>" type="datetime-local" name="datetime" id="datetime" class="form-control">
</div>

<div class="form-group">
    <label for="title" class=" form-control-label">Tổng giá trị hóa đơn</label>
    <input value="<?php echo $result['total'] ?>" type="number" name="total" id="total" placeholder="Nhập tổng giá trị hóa đơn" class="form-control">
</div>

<div class="form-group">
    <label for="title" class=" form-control-label">Trạng thái đơn hàng</label>
    <input value="<?php echo $result['delivery'] ?>" type="number" min="0" max="1" name="delivery" id="delivery" placeholder="Nhập tổng giá trị hóa đơn" class="form-control">
</div>

<div class="form-group">
    <label for="title" class=" form-control-label">Tổng tiền giảm giá</label>
    <input value="<?php echo $result['total_discounting'] ?>" type="number" name="total_discounting" id="total_discounting" placeholder="Nhập tổng giá trị hóa đơn" class="form-control">
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
    <button type="button" class="btn btn-primary" id="btnChinhSua" onclick="updateOrderInDatabase()">Chỉnh sửa</button>
</div>