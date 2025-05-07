<?php 
include("../config.php");

if (isset($_POST['add'])) {
    // Lấy dữ liệu từ form
    $name = $_POST['name'];
    $gioitinh = $_POST['gioitinh'];
    $ngaysinh = $_POST['ngaysinh'];
    $diachi = $_POST['diachi'];
    $sodienthoai = $_POST['sodienthoai'];
    $email = $_POST['email'];
    $pass = $_POST['pass'];

    // Mã hóa mật khẩu trước khi lưu vào cơ sở dữ liệu
    $pass_hash = password_hash($pass, PASSWORD_DEFAULT);

    // Thực hiện truy vấn SQL để chèn dữ liệu vào cơ sở dữ liệu
    $query = "INSERT INTO taikhoankhachhang (TenKhachHang, GioiTinh, NgaySinh, DiaChi, SoDienThoai, Email, MatKhau) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssssss", $name, $gioitinh, $ngaysinh, $diachi, $sodienthoai, $email, $pass_hash);

    // Thực thi truy vấn
    if ($stmt->execute()) {
        $_SESSION['response'] = "Thêm Dữ Liệu Thành Công!";
        $_SESSION['res_type'] = "success";
    } else {
        $_SESSION['response'] = "Thêm Dữ Liệu Thất Bại!";
        $_SESSION['res_type'] = "danger";
    }

    // Chuyển hướng người dùng về trang đăng ký sau khi thêm dữ liệu
    header('location: ../authentication/dangnhap.php');
}
?>
