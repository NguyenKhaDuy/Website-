    <?php
    //Xáo danh mục
    require "../../PHP/database.php";
    $id = $_POST['id'];
    $sql = "DELETE FROM cases WHERE id = '$id'";
    $conn->query($sql);
    echo "1";
