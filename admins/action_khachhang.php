<?php
include "config.php";
mysqli_set_charset($conn, 'utf8mb4');


$id="";
$name="";
$gioitinh = "";
$ngaysinh="";
$diachi="";
$sodienthoai="";
$email="";
$pass="";

$update=false;

if (isset($_POST['add'])) {

    $id = $_POST['id'];
    $name = $_POST['name'];
    $gioitinh = $_POST['gioitinh'];
    $ngaysinh = $_POST['ngaysinh'];
    $diachi = $_POST['diachi'];
    $sodienthoai = $_POST['sodienthoai'];
    $email = $_POST['email'];
    $pass = $_POST['pass'];

    // Mã hóa mật khẩu trước khi lưu vào cơ sở dữ liệu
    $pass_hash = password_hash($pass, PASSWORD_DEFAULT);

    $query = "INSERT INTO taikhoankhachhang (MaKhachHang, TenKhachHang, GioiTinh, NgaySinh , DiaChi , SoDienThoai, Email, 
    MatKhau) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssssss", $id, $name, $gioitinh, $ngaysinh, $diachi, $sodienthoai, $email, $pass_hash);
    $stmt->execute();
    $_SESSION['response'] = "Thêm Dữ Liệu Thành Công!";
    $_SESSION['res_type'] = "success";
    header('location: taikhoan_khachhang.php');
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $query = "DELETE FROM taikhoankhachhang WHERE MaKhachHang=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $id);
    $stmt->execute();

    $_SESSION['response'] = "Xoá Dữ Liệu Thành Công!";
    $_SESSION['res_type'] = "danger";
    header('location: taikhoan_khachhang.php');
}

if (isset($_GET['edit'])) {
    $id = $_GET['edit'];

    $query = "SELECT * FROM taikhoankhachhang WHERE MaKhachHang=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    $id = $row['MaKhachHang'];
    $name = $row['TenKhachHang'];
    $gioitinh = $row['GioiTinh'];
    $ngaysinh = $row['NgaySinh'];
    $diachi = $row['DiaChi'];
    $sodienthoai = $row['SoDienThoai'];
    $email = $row['Email'];
    $pass = $row['MatKhau'];

    $update = true;
}

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $gioitinh = $_POST['gioitinh'];
    $ngaysinh = $_POST['ngaysinh'];
    $diachi = $_POST['diachi'];
    $sodienthoai = $_POST['sodienthoai'];
    $email = $_POST['email'];
    $pass = $_POST['pass'];

    // Mã hóa mật khẩu trước khi cập nhật vào cơ sở dữ liệu
    $pass_hash = password_hash($pass, PASSWORD_DEFAULT);

    $query = "UPDATE taikhoankhachhang SET TenKhachHang=?, GioiTinh=?, NgaySinh=?, DiaChi=?, SoDienThoai=?, Email=?, 
    MatKhau=? WHERE MaKhachHang=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssssss", $name, $gioitinh, $ngaysinh, $diachi, $sodienthoai, $email, $pass_hash, $id);
    $stmt->execute();

    $_SESSION['response'] = "Cập Nhật Thành Công!";
    $_SESSION['res_type'] = "primary";
    header('location: taikhoan_khachhang.php');
}
?>
