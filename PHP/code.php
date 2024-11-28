<?php
define('max_page', 12);
// lấy sản phẩm mới nhất
function getNewestProduct()
{
    global $conn;
    $sql = "SELECT * FROM products ORDER BY id DESC LIMIT 0,8";
    return $conn->query($sql);
}

function getCasebook()
{
    global $conn;
    $sql = "SELECT * FROM cases";
    return $conn->query($sql);
}
function getCase($numpage)
{
    global $conn;
    $sql = "SELECT * FROM cases LIMIT $numpage,7";
    return $conn->query($sql);
}
function getInfoCasebook($casebook)
{
    global $conn;
    $sql = "SELECT * FROM cases WHERE casebook='$casebook'";
    return $conn->query($sql);
}

function getInfoCasebookId($id)
{
    global $conn;
    $sql = "SELECT * FROM cases WHERE id='$id'";
    return $conn->query($sql);
}
function updateCasebook($casebook, $name, $old_casebook)
{
    global $conn;
    $sql = "UPDATE cases SET casebook='$casebook',name='$name' WHERE casebook='$old_casebook'";

    return $conn->query($sql);
}
function getFourBooksCasebook($casebook)
{
    global $conn;
    $sql = "SELECT * FROM products WHERE casebook ='$casebook' LIMIT 0,8";
    return $conn->query($sql);
}
function getBestSellerBook()
{
    global $conn;
    $sql = "SELECT * FROM products ORDER BY count_buying DESC LIMIT 0,8";
    return $conn->query($sql);
}
function getBooksByCasebook($casebook, $numpage)
{
    global $conn;
    $sql = "SELECT * FROM products WHERE casebook='$casebook' LIMIT $numpage,12";
    return $conn->query($sql);
}
function getAmountByCasebook($casebook)
{
    global $conn;
    $sql = "SELECT * FROM products WHERE casebook='$casebook'";
    return $conn->query($sql);
}
function getProductById($id)
{
    global $conn;
    $sql = "SELECT * FROM products WHERE id='$id'";
    return $conn->query($sql);
}
function getOrderByIdUser($idUser)
{
    global $conn;
    $sql = "SELECT * FROM orders WHERE idUser='$idUser'";
    return $conn->query($sql);
}
function getAllProduct($numpage)
{
    global $conn;
    $sql = "SELECT * FROM products LIMIT $numpage,7";
    return $conn->query($sql);
}
function getAllProductNoNumpage()
{
    global $conn;
    $sql = "SELECT * FROM products";
    return $conn->query($sql);
}
function getAllUser($numpage)
{
    global $conn;
    $sql = "SELECT * FROM users LIMIT $numpage,7";
    return $conn->query($sql);
}
function getAllUserNoNumpage()
{
    global $conn;
    $sql = "SELECT * FROM users";
    return $conn->query($sql);
}
function getOrder($numpage)
{
    global $conn;
    $sql = "SELECT * FROM orders LIMIT $numpage,7";
    return $conn->query($sql);
}
function getOrderById($id)
{
    global $conn;
    $sql = "SELECT * FROM orders WHERE id = '$id'";
    return $conn->query($sql);
}
function getOrderNoNumpage()
{
    global $conn;
    $sql = "SELECT * FROM orders";
    return $conn->query($sql);
}
function getUserByIdUser($id)
{
    global $conn;
    $sql = "SELECT * FROM users WHERE id='$id'";
    return $conn->query($sql);
}
function getInformationOrder($idPackage)
{
    global $conn;
    $sql = "SELECT * FROM informationorder WHERE idPackage = '$idPackage'";
    return $conn->query($sql);
}
function getProductBySearch($value, $numpage)
{
    global $conn;
    $sql = "SELECT * FROM products WHERE title LIKE '%$value%' OR casebook LIKE '%$value%' LIMIT $numpage,7";
    return $conn->query($sql);
}
// function sortProduct($option,$numpage,$sort){
//     global $conn;
//     $sql = "SELECT * FROM products ORDER BY $option "
function getProductBySearchNoNumpage($value)
{
    global $conn;
    $sql = "SELECT * FROM products WHERE title LIKE '%$value%' OR casebook LIKE '%$value%'";
    return $conn->query($sql);
}
function updateDiscoutingProduct($id, $discounting)
{
    global $conn;
    $sql = "UPDATE products SET discounting='$discounting' WHERE id ='$id'";
    return $conn->query($sql);
}
function getDiscounting()
{
    global $conn;
    $sql = "SELECT * FROM discounting";
    return $conn->query($sql);
}
function getInformationProductDiscountingById($id) // lấy hết tất cả sản phẩm theo giảm giá
{
    global $conn;
    $sql = "SELECT * FROM products_discounting WHERE idDiscounting='$id'";
    return $conn->query($sql);
}
function getInformationProductDiscountingByIdProduct($id) // lấy hết tất cả sản phẩm theo giảm giá
{
    global $conn;
    $sql = "SELECT * FROM products_discounting WHERE idProduct='$id'";
    return $conn->query($sql);
}
function getDiscountingById($id) //lấy thông tin giảm giá theo id
{
    global $conn;
    $sql = "SELECT * FROM discounting WHERE id='$id'";
    return $conn->query($sql);
}
function getProductsWithoutDiscounting($idDiscounting) //lấy sản phẩm không có giảm giá
{
    global $conn;
    $sql = "SELECT * FROM products WHERE not EXISTS (SELECT * FROM products_discounting WHERE products_discounting.idProduct=products.id AND products_discounting.idDiscounting='$idDiscounting')";
    return $conn->query($sql);
}
function getDiscountingToday() //lấy giảm giá ngày hôm nay
{
    global $conn;
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $date = new DateTime();
    //echo date_format($date, "Y-m-d");
    $date_format = date_format($date, "Y-m-d");
    $sql = "SELECT * FROM discounting WHERE time_start <= '$date_format' AND '$date_format' <= time_end ";
    return $conn->query($sql);
}
function getProductByIdDiscounting($id) //cùng line147
{
    global $conn;
    $sql = "SELECT * FROM products_discounting WHERE idDiscounting = '$id' ";
    return $conn->query($sql);
}
function checkProductIsDiscounting($idProduct)
{
    global $conn;
    $idProduct1 = intval($idProduct);
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $date = new DateTime();
    //echo date_format($date, "Y-m-d");
    $date_format = date_format($date, "Y-m-d");
    $sql = "SELECT * FROM discounting,products_discounting WHERE time_start <= '$date_format' AND '$date_format' <= time_end  AND discounting.id = products_discounting.idDiscounting AND products_discounting.idProduct = $idProduct1";
    if (($result = $conn->query($sql)) && $result->num_rows > 0) {
        return true;
    } else {
        return false;
    }
    // print_r($result->fetch_assoc());
    // $bool = null;
    // if ($result->num_rows != 0) {
    //     $discounting = $result->fetch_assoc();
    //     $sql = "select * from products_discounting where idProduct='$idProduct' AND idDiscounting ='{$discounting['id']}'";
    //     $bool = $conn->query($sql);
    //     //echo $sql;
    // } else {
    //     $bool = null;
    // }
    // return $bool->num_rows;
    // //echo $bool->num_rows;
}


