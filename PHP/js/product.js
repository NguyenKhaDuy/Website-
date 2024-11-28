//Thêm sản phẩm vào giỏ hàng
function addProductToCart(id) {
    // Kiểm tra số lượng
    let quantity = document.getElementById("quantity").value;
    if (!quantity || quantity < 1) {
        alert("Vui lòng chọn số lượng hợp lệ");
        return;
    }

    // Kiểm tra size
    let sizeElement = document.querySelector('input[name="size"]:checked');
    if (!sizeElement) {
        alert("Vui lòng chọn size");
        return;
    }
    let idsize = sizeElement.value;

    // Lấy thông tin topping
    let toppings = [];
    let toppingNames = [];
    // Thêm mảng để lưu tên topping
    document.querySelectorAll('input[name="topping[]"]:checked').forEach(cb => {
        toppings.push(cb.value);
        toppingNames.push(cb.getAttribute('data-name')); // Giả sử mỗi checkbox có thuộc tính data-name
    });

    

    $.ajax({
        type: "GET",
        url: "action/addProductTocart.php",
        data: { 
            id, 
            quantity,
            idsize,
            toppings: JSON.stringify(toppings),
            toppingNames: JSON.stringify(toppingNames) // Gửi thêm tên của topping
        }
    }).then(function(data) {
        if (data == 0) {
            alert("Thêm không thành công do vượt số lượng tồn kho!!!");
        } else {
            updateModalCart();
            alert("Thêm vào giỏ hàng thành công");
        }
    }).catch(function(error) {
        alert("Có lỗi xảy ra khi thêm vào giỏ hàng");
        console.error(error);
    });
}
$(document).ready(function() {
  var idProduct = new URLSearchParams(window.location.search).get('id'); // Lấy id sản phẩm từ URL

  // Kiểm tra nếu người dùng đã đăng nhập khi tải trang
  $.ajax({
      url: 'action/save_evaluate.php',
      type: 'POST',
      data: {
          action: 'checkLogin', // Gửi action kiểm tra đăng nhập
      },
      success: function(response) {
          if (response === "Vui lòng đăng nhập để đánh giá sản phẩm.") {
              // Người dùng chưa đăng nhập, không thể đánh giá
              $('#ratingSection').hide();  // Ẩn phần đánh giá
          } else {
              // Người dùng đã đăng nhập, có thể đánh giá
              $('#ratingSection').show();
          }
      },
      error: function(xhr, status, error) {
          alert('Lỗi khi kiểm tra đăng nhập: ' + error);
      }
  });

  // Gửi yêu cầu AJAX để lấy đánh giá của người dùng
  $.ajax({
      url: 'action/save_evaluate.php', // Địa chỉ file PHP xử lý
      type: 'POST',
      data: {
          action: 'getEvaluation', // Gửi action để lấy đánh giá
          id: idProduct // Gửi id sản phẩm
      },
      success: function(response) {
          var data = JSON.parse(response); // Chuyển đổi dữ liệu JSON trả về
          var userEvaluate = data.userEvaluate;

          // Nếu người dùng đã đánh giá, tô màu các sao
          if (userEvaluate !== null) {
              $('.star').each(function() {
                  var starValue = $(this).data('value');
                  if (starValue <= userEvaluate) {
                      $(this).addClass('on'); // Tô màu sao đã chọn
                  } else {
                      $(this).removeClass('on'); // Bỏ màu sao chưa chọn
                  }
              });
          }
      },
      error: function(xhr, status, error) {
          alert('Lỗi khi tải đánh giá: ' + error);
      }
  });

  // Xử lý khi người dùng nhấp vào sao để đánh giá
  $('.star').click(function() {
      var ratingValue = $(this).data('value'); // Lấy số sao người dùng chọn

      // Đổi màu sao đã chọn và các sao trước đó
      $('.star').each(function() {
          var starValue = $(this).data('value');
          if (starValue <= ratingValue) {
              $(this).addClass('on'); // Tô màu sao đã chọn
          } else {
              $(this).removeClass('on'); // Bỏ màu sao chưa chọn
          }
      });

      // Gửi đánh giá lên server
      $.ajax({
          url: 'action/save_evaluate.php', // Địa chỉ file PHP xử lý
          type: 'POST',
          data: {
              action: 'saveEvaluate', // Gửi action lưu đánh giá
              id: idProduct, // Gửi id sản phẩm
              evaluate: ratingValue // Gửi số sao đã chọn
          },
          success: function(response) {
              alert(response); // Hiển thị phản hồi từ server
          },
          error: function(xhr, status, error) {
              alert('Lỗi khi gửi đánh giá: ' + error);
          }
      });
  });
});
function updatePrice() {
    // Lấy giá gốc từ input hidden
    let basePrice = parseFloat(document.getElementById('base-price').value);
    
    // Tính hệ số nhân theo size
    let size = document.querySelector('input[name="size"]:checked').value;
    let multiplier = 1;
    switch(size) {
        case 'M':
            multiplier = 1.2;
            break;
        case 'L':
            multiplier = 1.4;
            break;
        default:
            multiplier = 1;
    }
    
    // Tính giá sau khi nhân với hệ số size
    let newPrice = basePrice * multiplier;
    
    // Cộng thêm giá của các topping được chọn
    const toppingCheckboxes = document.querySelectorAll('input[name="topping[]"]:checked');
    toppingCheckboxes.forEach(checkbox => {
        newPrice += parseFloat(checkbox.dataset.price);
    });
    
    // Làm tròn và hiển thị giá mới
    newPrice = Math.round(newPrice);
    document.getElementById('display-price').innerHTML = 
        new Intl.NumberFormat('vi-VN').format(newPrice) + ' VNĐ';
}












