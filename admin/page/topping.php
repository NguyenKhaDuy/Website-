<div class="table-data__tool">
    <div class="table-data__tool-left">
        <div class="rs-select2--light rs-select2--md">
            <select class="js-select2" name="property">
                <option selected="selected">All Properties</option>
                <option value="">Option 1</option>
                <option value="">Option 2</option>
            </select>
            <div class="dropDownSelect2"></div>
        </div>
        <div class="rs-select2--light rs-select2--sm">
            <select class="js-select2" name="time">
                <option selected="selected">Today</option>
                <option value="">3 Days</option>
                <option value="">1 Week</option>
            </select>
            <div class="dropDownSelect2"></div>
        </div>
        <button class="au-btn-filter">
            <i class="zmdi zmdi-filter-list"></i>filters</button>
    </div>
    <div class="table-data__tool-right">
        <button type="button" class="btn btn-success mb-1" data-toggle="modal" data-target="#addNewTopping">
            <i class="zmdi zmdi-plus"></i> Add item
        </button>
        <div class="rs-select2--dark rs-select2--sm rs-select2--dark2">
            <select class="js-select2" name="type">
                <option selected="selected">Export</option>
                <option value="">Option 1</option>
                <option value="">Option 2</option>
            </select>
            <div class="dropDownSelect2"></div>
        </div>
    </div>
</div>
<div class="table-responsive m-b-40">
    <table class="table table-borderless table-data3">
        <thead>
            <tr>
                <th>Tên Topping</th>
                <th>Giá Topping</th>
                <th></th>
            </tr>
        </thead>
        <tbody id="table_case">
            <?php
            $result = getTopping();
            while ($row = $result->fetch_assoc()) {
            ?>
                <tr id="tr<?php echo $row['idtopping'] ?>">
                    <td><?php echo $row['nametopping'] ?></td>
                    <td><?php echo $row['pricetopping'] ?></td>
                    <td>
                        <div class="table-data-feature">
                            <button onclick="updateTopping(<?php echo $row['idtopping'] ?>)" style="margin:2px;" type="button" class="btn btn-secondary  mb-1" data-toggle="modal" data-target="#updateTopping">
                                <i class="zmdi zmdi-edit"></i>
                            </button>
                            <button style="margin:2px;" class="btn btn-secondary  mb-1" data-toggle="tooltip" data-placement="top" title="Delete" onclick="deleteTopping(<?php echo $row['idtopping']?>)">
                                <i class="zmdi zmdi-delete"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
    <div class="card">
        <div id="pagination">
            <nav aria-label="...">
                <ul class="pagination pagination-sm">
                    <?php
                    $result = getTopping();
                    $numpage = ceil($result->num_rows / 7);
                    if ($numpage > 0)
                        for ($i = 1; $i <= $numpage; $i++) {
                            $pos = ($i - 1) * 7;
                    ?>
                        <li class="page-item <?php if ($i == 1) echo "active" ?>">
                            <button class="page-link" type="button" onclick="getTopping(<?php echo $pos ?>,<?php echo $i ?>)"><?php echo $i ?>
                            </button>
                        </li>
                    <?php
                        } ?>
                </ul>
            </nav>
        </div>
    </div>
</div>