function getdiscountingInformationOrder($idOrder)
{
    global $conn;
    $sql = "SELECT * FROM informationorder_discounting, orders WHERE idOrder='$idOrder' AND orders.id = informationorder_discounting.idOrder";
    return $conn->query($sql);
}

function getSumEvaluateProduct($idproduct){
    global $conn;
    $stmt = $conn->prepare("SELECT SUM(evaluate) AS total_evaluate FROM products_evaluate WHERE id_product = ?");
    $stmt->bind_param("i", $idproduct);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return $row['total_evaluate'] ?? 0;
}

function getCountUserEvaluate($idproduct) {
    global $conn;
    $stmt = $conn->prepare("SELECT COUNT(id_user) AS countUser FROM products_evaluate WHERE id_product = ?");
    $stmt->bind_param("i", $idproduct);
    $stmt->execute();
    
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    return (int)($row['countUser'] ?? 0);  // Explicitly cast to integer for clarity
}

function getTopping()
{
    global $conn;
    $sql = "SELECT * FROM topping";
    return $conn->query($sql);
}

function updateTopping()
{
    global $conn;
    $sql = "SELECT * FROM topping";
    return $conn->query($sql);
}

function getInfoToppingId($id)
{
    global $conn;
    $sql = "SELECT * FROM topping WHERE idtopping='$id'";
    return $conn->query($sql);
}

function getToppingPage($numpage)
{
    global $conn;
    $sql = "SELECT * FROM topping LIMIT $numpage,7";
    return $conn->query($sql);
}

function getProductOdersDiscounting($idPackage)
{
    global $conn;
    $sql = "SELECT * FROM informationorder_discounting AS iod WHERE iod.idOrder = $idPackage";

    $result = $conn->query($sql);

    return $result;
}


function getOderTopping($idOrder, $id_product)
{
    global $conn;
    $sql = "SELECT * FROM `orders_topping` WHERE idOrder = $idOrder AND id_product = $id_product";

    $result = $conn->query($sql);

    return $result;
}

function getAllProductToppingGB($numpage)
{
    global $conn;
    $sql = "SELECT * FROM `information_productstopping` GROUP BY id_product LIMIT $numpage,7 ";

    $result = $conn->query($sql);

    return $result;
}

function getAllProductToppingNoNumpage()
{
    global $conn;
    $sql = "SELECT * FROM `information_productstopping` GROUP BY id_product";

    $result = $conn->query($sql);

    return $result;
}

function getAllProductTopping($numpage)
{
    global $conn;
    $sql = "SELECT * FROM `information_productstopping` LIMIT $numpage,7 ";

    $result = $conn->query($sql);

    return $result;
}

function getProductToppingById($id_product)
{
    global $conn;
    $sql = "SELECT * FROM `information_productstopping`WHERE id_product = $id_product";

    $result = $conn->query($sql);

    return $result;
}

function getAllProductToppingById($id)
{
    global $conn;
    $sql = "SELECT * FROM `information_productstopping` WHERE id_product = $id";

    $result = $conn->query($sql);

    return $result;
}

function getAllProductToppingByIdGB($id)
{
    global $conn;
    $sql = "SELECT * FROM `information_productstopping` WHERE id_product = $id GROUP BY id_product";

    $result = $conn->query($sql);

    return $result;
}
