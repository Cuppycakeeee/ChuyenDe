<?php
include "config.php";

mysqli_set_charset($conn, 'utf8mb4');
$id = "";
$tenbp = "";

$update = false;

if (isset($_POST['add'])) {
    $id_bp = $_POST['id'];
    $tenbp = $_POST['tenbp'];

    $query = "INSERT INTO bophan (MaBoPhan, TenBoPhan ) VALUES ( ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $id, $tenbp);
    $stmt->execute();
    header('location: bophan.php');
    $_SESSION['response'] = "Thêm Dữ Liệu Thành Công!";
    $_SESSION['res_type'] = "success";
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $query = "DELETE FROM bophan WHERE MaBoPhan=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $id);
    $stmt->execute();

    header('location: bophan.php');
    $_SESSION['response'] = "Xoá Dữ Liệu Thành Công!";
    $_SESSION['res_type'] = "danger";
}
//thực hiện thay đổi 
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];

    $query = "SELECT * FROM bophan WHERE MaBoPhan=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    $id = $row['MaBoPhan'];
    $tenbp = $row['TenBoPhan'];
    $update = true;
}
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $tenbp = $_POST['tenbp'];

    // Kiểm tra xem dữ liệu mới có khác với dữ liệu cũ không
    $query_check = "SELECT * FROM nhacungcap WHERE MaNhaCungCap=?";
    $stmt_check = $conn->prepare($query_check);
    $stmt_check->bind_param("s", $id);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();
    $row_check = $result_check->fetch_assoc();

    $id_old = $row_check['id'];
    $tenbp_old = $row_check['tenbp'];;

    if (
        $id != $id_old || $tenbp != $tenbp_old
    ) {
        echo "Dữ liệu được chỉnh sửa mới:<br>";
        echo "ID: " . $id . "<br>";
        echo "Tên Bộ Phận: " . $tenbp . "<br>";
    }

    // Tiếp tục thực hiện câu truy vấn UPDATE
    $query = "UPDATE bophan SET TenBoPhan=? WHERE MaBoPhan=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $tenbp, $id);
    $stmt->execute();

    $_SESSION['response'] = "Cập Nhật Thành Công!";
    $_SESSION['res_type'] = "primary";
    header('location: bophan.php');
}


if (isset($_GET['details'])) {
    $id = $_GET['details'];
    $query = "SELECT * FROM bophan WHERE MaBoPhan=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    $vid = $row['MaBoPhan'];
    $vtenbp = $row['TenBoPhan'];
}
