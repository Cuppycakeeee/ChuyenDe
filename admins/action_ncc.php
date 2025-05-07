<?php
include "config.php";

mysqli_set_charset($conn, 'utf8mb4');
$id = "";
$tenncc = "";
$email = "";
$addncc = "";
$phonencc = "";

$update = false;

if (isset($_POST['add'])) {
    $id = $_POST['id'];
    $tenncc = $_POST['tenncc'];
    $email = $_POST['email'];
    $addncc = $_POST['addncc'];
    $phonencc = $_POST['phonencc'];

    $query = "INSERT INTO nhacungcap (MaNhaCungCap, TenNhaCungCap, Email, DiaChi, SoDienThoai ) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssss", $id, $tenncc, $email, $addncc, $phonencc);
    $stmt->execute();
    header('location: nhacungcap.php');
    $_SESSION['response'] = "Thêm Dữ Liệu Thành Công!";
    $_SESSION['res_type'] = "success";
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $query = "DELETE FROM nhacungcap WHERE MaNhaCungCap=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $id);
    $stmt->execute();

    header('location: nhacungcap.php');
    $_SESSION['response'] = "Xoá Dữ Liệu Thành Công!";
    $_SESSION['res_type'] = "danger";
}
//thực hiện thay đổi 
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];

    $query = "SELECT * FROM nhacungcap WHERE MaNhaCungCap=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    $id = $row['MaNhaCungCap'];
    $tenncc = $row['TenNhaCungCap'];
    $email = $row['Email'];
    $addncc = $row['DiaChi'];
    $phonencc = $row['SoDienThoai'];

    $update = true;
}
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $tenncc = $_POST['tenncc'];
    $email = $_POST['email'];
    $addncc = $_POST['addncc'];
    $phonencc = $_POST['phonencc'];

    // Kiểm tra xem dữ liệu mới có khác với dữ liệu cũ không
    $query_check = "SELECT * FROM nhacungcap WHERE MaNhaCungCap=?";
    $stmt_check = $conn->prepare($query_check);
    $stmt_check->bind_param("s", $id);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();
    $row_check = $result_check->fetch_assoc();

    $id_old = $row_check['id'];
    $tenncc_old = $row_check['tenncc'];
    $emailncc_old = $row_check['email'];
    $addncc_old = $row_check['addncc'];
    $phonencc_old = $row_check['phonencc'];

    if (
        $id != $id_old || $tenncc != $tenncc_old || $email != $emailncc_old
        || $addncc != $addncc_old || $phonencc != $phonencc_old
    ) {
        echo "Dữ liệu được chỉnh sửa mới:<br>";
        echo "ID: " . $id . "<br>";
        echo "Tên NCC: " . $tenncc . "<br>";
        echo "Email NCC: " . $email . "<br>";
        echo "Địa chỉ NCC: " . $addncc . "<br>";
        echo "SĐT NCC: " . $phonencc . "<br>";
    }

    // Tiếp tục thực hiện câu truy vấn UPDATE
    $query = "UPDATE nhacungcap SET TenNhaCungCap=?, Email=?, DiaChi=?, SoDienThoai=? WHERE MaNhaCungCap=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssss", $tenncc, $email, $addncc, $phonencc, $id);
    $stmt->execute();

    $_SESSION['response'] = "Cập Nhật Thành Công!";
    $_SESSION['res_type'] = "primary";
    header('location: nhacungcap.php');
}


if (isset($_GET['details'])) {
    $id = $_GET['details'];
    $query = "SELECT * FROM nhacungcap WHERE MaNhaCungCap=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    $vid = $row['MaNhaCungCap'];
    $vtenncc = $row['TenNhaCungCap'];
    $vemail = $row['Email'];
    $vaddncc = $row['DiaChi'];
    $phonencc = $row['SoDienThoai'];
}
