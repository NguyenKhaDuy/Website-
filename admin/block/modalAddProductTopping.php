<div class="modal fade" id="addNewProductTopping" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mediumModalLabel">Thêm topping sản phẩm</h5>
                <button type="button" id="close" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formAddNewProductTopping" action="action/addNewTopping.php" method="post" class="" enctype='multipart/form-data'>
                    <div class="form-group">
                        <label for="price" class=" form-control-label">Sản phẩm</label>
                        <select name="casebook" id="select" class="form-control">
                            <?php
                            $danhmuc = getAllProductNoNumpage();
                            $i = 0;
                            while ($row = $danhmuc->fetch_assoc()) {
                            ?>
                                <option id="selected" value="<?php echo $row['id'] ?>"><?php echo $row['title'] ?></option>
                            <?php
                            } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="price" class=" form-control-label">Topping</label>
                        <?php
                        $result = getTopping();
                        while ($row = $result->fetch_assoc()) {
                        ?>
                            <div style="display: flex;">
                                <input style="width: 15px;" value="<?php echo $row['idtopping']; ?>" class="form-control topping" type="checkbox" name="idtopping" id="idtopping">
                                <label style="margin: 0 0 0 10px;" for="<?php echo htmlspecialchars($row['idtopping']); ?>">
                                    <?php echo htmlspecialchars($row['nametopping']); ?>
                                </label>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" id="btnThem" onclick="addNewProductTopping()">Thêm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>