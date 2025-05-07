<?php
include "config.php";

mysqli_set_charset($conn, 'utf8mb4');
$id = "";
$tenpb = "";
$id_bp = "";

$update = false;

if (isset($_POST['add'])) {
    $id_pb = $_POST['id'];
    $tenpb = $_POST['tenpb'];
    $id_bp = $_POST['id_bp'];

    $query = "INSERT INTO phongban (MaPhongBan, TenPhongBan, MaBoPhan ) VALUES ( ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sss", $id, $tenpb, $id_bp);

    $stmt->execute();
    header('location: phongban.php');
    $_SESSION['response'] = "Thêm Dữ Liệu Thành Công!";
    $_SESSION['res_type'] = "success";
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $query = "DELETE FROM phongban WHERE MaPhongBan=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $id);
    $stmt->execute();

    header('location: phongban.php');
    $_SESSION['response'] = "Xoá Dữ Liệu Thành Công!";
    $_SESSION['res_type'] = "danger";
}
//thực hiện thay đổi 
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];

    $query = "SELECT * FROM phongban WHERE MaPhongBan=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    $id = $row['MaPhongBan'];
    $tenpb = $row['TenPhongBan'];
    $id_bp = $row['MaBoPhan'];
    $update = true;
}
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $tenpb = $_POST['tenpb'];
    $id_bp = $_POST['id_bp'];

    // Kiểm tra xem dữ liệu mới có khác với dữ liệu cũ không
    $query_check = "SELECT * FROM phongban WHERE MaPhongBan=?";
    $stmt_check = $conn->prepare($query_check);
    $stmt_check->bind_param("s", $id);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();
    $row_check = $result_check->fetch_assoc();

    $id_old = $row_check['id'];
    $tenpb_old = $row_check['tenpb'];;
    $id_bp_old = $row_check['id_bp'];;

    if (
        $id != $id_old || $tenpb != $tenpb_old || $id_bp != $id_bp_old
    ) {
        echo "Dữ liệu được chỉnh sửa mới:<br>";
        echo "ID: " . $id . "<br>";
        echo "Tên Phòng Ban: " . $tenpb . "<br>";
        echo "Mã Bộ phận: " . $id_bp . "<br>";
    }

    // Tiếp tục thực hiện câu truy vấn UPDATE
    $query = "UPDATE phongban SET TenPhongBan=?, MaBoPhan=?  WHERE MaPhongBan=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sss", $tenpb,$id_bp, $id);
    $stmt->execute();

    $_SESSION['response'] = "Cập Nhật Thành Công!";
    $_SESSION['res_type'] = "primary";
    header('location: phongban.php');
}
