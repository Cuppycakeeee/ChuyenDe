<?php
// Bao gồm file cấu hình và file kiểm tra đăng nhập
include("../config.php"); 
include("../home/logIn_required.php"); 

// Kiểm tra xem request có phải là POST không
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ request
    $productId = $_POST['productId'];
    $newQuantity = $_POST['quantity'];

    // Kiểm tra số lượng mới có hợp lệ không
    if ($newQuantity <= 0) {
        echo json_encode(array("status" => "error", "message" => "Số lượng phải lớn hơn 0."));
        exit();
    }

    // Cập nhật số lượng trong bảng giohang sử dụng prepared statements để bảo mật
    $updateQuery = "UPDATE giohang SET SoLuong = ? WHERE MaSanPham = ? AND MaKhachHang = ?";
    $updateStmt = mysqli_prepare($conn, $updateQuery);

    if ($updateStmt) {
        mysqli_stmt_bind_param($updateStmt, "iss", $newQuantity, $productId, $_SESSION['MaKhachHang']);
        if (mysqli_stmt_execute($updateStmt)) {
            // Tính toán lại tổng thành tiền và trả về trong phản hồi JSON
            $newSubtotal = calculateSubtotal($productId, $newQuantity); // Giả sử hàm này tính toán tổng thành tiền mới
            echo json_encode(array("status" => "success", "message" => "Cập nhật số lượng thành công.", "newSubtotal" => $newSubtotal));
        } else {
            echo json_encode(array("status" => "error", "message" => "Có lỗi xảy ra khi cập nhật số lượng."));
        }
        mysqli_stmt_close($updateStmt);
    } else {
        echo json_encode(array("status" => "error", "message" => "Có lỗi xảy ra khi chuẩn bị truy vấn."));
    }
} else {
    // Trả về dữ liệu JSON nếu request không phải là POST
    echo json_encode(array("status" => "error", "message" => "Phương thức không hợp lệ."));
}

// Hàm tính toán tổng thành tiền mới cho sản phẩm
// Hàm tính toán tổng thành tiền mới cho sản phẩm
function calculateSubtotal($productId, $newQuantity) {
    // Bao gồm file cấu hình
    include("../config.php");

    // Truy vấn SQL để lấy giá sản phẩm từ cơ sở dữ liệu
    $query = "SELECT GiaBan FROM sanpham WHERE MaSanPham = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $productId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $productPrice);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    // Tính toán tổng thành tiền mới
    $newSubtotal = $productPrice * $newQuantity;
    $formattedSubtotal = number_format($newSubtotal, 0, '.', ',') . ' VND';
    // Trả về giá trị tổng thành tiền mới
    return $formattedSubtotal;
}
?>
