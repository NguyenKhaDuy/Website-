//Hàm để lọc sản phẩm khi nhập vào trong ô textbox cụ thể sử dụng onkeyup
function submit_filter() {
  document.getElementById("numpage").value = "0";
  $.ajax({
    type: "POST",
    url: "action/searchGrid.php",
    data: $("#filter_price").serialize()
  }).done(function(data) {
    $("#content_grid").html(data);
  });

  $.ajax({
    type: "POST",
    url: "action/searchList.php",
    data: $("#filter_price").serialize()
  }).done(function(data) {
    $("#content_list").html(data);
  });

  $.ajax({
    type: "POST",
    url: "action/getPaginationSearch.php",
    data: $("#filter_price").serialize()
  }).done(function(data) {
    $("#pagination").html(data);
  });
}
