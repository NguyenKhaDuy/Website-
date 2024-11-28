// Hàm dùng để check người dùng đăng nhập
function checklogin() {
  //Khi click vào nút đăng nhập trong page account.php thì hà, checklogin sẽ được gọi
  /*
    Đây là một yêu cầu Ajax sử dụng thư viện jQuery. 
    Bằng cách này, hàm sẽ gửi một yêu cầu POST đến địa chỉ URL "action/checklogin.php" 
    và gửi dữ liệu từ form có id là form_login bằng cách sử dụng phương thức serialize()

    Khi thực hiện đoạn code checklogin.php thành công thì data trả về 1 hoặc 0
    nếu thành công sẽ được chuyển đến trang homepage ngược lại thì sẽ hiện ra alert là "Tài khoản hoặc mật khẩu không chính xác"
  */
  $.ajax({
    type: "POST",
    url: "action/checklogin.php",
    data: $("#form_login").serialize(),
  }).done(function (data) {
    // console.log(data);
    if (data == 1) {
      window.location.assign("?page=homepage");
    } else {
      alert("Tài khoản hoặc mật khẩu không chính xác");
    }
  });
}



//Hàm để đăng xuất tài khoản người dùng
function sign_out() {
  if (confirm("Bạn có chắc chắn muốn thoát ?"))
    $.ajax({
      type: "GET",
      url: "action/sign_out.php",
    }).done(function () {
      window.location.assign("?page=homepage");
    });
}
