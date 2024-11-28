    <?php
    //Xáo danh mục
    require "../../PHP/database.php";
    $id = $_POST['id'];
    $sql = "DELETE FROM `information_productstopping` WHERE id_product = '$id'";
    $conn->query($sql);
    echo "1";
