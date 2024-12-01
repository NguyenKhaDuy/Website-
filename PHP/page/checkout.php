<?php
$discounting = 0;
$total = 0;
$total1 = 0;
$discounting_today = getDiscountingToday()->fetch_assoc();
require "component/public/bradcaump.php";
?>
<!-- cart-main-area start -->
<div class="wishlist-area section-padding--lg bg__white">
    <div class="container">
        <div class="row">
            <div class="col-lg-9 col-12 md-mt-40 sm-mt-40">
                <div class="wishlist-content">
                    <form action="#" id="form_buy">
                        <div class="wishlist-table wnro__table table-responsive">
                            <?php if (isset($_SESSION['cart']) && count($_SESSION['cart']) != 0) {
                            ?>
                                <table>
                                    <thead>
                                        <tr class="cart-header-row">
                                            <th class="product-remove"></th>
                                            <th class="product-thumbnail"></th>
                                            <th class="product-name"><span class="nobr">Tên sản phẩm</span></th>
                                            <th class="product-price"><span class="nobr">Đơn giá</span></th>
                                            <th class="product-price"><span class="nobr">Size</span></th>
                                            <th class="product-price"><span class="nobr">Topping</span></th>
                                            <th class="product-price"><span class="nobr">Số lượng</span></th>
                                            <th class="product-price"><span class="nobr">Tổng</span></th>
                                            <th class="product-stock-stauts"><span class="nobr">Giảm giá</span></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($_SESSION['cart'] as $cartKey => $product) {
                                            $total += $product['price'] * $product['qty'];
                                            $discounting += checkProductIsDiscounting($product['id']) ? ($product['price'] * $product['qty']) * ($discounting_today['percent'] / 100) : 0;
                                        ?>
                                            <tr id="tr<?php echo $cartKey ?>">
                                                <input type="text" hidden value=<?php echo $product['final_price'] ?> id="price<?php echo $product['id'] ?>">
                                                <input hidden type="text" name="checkout[<?php echo $product['id'] ?>][qty]" value="<?php echo $product['qty'] ?>" />
                                                <td class="product-remove"><a style="cursor:pointer" onclick="delete_cart('<?php echo $cartKey ?>')">×</a></td>
                                                <td class="product-thumbnail"><a href="#"><img style="width:100px !important;height:120px !important;max-width:100px !important" src="public/<?php echo $product['img'] ?>" alt=""></a></td>
                                                <td class="product-name">
                                                    <a href="#"><?php echo $product['title'] ?></a>
                                                </td>
                                                <td class="product-price">
                                                    <span class="amount"><?php echo number_format($product['price']) ?> VNĐ</span>
                                                </td>
                                                <td class="product-size">
                                                    <span>
                                                        <?php
                                                        $size = getSizeId($product['size'])->fetch_assoc();
                                                        echo $size['size'];
                                                        ?>
                                                    </span>
                                                </td>
                                                <td class="product-topping">
                                                    <?php if (!empty($product['toppings'])): ?>
                                                        <?php
                                                        $toppingNames = array_map(function ($topping) {
                                                            return $topping['name'];
                                                        }, $product['toppings']);
                                                        echo implode('<br>+</br>', $toppingNames);
                                                        ?>
                                                    <?php else: ?>
                                                        <span>Không có</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="product-quantity"><input class="form-control" style="width:80px" onclick="update_cart('<?php echo $cartKey ?>',this)" onchange="update_cart('<?php echo $product['id'] ?>',this)" min=1 type="number" value="<?php echo $product['qty'] ?>" /></td>
                                                <td class="product-subtotal"><span id="total<?php echo $product['id'] ?>"><?php echo number_format($product['final_price'] * $product['qty']) ?> VNĐ</span></td>
                                                <td class="product-discount"><span class="wishlist-in-stock"><?php if (checkProductIsDiscounting($product['id'])) echo $discounting_today['percent'];
                                                                                                                else echo 0.0 ?>%</span></td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            <?php
                            } else echo '<div class="alert alert-success" role="alert" style="text-align:center;font-size:1.2em">
                        Chưa có sản phẩm trong giỏ hàng
                      </div>' ?>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-3 col-12 md-mt-40 sm-mt-40">
                <div class="wn__order__box" id="box_package" style="overflow:hidden">
                    <h3 class="onder__title">ĐƠN HÀNG CỦA BẠN</h3>
                    <?php
                    $total = 0;
                    $discounting = 0;

                    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                        foreach ($_SESSION['cart'] as $cartKey => $product) {
                            // Sử dụng final_price thay vì price để tính tổng
                            $total += $product['final_price'] * $product['qty'];

                            // Tính giảm giá dựa trên final_price
                            if (checkProductIsDiscounting($product['id'])) {
                                $discounting += ($product['price'] * $product['qty']) * ($discounting_today['percent'] / 100);
                            }
                        }
                    }
                    ?>
                    <ul class="order__total">
                        <li>Tổng cộng:</li>
                        <li><?php echo number_format($total) ?>VND</li>
                    </ul>
                    <ul class="order__total">
                        <li>Giảm giá: </li>
                        <li><?php echo number_format($discounting) ?>VND</li>
                    </ul>
                    <ul class="total__amount">
                        <li>Tạm tính: <span><?php echo number_format($total - $discounting) ?>VND</span></li>
                    </ul>
                    <button type="button" style="display:block; margin:auto" class="btn btn-success" onclick="buy()">Thanh toán</button>
                    <script>
                        function buy() {
                            var isLoggedIn = <?php echo json_encode(isset($_SESSION['idUser'])); ?>;
                            var cartIsEmpty = <?php echo json_encode(isset($_SESSION['cart']) && count($_SESSION['cart']) > 0); ?>;

                            if (isLoggedIn) {
                                if (cartIsEmpty) {
                                    document.getElementById("paymentModal").style.display = "flex";

                                    $.ajax({
                                        type: "GET",
                                        url: "action/get_cart_info.php",
                                        success: function(response) {

                                            var data = JSON.parse(response);
                                            console.log(data);
                                            // Cập nhật lại tổng tiền và giảm giá trong modal
                                            document.getElementById("total").innerText = data.total.toLocaleString('vi-VN') + " " + "VND";
                                            document.getElementById("discounting").innerText = data.discounting.toLocaleString('vi-VN') + " " + "VND";
                                            document.getElementById("final_total").innerText = (data.total - data.discounting).toLocaleString('vi-VN') + " " + "VND";
                                            // Cập nhật thông tin các sản phẩm trong modal
                                            updateModalProducts(data.products);
                                            $.ajax({
                                                type: "GET",
                                                url: "action/updateBoxPackage.php",
                                                success: function(boxPackageData) {
                                                    $("#box_package").html(boxPackageData);
                                                }
                                            });
                                        }
                                    });
                                } else {
                                    alert("Chưa có sản phẩm nào trong giỏ hàng");
                                }
                            } else {
                                alert("Bạn cần đăng nhập trước khi mua hàng");
                            }
                        }
                    </script>
                </div>
                <div id="accordion" class="checkout_accordion mt--30" role="tablist">
                    <div class="payment">
                        <div class="che__header" role="tab" id="headingOne">
                            <a class="checkout__title" data-toggle="collapse" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                <span>Direct Bank Transfer</span>
                            </a>
                        </div>
                        <div id="collapseOne" class="collapse show" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion">
                            <div class="payment-body">Make your payment directly into our bank account. Please use your Order ID as the payment reference. Your order won’t be shipped until the funds have cleared in our account.</div>
                        </div>
                    </div>
                    <div class="payment">
                        <div class="che__header" role="tab" id="headingTwo">
                            <a class="collapsed checkout__title" data-toggle="collapse" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                <span>Cheque Payment</span>
                            </a>
                        </div>
                        <div id="collapseTwo" class="collapse" role="tabpanel" aria-labelledby="headingTwo" data-parent="#accordion">
                            <div class="payment-body">Please send your cheque to Store Name, Store Street, Store Town, Store State / County, Store Postcode.</div>
                        </div>
                    </div>
                    <div class="payment">
                        <div class="che__header" role="tab" id="headingThree">
                            <a class="collapsed checkout__title" data-toggle="collapse" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                <span>Cash on Delivery</span>
                            </a>
                        </div>
                        <div id="collapseThree" class="collapse" role="tabpanel" aria-labelledby="headingThree" data-parent="#accordion">
                            <div class="payment-body">Pay with cash upon delivery.</div>
                        </div>
                    </div>
                    <div class="payment">
                        <div class="che__header" role="tab" id="headingFour">
                            <a class="collapsed checkout__title" data-toggle="collapse" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                <span>PayPal <img src="images/icons/payment.png" alt="payment images"> </span>
                            </a>
                        </div>
                        <div id="collapseFour" class="collapse" role="tabpanel" aria-labelledby="headingFour" data-parent="#accordion">
                            <div class="payment-body">Pay with cash upon delivery.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Popup -->
        <div id="paymentModal" class="modal" style="align-items: center; justify-content: center; background-color: rgba(0, 0, 0, 0.8);">
            <div class="modal-content" style="width: 90%; padding: 30px 30px; height: 80%; overflow-y: scroll;">
                <h2 style="text-align: center;">XÁC NHẬN THANH TOÁN</h2>
                <label>Tên:</label>
                <input type="text" id="name" style="width: 100%; padding: 10px; font-size: 16px; margin-bottom: 10px;" value="<?php echo $_SESSION['firstname'] . " " . $_SESSION['lastname']; ?>"><br>
                <label>Địa chỉ:</label>
                <input type="text" id="address" style="width: 100%; padding: 10px; font-size: 16px; margin-bottom: 10px;" value="<?php echo $_SESSION['address'] ?>"><br>
                <label>Số điện thoại:</label>
                <input type="text" id="phone" style="width: 100%; padding: 10px; font-size: 16px; margin-bottom: 10px;" value="<?php echo $_SESSION['phone_number']; ?>"><br>
                <table>
                    <thead>
                        <tr>
                            <th class="product-name"><span class="nobr">Tên sản phẩm</span></th>
                            <th class="product-name"><span class="nobr">Size</span></th>
                            <th class="product-price"><span class="nobr"> Giá </span></th>
                            <th class="product-price"><span class="nobr"> Số lượng </span></th>
                            <th class="product-name"><span class="nobr">Topping</span></th>
                            <th class="product-price"><span class="nobr"> Tổng </span></th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Danh sách sản phẩm -->
                    </tbody>
                </table>

                <div style="display: flex; flex-direction: column; align-items: flex-end; width: 100%; padding-top: 20px;">
                    <div class="wn__order__box" id="box_package" style="overflow: hidden; width: 50%; padding-top: 20px; background-color: transparent;">
                        <ul class="order__total" style="padding: 22px 0px 0px 0px;">
                            <li>Tổng cộng:</li>
                            <li id="total"></li>
                        </ul>
                        <ul class="order__total" style="padding: 22px 0px 0px 0px;">
                            <li>Giảm giá:</li>
                            <li id="discounting"></li>
                        </ul>
                        <ul class="order__total" style="padding: 22px 0px 0px 0px; ">
                            <li>Tổng đơn hàng:</li>
                            <li id="final_total"></li>
                        </ul>
                    </div>

                    <div style="display: flex; width: 50%; padding-top: 20px;">
                        <button onclick="confirmPayment()" class="btn btn-success" style="width: 100%; margin-right: 10px;">Xác nhận</button>
                        <button onclick="closeModal()" class="btn btn-secondary" id="cancelBtn" style="width: 100%;">Hủy</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Modal Popup -->
    </div>
</div>
<!-- cart-main-area end -->
<?php
// session_destroy();
// echo "<pre>";
// print_r($_SESSION['cart']);
?>