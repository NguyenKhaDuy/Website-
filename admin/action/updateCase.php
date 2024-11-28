<?php
//cập nhật thông tin danh mục
//lấy thông tin danh mục hiện lên form
require "../../PHP/database.php";
require "../../PHP/code.php";
// echo $_GET['id'];
$id = $_GET['id'];
$result = getInfoCasebookId($id)->fetch_assoc();
?>
<input type="text" hidden name="id" value="<?php echo $id ?>">

<div class="form-group">
    <label for="title" class=" form-control-label">Mã danh mục</label>
    <input value="<?php echo $result['casebook'] ?>" type="text" name="casebook" id="casebook" class="form-control">
</div>

<div class="form-group">
    <label for="title" class=" form-control-label">Tên danh mục</label>
    <input value="<?php echo $result['name'] ?>" type="text" name="name" id="name" placeholder="Nhập tổng giá trị hóa đơn" class="form-control">
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
    <button type="button" class="btn btn-primary" id="btnChinhSua" onclick="updateCaseInDatabase()">Chỉnh sửa</button>
</div>