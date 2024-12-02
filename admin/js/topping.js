function updateTopping(id) {
  $.ajax({
    type: "GET",
    url: "action/updateTopping.php",
    data: { id: id },
  }).done(function (data) {
    $("#formUpdateTopping").html(data);
    console.log(data);
  });
  // alert(id);
}

function updateToppingInDatabase() {
  let id = document.forms.formUpdateTopping.id.value;

  $("#formUpdateTopping").ajaxSubmit({
    type: "POST",
    url: "action/updateToppingInDatabase.php",
    success: function (data) {
      console.log(data);
      if (data == 1) {
        $.ajax({
          type: "GET",
          url: "action/getOneRowAfterUpdateTopping.php",
          data: {
            id: id,
          },
        }).done(function (data) {
          $("#tr" + id).html(data);
        });
        callSnackbar("Chỉnh sửa thành công", 1);
        $("#updateTopping").modal("toggle");
      } else {
        callSnackbar("Chỉnh sửa không thành công", 2);
      }
    },
  });
}

//Hàm xóa
function deleteTopping(id) {
  if (confirm("Bạn có chắc chắn muốn xóa topping này không?"))
    $.ajax({
      type: "POST",
      url: "action/deleteTopping.php",
      data: { id: id },
    }).done(function (data) {
      if (data == 1) {
        callSnackbar("Xóa thành công", 1);
        // document.getElementById("tr" + id).style.display = "none";
        $("#tr" + id).remove();
        if (document.getElementsByTagName("tr").length == 1)
          getPaginationOrders(1);
        else {
          let x = document.querySelectorAll("#pagination li.active")[0];
          getPaginationOrders(parseInt(x.textContent));
        }
      }
      // console.log("123");
    });
}

//Hàm chuyển trang danh mục
function getPaginationTopping(cur_numpage) {
  $.ajax({
    type: "GET",
    url: "action/getPaginationTopping.php",
    data: { cur_numpage: cur_numpage },
  }).done(function (data) {
    $("#pagination").html(data);
    //console.log(data);
  });
}

//hàm hiện sản phảm ra table
function getTopping(numpage, i) {
  $.ajax({
    type: "POST",
    url: "action/getTopping.php",
    data: { num: numpage },
  }).done(function (data) {
    $("#table_case").html(data);
  });
  document.querySelectorAll("#pagination li.active")[0].className = "page-item";
  document.querySelectorAll("#pagination li")[i - 1].className =
    "page-item active";
}

//Hàm thêm topping mới vào cơ sở dữ liệu
function addNewTopping() {
  // alert(123);
  $("#formAddNewTopping").ajaxSubmit({
    type: "POST",
    url: "action/addNewTopping.php",
    success: function (data) {
      //xem lại vị trí trang hiện tại
      var x = document.querySelectorAll("#pagination li.active")[0];
      if (x != undefined) {
        getPaginationTopping(parseInt(x.textContent));
      }

      // bỏ dữ liệu vào trong bảng mới thôi
      if (document.getElementsByTagName("tr").length != 8) {
        $.ajax({
          type: "GET",
          url: "action/updateNewTopping.php",
        }).done(function (data) {
          $("#table_case").append(data);
        });
      }
      if (data == 1) {
        //alert("yes");
        resetForm();
        callSnackbar("Thêm vào thành công", 1);
        document.getElementById("close").click();
      } else {
        //alert("no");
        callSnackbar("Thêm vào không thành công", 2);
      }
    },
  });
}

//Hàm resetform
function resetForm() {
  $("#nametopping").val("");
  $("#pricetopping").val("");
}

//Hàm này được sử dụng để hiển thị một thông báo trên giao diện người dùng
function callSnackbar(s, color) {
  // Get the snackbar DIV
  var x = document.getElementById("snackbar");

  // Add the "show" class to DIV
  x.innerHTML = s;
  x.className = "show";
  if (color === 1) x.style.backgroundColor = "#28a745";
  if (color === 2) x.style.backgroundColor = "#dc3545";

  // After 3 seconds, remove the show class from DIV
  setTimeout(function () {
    x.className = x.className.replace("show", "");
  }, 3000);
}

function updateProductTopping(id) {
  $.ajax({
    type: "GET",
    url: "action/updateProductTopping.php",
    data: { id: id },
  }).done(function (data) {
    $("#formUpdateProductTopping").html(data);
  });
  // alert(id);
}

