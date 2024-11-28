//Hàm xác nhận xử lí đơn hàng
function processOrder(id) {
  if (confirm("Bạn có chắc chắn muốn xử lý đơn hàng"))
    if (confirm("Đơn hàng được xử lí sẽ không thể hủy"))
      $.ajax({
        type: "GET",
        url: "action/processOrder.php",
        data: { id: id },
      }).done(function () {
        $("#tdcheck" + id).html('<input type="checkbox" checked>Processed');
        document.getElementById("tdcheck" + id).className = "process";
        callSnackbar("Đơn hàng đã được xử lý", "1");
      });
}
// function getOrder(numpage, cur_numpage) {
//   $.ajax({
//     type: "GET",
//     url: "action/getOrder.php",
//     data: { numpage: numpage },
//   }).done(function (data) {
//     document.querySelectorAll("#pagination li.active")[0].className =
//       "page-item";
//     document.querySelectorAll("#pagination li")[cur_numpage - 1].className +=
//       " active";
//     $("#table_order").html(data);
//   });
// }

//Hàm lấy đơn hơn hiện lên table
function getOrder(numpage, i) {
  $.ajax({
    type: "POST",
    url: "action/getOrder.php",
    data: { num: numpage },
  }).done(function (data) {
    $("#table_order").html(data);
  });
  document.querySelectorAll("#pagination li.active")[0].className = "page-item";
  document.querySelectorAll("#pagination li")[i - 1].className =
    "page-item active";
}

//Hàm xe thông tin chi tiết về đơn hàng
function moreOrder(id, idUser) {
  console.log(id, idUser);
  $.ajax({
    type: "GET",
    url: "action/getMoreOrder.php",
    data: { id: id, idUser: idUser },
  }).done(function (data) {
    $("#formMoreOrder").html(data);
  });
}

//Hàm reset form
function resetForm() {
  $("#total").val("");
  $("#delivery").val("");
  $("#total_discounting").val("");
}

//Hàm xóa đơn hàng
function deleteOrder(id) {
  if (confirm("Bạn có chắc chắn muốn xóa đơn hàng này không?"))
    $.ajax({
      type: "POST",
      url: "action/deleteOrders.php",
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

//Hàm chuyển trang đơn hàng
function getPaginationOrders(cur_numpage) {
  $.ajax({
    type: "GET",
    url: "action/getPaginationOrders.php",
    data: { cur_numpage: cur_numpage },
  }).done(function (data) {
    $("#pagination").html(data);
    //console.log(data);
  });
}

//Hàm lấy thông tin đơn hàng hiện lên form
function updateOrder(id) {
  $.ajax({
    type: "GET",
    url: "action/updateOrders.php",
    data: { id: id },
  }).done(function (data) {
    $("#formUpdateOrder").html(data);
  });
  // alert("123");
}

//Hàm update thông tin đơn hàng vào csdl
//nếu action/updateOrderInDatabase.php thành công thì
//action/getOneRowAfterUpdateOrder.php sẽ được thực hiện và cập nhật thông tin mới sửa đổi lên table
function updateOrderInDatabase() {
  let id = document.forms.formUpdateOrder.id.value;

  $("#formUpdateOrder").ajaxSubmit({
    type: "POST",
    url: "action/updateOrderInDatabase.php",
    success: function (data) {
      if (data == 1) {
        $.ajax({
          type: "GET",
          url: "action/getOneRowAfterUpdateOrder.php",
          data: {
            id: id,
          },
        }).done(function (data) {
          $("#tr" + id).html(data);
        });
        callSnackbar("Chỉnh sửa thành công", 1);
        $("#updateOrder").modal("toggle");
      } else {
        callSnackbar("Chỉnh sửa không thành công", 2);
      }
    },
  });
}
