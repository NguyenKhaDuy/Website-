//Hàm thêm danh mục mới vào cơ sở dữ liệu
function addNewCase() {
  // alert(123);
  $("#formAddNewCase").ajaxSubmit({
    type: "POST",
    url: "action/addNewCase.php",
    success: function (data) {
      //xem lại vị trí trang hiện tại
      var x = document.querySelectorAll("#pagination li.active")[0];
      getPaginationCase(parseInt(x.textContent));
      // bỏ dữ liệu vào trong bảng mới thôi
      if (document.getElementsByTagName("tr").length != 8) {
        $.ajax({
          type: "GET",
          url: "action/updateNewCase.php",
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
  $("#casebook").val("");
  $("#name").val("");
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

//Hàm chuyển trang danh mục
function getPaginationCase(cur_numpage) {
  $.ajax({
    type: "GET",
    url: "action/getPaginationCase.php",
    data: { cur_numpage: cur_numpage },
  }).done(function (data) {
    $("#pagination").html(data);
    //console.log(data);
  });
}

//hàm hiện sản phảm ra table
function getCase(numpage, i) {
  $.ajax({
    type: "POST",
    url: "action/getCase.php",
    data: { num: numpage },
  }).done(function (data) {
    $("#table_case").html(data);
  });
  document.querySelectorAll("#pagination li.active")[0].className = "page-item";
  document.querySelectorAll("#pagination li")[i - 1].className =
    "page-item active";
}

//Hàm lấy thông tin danh mục hiện lên form
function updateCase(id) {
  $.ajax({
    type: "GET",
    url: "action/updateCase.php",
    data: { id: id },
  }).done(function (data) {
    $("#formUpdateCase").html(data);
  });
  // alert(id);
}

//Hàm cập nhật thông tin danh mục
//nếu action/updateCaseInDatabase.php
// sẽ thực hiện action/getOneRowAfterUpdateCase.php (cập nhật lại thông tin vừa thay đổi lên table)
function updateCaseInDatabase() {
  let id = document.forms.formUpdateCase.id.value;

  $("#formUpdateCase").ajaxSubmit({
    type: "POST",
    url: "action/updateCaseInDatabase.php",
    success: function (data) {
      if (data == 1) {
        $.ajax({
          type: "GET",
          url: "action/getOneRowAfterUpdateCase.php",
          data: {
            id: id,
          },
        }).done(function (data) {
          $("#tr" + id).html(data);
        });
        callSnackbar("Chỉnh sửa thành công", 1);
        $("#updateCase").modal("toggle");
      } else {
        callSnackbar("Chỉnh sửa không thành công", 2);
      }
    },
  });
}

//Hàm xóa danh mục
function deleteCase(id) {
  if (confirm("Bạn có chắc chắn muốn xóa danh mục này không?"))
    $.ajax({
      type: "POST",
      url: "action/deleteCase.php",
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
