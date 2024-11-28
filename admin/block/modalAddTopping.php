<div class="modal fade" id="addNewTopping" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mediumModalLabel">Thêm Topping</h5>
                <button type="button" id="close" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formAddNewTopping" action="action/addNewTopping.php" method="post" class="" enctype='multipart/form-data'>
                    <div class="form-group">
                        <label for="title" class=" form-control-label">Tên Topping</label>
                        <input type="text" name="nametopping" id="nametopping" placeholder="Mời nhập tên Topping" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="title" class=" form-control-label">Gía Topping</label>
                        <input type="text" name="pricetopping" id="pricetopping" placeholder="Mời nhập giá Topping" class="form-control">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" id="btnThem" onclick="addNewTopping()">Thêm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>