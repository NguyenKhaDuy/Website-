    <?php
    //Xáo danh mục
    require "../../PHP/database.php";
    $id = $_POST['id'];
    $sql = "DELETE FROM topping WHERE idtopping = '$id'";
    $conn->query($sql);
    echo "1";
