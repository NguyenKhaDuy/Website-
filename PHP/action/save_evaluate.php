<?php
session_start();

// Kết nối cơ sở dữ liệu
require "../database.php";

// Kiểm tra xem có action nào không
if (isset($_POST['action'])) {

    // Kiểm tra action từ AJAX để lấy đánh giá của người dùng
    if ($_POST['action'] == 'getEvaluation') {
        // Kiểm tra nếu người dùng đã đăng nhập
        if (!isset($_SESSION['idUser'])) {
            echo json_encode(['userEvaluate' => null]); // Trả về null nếu chưa đăng nhập
            exit;
        }

        // Lấy dữ liệu từ POST
        $idProduct = $_POST['id'];

        // Kiểm tra sản phẩm có tồn tại không
        $sqlCheckProduct = "SELECT id FROM products WHERE id = ?";
        $stmtCheckProduct = $conn->prepare($sqlCheckProduct);
        $stmtCheckProduct->bind_param("i", $idProduct);
        $stmtCheckProduct->execute();
        $resultCheckProduct = $stmtCheckProduct->get_result();

        if ($resultCheckProduct->num_rows == 0) {
            echo json_encode(['userEvaluate' => null]); // Nếu không có sản phẩm, trả về null
            exit;
        }

        // Kiểm tra xem người dùng đã đánh giá chưa
        $sqlCheckEvaluation = "SELECT evaluate FROM products_evaluate WHERE id_user = ? AND id_product = ?";
        $stmtCheckEvaluation = $conn->prepare($sqlCheckEvaluation);
        $stmtCheckEvaluation->bind_param("ii", $_SESSION['idUser'], $idProduct);
        $stmtCheckEvaluation->execute();
        $resultCheckEvaluation = $stmtCheckEvaluation->get_result();

        if ($resultCheckEvaluation->num_rows > 0) {
            // Lấy số sao đã đánh giá của người dùng
            $row = $resultCheckEvaluation->fetch_assoc();
            $userEvaluate = $row['evaluate'];
            echo json_encode(['userEvaluate' => $userEvaluate]); // Trả về số sao đã đánh giá
        } else {
            echo json_encode(['userEvaluate' => null]); // Nếu chưa đánh giá, trả về null
        }

        $stmtCheckEvaluation->close();
        exit;
    }

    // Kiểm tra action từ AJAX để lưu hoặc cập nhật đánh giá
    if ($_POST['action'] == 'saveEvaluate') {
        if (!isset($_SESSION['idUser'])) {
            echo "Vui lòng đăng nhập để đánh giá sản phẩm.";
            exit;
        }

        // Lấy dữ liệu từ POST
        $idProduct = $_POST['id'];
        $evaluate = $_POST['evaluate'];

        // Kiểm tra sản phẩm có tồn tại không
        $sqlCheckProduct = "SELECT id FROM products WHERE id = ?";
        $stmtCheckProduct = $conn->prepare($sqlCheckProduct);
        $stmtCheckProduct->bind_param("i", $idProduct);
        $stmtCheckProduct->execute();
        $resultCheckProduct = $stmtCheckProduct->get_result();

        if ($resultCheckProduct->num_rows == 0) {
            echo "Sản phẩm không tồn tại.";
            exit;
        }

        // Kiểm tra xem người dùng đã đánh giá chưa
        $sqlCheckEvaluation = "SELECT id FROM products_evaluate WHERE id_user = ? AND id_product = ?";
        $stmtCheckEvaluation = $conn->prepare($sqlCheckEvaluation);
        $stmtCheckEvaluation->bind_param("ii", $_SESSION['idUser'], $idProduct);
        $stmtCheckEvaluation->execute();
        $resultCheckEvaluation = $stmtCheckEvaluation->get_result();

        if ($resultCheckEvaluation->num_rows > 0) {
            // Cập nhật đánh giá
            $sqlUpdate = "UPDATE products_evaluate SET evaluate = ? WHERE id_user = ? AND id_product = ?";
            $stmtUpdate = $conn->prepare($sqlUpdate);
            $stmtUpdate->bind_param("iii", $evaluate, $_SESSION['idUser'], $idProduct);

            if ($stmtUpdate->execute()) {
                echo "Đánh giá của bạn đã được cập nhật thành công!";
            } else {
                echo "Có lỗi khi cập nhật đánh giá.";
            }

            $stmtUpdate->close();
        } else {
            // Nếu chưa có đánh giá, thêm mới
            $sqlInsert = "INSERT INTO products_evaluate (id_user, id_product, evaluate) VALUES (?, ?, ?)";
            $stmtInsert = $conn->prepare($sqlInsert);
            $stmtInsert->bind_param("iii", $_SESSION['idUser'], $idProduct, $evaluate);

            if ($stmtInsert->execute()) {
                echo "Đánh giá đã được lưu thành công!";
            } else {
                echo "Có lỗi khi lưu đánh giá.";
            }

            $stmtInsert->close();
        }

        $stmtCheckEvaluation->close();
        exit;
    }
}

$conn->close();
