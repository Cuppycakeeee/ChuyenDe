<?php
include("../home/logIn_required.php");
include("../config.php");
if (!isset($_SESSION['MaKhachHang'])) {
    header("Location: ../authentication/dangnhap.php");
    exit();
}
$response = array();
$response['success'] = false;
$masp = $_POST['MaSanPham'];
$soluong = $_POST['SoLuong'];

$result = mysqli_query($conn, "SELECT count(SoLuong) as SLGH FROM giohang WHERE MaSanPham = '$masp' AND MaKhachHang = '{$_SESSION['MaKhachHang']}'");
$row = mysqli_fetch_assoc($result);
$slgh = $row['SLGH'];

if ($slgh != 0) {
    // Nếu sản phẩm đã tồn tại, cập nhật số lượng
    $updateQuery = "UPDATE giohang SET SoLuong = SoLuong + $soluong WHERE MaSanPham = '$masp' AND MaKhachHang = '{$_SESSION['MaKhachHang']}'";
    mysqli_query($conn, $updateQuery);
    $response['success'] = true;
} else {
    // Nếu sản phẩm chưa tồn tại, tạo mới và thêm vào giỏ hàng
    $dongiaResult = mysqli_query($conn, "SELECT GiaBan FROM sanpham WHERE MaSanPham = '$masp'");
    $dongiaRow = mysqli_fetch_assoc($dongiaResult);
    $dongia = $dongiaRow['GiaBan'];

    $insertQuery = "INSERT INTO giohang (MaSanPham, SoLuong, GiaBan, MaKhachHang) VALUES ('$masp', $soluong, $dongia, '{$_SESSION['MaKhachHang']}')";
    mysqli_query($conn, $insertQuery);

    // Tăng giá trị của SLGH trong session
    $_SESSION['SLGH'] += 1;
    $response['success'] = true;
}

// Trả về kết quả thành công hoặc thông tin khác cần thiết (nếu cần)

$response['slgh'] = $_SESSION['SLGH'];
echo json_encode($response, JSON_NUMERIC_CHECK);
?>