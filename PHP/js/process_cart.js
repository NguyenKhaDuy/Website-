// Hàm để đóng modal
function closeModal() {
  document.getElementById("paymentModal").style.display = "none";
}

// Đóng modal khi người dùng nhấp vào nút Hủy
document.getElementById("cancelBtn").addEventListener("click", closeModal);

// Đóng modal khi người dùng nhấn vào khu vực bên ngoài modal-content
window.onclick = function (event) {
  var modal = document.getElementById("paymentModal");
  if (event.target === modal) {
    closeModal();
  }
};

function update_cart(id, info) {
  $.ajax({
    type: "POST",
    url: "action/update_cart.php",
    data: { id: id, qty: info.value },
  }).done(function (response) {
    var data = JSON.parse(response);

    $("#total" + id).text(
      number_format(
        parseInt($("#price" + id).val()) * parseInt(info.value),
        0,
        ""
      ) + " VND"
    );

    updateModalCartInfo(data.total, data.discounting);
    $.ajax({
      type: "GET",
      url: "action/updateBoxPackage.php",
      success: function (boxPackageData) {
        console.log("Dữ liệu box_package nhận được:", boxPackageData);
        console.log("sdsdsdsdsd");
        if (boxPackageData) {
          $("#box_package").html(boxPackageData);
        } else {
          console.log("Dữ liệu box_package không hợp lệ.");
        }
      },
      error: function () {
        console.log("Có lỗi xảy ra khi cập nhật box_package.");
      },
    });
  });
}

function updateModalCartInfo(total, discounting) {
  console.log(total + " " + discounting);
}

function updateModalProducts(products) {
  var productTable = $("#paymentModal table tbody");
  productTable.empty();

  products.forEach(function (product) {
    // Start building the row HTML
    var row =
      "<tr>" +
      "<td>" +
      product.title +
      "</td>" +
      "<td>" +
      product.size.size +
      "</td>" +
      "<td>" +
      number_format(product.price) +
      " VND</td>" +
      "<td>" +
      product.qty +
      "</td>";

    // Add all the toppings into one <td> in a single column
    var toppingsHtml = product.toppings
      .map(function (topping) {
        return topping.name;
      })
      .join("<br>"); // Join toppings names with a comma and space

    row += "<td>" + toppingsHtml + "</td>"; // Add all toppings in one cell

    // Add the total
    row += "<td>" + number_format(product.total) + " VND</td>" + "</tr>";

    // Append the row to the table
    productTable.append(row);
  });
}

// Hàm để xác nhận thanh toán
function confirmPayment() {
  var name = document.getElementById("name").value.trim();
  var phone = document.getElementById("phone").value.trim();
  var address = document.getElementById("address").value.trim();

  if (!name || !phone || !address) {
    alert("Vui lòng điền đầy đủ thông tin.");
    return;
  }

  // Fetch cart info first
  $.ajax({
    type: "GET",
    url: "action/get_cart_info.php",
    success: function (response) {
      var data = JSON.parse(response); // Parse the cart info

      console.log(data);

      // Proceed with payment only after cart info is fetched
      $.ajax({
        type: "POST",
        url: "action/buy.php",
        data: {
          name: name,
          phone: phone,
          address: address,
          products: JSON.stringify(data.products), // Send products as JSON
        },
      })
        .done(function (data) {
          if (data === "1") {
            alert("Mua thành công");
            window.location.assign("?page=checkout");
          } else {
            alert("Đã có lỗi xảy ra trong quá trình thanh toán.");
          }
          closeModal();
        })
        .fail(function () {
          alert("Có lỗi xảy ra khi thực hiện thanh toán.");
        });
    },
    error: function () {
      alert("Không thể lấy thông tin giỏ hàng.");
    },
  });
}

function updateModalCart() {
  $.ajax({
    type: "GET",
    url: "action/updateModalCart.php",
  }).done(function (data) {
    $("#cart_content").html(data);
  });
  $.ajax({
    type: "GET",
    url: "action/getQuantityCart.php",
  }).done(function (data) {
    console.log(data);
    $("#qty").text(data);
  });
}

function add_to_cart(id) {
  $.ajax({
    type: "POST",
    url: "action/add_to_cart.php",
    data: {
      id: id,
    },
  })
    .then(function () {
      console.log("updating cart");
      updateModalCart();
    })
    .done(function () {
      console.log("add thanh cong");
      callSnackbar("Thêm vào giỏ hàng thành công", 1);
    });
}
function delete_cart(cartKey) {
  $.ajax({
    type: "POST",
    url: "action/delete_cart.php",
    data: { cartKey: cartKey },
  }).done(function (data) {
    // Cập nhật box package
    $.ajax({
      type: "GET",
      url: "action/updateBoxPackage.php",
    }).done(function (data) {
      $("#box_package").html(data);
    });

    // Ẩn sản phẩm đã xóa
    if (document.getElementById("tr" + cartKey)) {
      document.getElementById("tr" + cartKey).remove(); // Thay đổi từ hide sang remove
    }

    // Kiểm tra nếu không còn sản phẩm nào
    if ($(".wishlist-table tbody tr").length === 0) {
      $(".wishlist-table").html(
        '<div class="alert alert-success" role="alert" style="text-align:center;font-size:1.2em">Chưa có sản phẩm trong giỏ hàng</div>'
      );
    }

    updateModalCart();
  });
}

function number_format(number, decimals, dec_point, thousands_sep) {
  // http://kevin.vanzonneveld.net
  // + original by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
  // + improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  // + bugfix by: Michael White (http://crestidg.com)
  // + bugfix by: Benjamin Lupton
  // + bugfix by: Allan Jensen (http://www.winternet.no)
  // + revised by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
  // * example 1: number_format(1234.5678, 2, '.', '');
  // * returns 1: 1234.57

  var n = number,
    c = isNaN((decimals = Math.abs(decimals))) ? 2 : decimals;
  var d = dec_point == undefined ? "," : dec_point;
  var t = thousands_sep == undefined ? "." : thousands_sep,
    s = n < 0 ? "-" : "";
  var i = parseInt((n = Math.abs(+n || 0).toFixed(c))) + "",
    j = (j = i.length) > 3 ? j % 3 : 0;

  return (
    s +
    (j ? i.substr(0, j) + t : "") +
    i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) +
    (c
      ? d +
        Math.abs(n - i)
          .toFixed(c)
          .slice(2)
      : "")
  );
}
function callSnackbar(s, color) {
  // Get the snackbar DIV
  var x = document.getElementById("snackbar");

  // Add the "show" class to DIV
  x.innerHTML = s;
  x.className = "show";
  if (color === 1) x.style.backgroundColor = "#28a745";

  // After 3 seconds, remove the show class from DIV
  setTimeout(function () {
    x.className = x.className.replace("show", "");
  }, 1000);
}
