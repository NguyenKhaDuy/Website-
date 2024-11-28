function checknewaccount() {
  let lastname = document.form.elements.lastname;
  let firstname = document.form.elements.firstname;
  let email = document.form.elements.email;
  let phone_number = document.form.elements.phone_number;
  let username = document.form.elements.username;
  let password = document.form.elements.password;
  let pre_password = document.form.elements.pre_password;
  let gender = document.form.elements.gender;
  let date = document.form.elements.date;
  let address = document.form.address;

  //Kiểm tra xem checked radio là nam hay nữ
  let selectedGender;
  for (let i = 0; i < gender.length; i++) {
    if (gender[i].checked) {
      selectedGender = gender[i].value;
      break;
    }
  }

  var sex;
  //Kiểm tra giới tính và hiển thị thông báo tương ứng
  if (selectedGender === undefined) {
    alert("Vui lòng chọn giới tính");
  } else if (selectedGender === "1") {
    // Nếu là Nam
    sex = 1;
  } else if (selectedGender === "0") {
    // Nếu là Nữ
    sex = 0;
  }

  //Kiểm tra lỗi khi đăng kí tài khoản

  /*
    Nếu check không có lỗi thì sẽ thực hiện gửi dữ liêu data qua trang code trong action/checknewaccount.php
    Kiểm tra tải khoản đã tồn tại hoặc email đã tồn tại
    Khi đăng kí thành công sẽ chuyển về trang homepage
  */
  if (lastname.value == "") {
    alert("Mời nhập lại họ");
    lastname.focus();
    lastname.style.backgroundColor = "#ffc107";
  } else if (firstname.value == "") {
    lastname.style.backgroundColor = "#fff";
    alert("Mời nhập tên");
    firstname.focus();
    firstname.style.backgroundColor = "#ffc107";
  } else if (email.value == "") {
    firstname.style.backgroundColor = "#fff";
    alert("Mời nhập email");
    email.focus();
    email.style.backgroundColor = "#ffc107";
  } else if (phone_number.value == "") {
    email.style.backgroundColor = "#fff";
    alert("Mời nhập số điện thoại");
    phone_number.focus();
    phone_number.style.backgroundColor = "#ffc107";
  } else if (username.value == "") {
    phone_number.style.backgroundColor = "#fff";
    alert("Mời nhập tên tài khoản");
    username.focus();
    username.style.backgroundColor = "#ffc107";
  } else if (password.value == "") {
    username.style.backgroundColor = "#fff";
    alert("Mời nhập password");
    password.focus();
    password.style.backgroundColor = "#ffc107";
  } else if (pre_password.value == "") {
    password.style.backgroundColor = "#fff";
    alert("Mời nhập lại password");
    pre_password.focus();
    pre_password.style.backgroundColor = "#ffc107";
  } else if (password.value != pre_password.value) {
    // document.getElementById("jump").scrollIntoView();
    // $("#alert").html(
    //   '<div id="alert" class="alert alert-danger" role="alert">2 Mật khẩu không trùng khớp</div>'
    // );
    pre_password.style.backgroundColor = "#fff";
    alert("2 Mật khẩu không trùng khớp");
    password.style.backgroundColor = "#ffc107";
  } else if (date.value == "") {
    password.style.backgroundColor = "#fff";
    date.focus();
  } else
    $.ajax({
      type: "POST",
      url: "action/checknewaccount.php",
      data: {
        username: username.value,
        email: email.value,
        password: password.value,
        firstname: firstname.value,
        lastname: lastname.value,
        phone_number: phone_number.value,
        gender: sex, // Thêm giới tính vào dữ liệu gửi đi
        date: date.value,
        address: address.value,
      },
    }).done(function (data) {
      if (data.indexOf("username") != -1) {
        document.getElementById("jump").scrollIntoView();
        $("#alert").html(
          '<div id="alert" class="alert alert-danger" role="alert">Tên tài khoản đã có người sử dụng</div>'
        );
      } else if (data.indexOf("email") != -1) {
        document.getElementById("jump").scrollIntoView();
        $("#alert").html(
          '<div id="alert" class="alert alert-danger" role="alert">Email đã có người sử dụng</div>'
        );
      } else {
        window.location.assign("?page=homepage");
        // console.log(data);
      }
    });
}
