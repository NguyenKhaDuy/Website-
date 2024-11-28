<?php
//cập nhật thông tin danh mục
//lấy thông tin danh mục hiện lên form
require "../../PHP/database.php";
require "../../PHP/code.php";
// echo $_GET['id'];
$id = $_GET['id'];
$result = getInfoToppingId($id)->fetch_assoc();
?>
<input type="text" hidden name="id" value="<?php echo $id ?>">

<div class="form-group">
    <label for="title" class=" form-control-label">Tên Topping</label>
    <input value="<?php echo $result['nametopping'] ?>" type="text" name="nametopping" id="nametopping" placeholder="Nhập tên topping"  class="form-control">
</div>

<div class="form-group">
    <label for="title" class=" form-control-label">Giá Topping</label>
    <input value="<?php echo $result['pricetopping'] ?>" type="text" name="pricetopping" id="pricetopping" placeholder="Nhập giá topping" class="form-control">
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
    <button type="button" class="btn btn-primary" id="btnChinhSua" onclick="updateToppingInDatabase()">Chỉnh sửa</button>
</div>