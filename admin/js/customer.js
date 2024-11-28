//Hàm xem chi tiết về thông tin người dùng
function moreUser(id) {
  $.ajax({
    type: "GET",
    url: "action/getMoreUser.php",
    data: { id: id }
  }).done(function(data) {
    $("#formMoreUser").html(data);
  });
}

