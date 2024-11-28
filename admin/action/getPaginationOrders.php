<?php
//hiện sô trang 
//ví dụ mỗi trang chỉ hiện được 10 đơn hàng mà có tận 30 đơn hàng thì sẽ hiên len 3 trang
require "../../PHP/database.php";
require "../../PHP/code.php";
if (isset($_GET['cur_numpage'])) {
    $cur_numpage = $_GET['cur_numpage'];
} else {
    $cur_numpage = 1;
}
// echo $cur_numpage;
?>
<nav aria-label="...">
    <ul class="pagination pagination-sm">
        <?php
        $result = getOrderNoNumpage();
        $numpage = ceil($result->num_rows / 7);
        for ($i = 1; $i <= $numpage; $i++) {
            $pos = ($i - 1) * 7;
        ?>
            <li class="page-item <?php if ($i == $cur_numpage) echo "active" ?>">
                <button class="page-link" type="button" onclick="getOrder(<?php echo $pos ?>,<?php echo $i ?>)"><?php echo $i ?></button>
            </li>
        <?php
        } ?>
    </ul>
</nav>