$(document).ready(function () {
  // Lắng nghe sự kiện change trên tất cả checkbox trong form
  $("#formUpdateProductTopping").on(
    "change",
    "input[type='checkbox']",
    function () {
      const idProduct = document.getElementById("idProductInput").value;
      const idTopping = $(this).val();
      const isChecked = $(this).is(":checked");
      console.log(idProduct + " " + idTopping + " " + isChecked);

      // Log giá trị và trạng thái của checkbox
      // Gửi yêu cầu Ajax
      $.ajax({
        url: "action/changeProductTopping.php", // Đường dẫn đến file xử lý
        type: "POST",
        data: {
          idProduct: idProduct,
          idTopping: idTopping,
          action: isChecked ? "insert" : "delete", // Hành động: insert hoặc delete
        },
      });
    }
  );
});

function updateRowProductTopping() {
  let id = document.forms.formUpdateProductTopping.id.value;
  console.log(document.getElementById("tr" + id));
  $.ajax({
    type: "GET",
    url: "action/getOneRowAfterUpdateProductTopping.php",
    data: { id: id },
  }).done(function (data) {
    $("#tr" + id).html(data);
  });

  $("#updateProductTopping").modal("toggle");
}

function updateProductToppingInDatabase() {
  let id = document.forms.formUpdateProductTopping.id.value;

  $("#formUpdateProductTopping").ajaxSubmit({
    type: "POST",
    url: "action/updateProductToppingInDatabase.php",
    success: function (data) {
      console.log(data);
      if (data == 1) {
        $.ajax({
          type: "GET",
          url: "action/getOneRowAfterUpdateProductTopping.php",
          data: {
            id: id,
          },
        }).done(function (data) {
          $("#tr" + id).html(data);
        });
        callSnackbar("Chỉnh sửa thành công", 1);
      } else {
        callSnackbar("Chỉnh sửa không thành công", 2);
      }
    },
  });
}

//Hàm chuyển trang danh mục
function getPaginationProductTopping(cur_numpage) {
  $.ajax({
    type: "GET",
    url: "action/getPaginationProductTopping.php",
    data: { cur_numpage: cur_numpage },
  }).done(function (data) {
    $("#pagination").html(data);
    console.log(data);
  });
}

function getProductTopping(numpage, i) {
  $.ajax({
    type: "POST",
    url: "action/getProductTopping.php",
    data: { num: numpage },
  }).done(function (data) {
    $("#table_case").html(data);
  });
  document.querySelectorAll("#pagination li.active")[0].className = "page-item";
  document.querySelectorAll("#pagination li")[i - 1].className =
    "page-item active";
}

//Hàm xóa
function deleteProductTopping(id) {
  if (confirm("Bạn có chắc chắn muốn xóa topping này không?"))
    $.ajax({
      type: "POST",
      url: "action/deleteProductTopping.php",
      data: { id: id },
    }).done(function (data) {
      if (data == 1) {
        callSnackbar("Xóa thành công", 1);
        // document.getElementById("tr" + id).style.display = "none";
        $("#tr" + id).remove();
        if (document.getElementsByTagName("tr").length == 1)
          getPaginationOrders(1);
        else {
          let x = document.querySelectorAll("#pagination li.active")[0];
          getPaginationOrders(parseInt(x.textContent));
        }
      }
      // console.log("123");
    });
}

var id = 1;
document.getElementById("select").addEventListener("change", function () {
  var selectedValue = this.value;
  var selectedText = this.options[this.selectedIndex].text;
  id = selectedValue;
  console.log(id);
});

//Hàm thêm topping mới vào cơ sở dữ liệu
function addNewProductTopping() {
  var inputChecks = document.getElementsByClassName("topping");
  var idTopping = [];
  for (var i = 0; i < inputChecks.length; i++) {
    var inputCheck = inputChecks[i];
    if (inputCheck.checked == true) {
      idTopping.push(inputCheck.value);
    }
  }

  // alert(123);
  $("#formAddNewProductTopping").ajaxSubmit({
    type: "POST",
    url: "action/addNewProductTopping.php",
    data: { idTopping: JSON.stringify(idTopping), idproduct: id },
    success: function (data) {
      //xem lại vị trí trang hiện tại
      var x = document.querySelectorAll("#pagination li.active")[0];
      if (x != undefined) {
        getPaginationProductTopping(parseInt(x.textContent));
      }
      // bỏ dữ liệu vào trong bảng mới thôi
      if (document.getElementsByTagName("tr").length != 8) {
        $.ajax({
          type: "GET",
          url: "action/updateNewProductTopping.php",
          data: { idProduct: id },
        }).done(function (data) {
          $("#table_case").append(data);
        });
      }
      if (data == 1) {
        //alert("yes");
        resetForm();
        callSnackbar("Thêm vào thành công", 1);
        document.getElementById("close").click();
      } else {
        //alert("no");
        callSnackbar("Thêm vào không thành công", 2);
      }
    },
  });
}
