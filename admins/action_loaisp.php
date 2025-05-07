<?php
include 'config.php';
mysqli_set_charset($conn, 'utf8mb4');
$maloaisanpham = "";
$Tenloaisanpham = "";

$update = false;

if (isset($_POST['add'])) {
	$maloaisanpham = $_POST['maloaisanpham'];
	$Tenloaisanpham = $_POST['Tenloaisanpham'];

	$query = "INSERT INTO loaisanpham (Maloaisanpham, Tenloaisanpham) VALUES ( ?, ?)";
	$stmt = $conn->prepare($query);
	$stmt->bind_param("ss", $maloaisanpham, $Tenloaisanpham);
	$stmt->execute();
	header('location: loaisanpham.php');
	$_SESSION['response'] = "Thêm Dữ Liệu Thành Công!";
	$_SESSION['res_type'] = "success";
}

if (isset($_GET['delete'])) {
	$maloaisanpham = $_GET['delete'];

	$query = "DELETE FROM loaisanpham WHERE Maloaisanpham=?";
	$stmt = $conn->prepare($query);
	$stmt->bind_param("s", $maloaisanpham);
	$stmt->execute();

	header('location: loaisanpham.php');
	$_SESSION['response'] = "Xoá Dữ Liệu Thành Công!";
	$_SESSION['res_type'] = "danger";
}

if (isset($_GET['edit'])) {
	$maloaisanpham = $_GET['edit'];

	$query = "SELECT * FROM loaisanpham WHERE Maloaisanpham=?";
	$stmt = $conn->prepare($query);
	$stmt->bind_param("s", $maloaisanpham);
	$stmt->execute();
	$result = $stmt->get_result();
	$row = $result->fetch_assoc();

	$maloaisanpham = $row['Maloaisanpham'];
	$Tenloaisanpham = $row['Tenloaisanpham'];


	$update = true;
}
if (isset($_POST['update'])) {

	$maloaisanpham = $_POST['maloaisanpham'];
	$Tenloaisanpham = $_POST['Tenloaisanpham'];

	// Kiểm tra xem dữ liệu mới có khác với dữ liệu cũ không
	$query_check = "SELECT * FROM loaisanpham WHERE Maloaisanpham=?";
	$stmt_check = $conn->prepare($query_check);
	$stmt_check->bind_param("s", $maloaisanpham);
	$stmt_check->execute();
	$result_check = $stmt_check->get_result();
	$row_check = $result_check->fetch_assoc();

	$maloaisanpham_old = $row_check['maloaisanpham'];
	$Tenloaisanpham_old = $row_check['Tenloaisanpham'];

	if ($maloaisanpham != $maloaisanpham_old || $Tenloaisanpham != $Tenloaisanpham_old) {
		echo "Dữ liệu được chỉnh sửa mới:<br>";
		echo "ID loại Sản Phẩm: " . $maloaisanpham . "<br>";
		echo "Tên loại Sản Phẩm: " . $Tenloaisanpham . "<br>";
	}

	// Tiếp tục thực hiện câu truy vấn UPDATE
	$query = "UPDATE loaisanpham SET Tenloaisanpham=? WHERE Maloaisanpham=?";
	$stmt = $conn->prepare($query);
	$stmt->bind_param("ss", $Tenloaisanpham, $maloaisanpham);
	$stmt->execute();

	$_SESSION['response'] = "Cập Nhật Thành Công!";
	$_SESSION['res_type'] = "primary";
	header('location: loaisanpham.php');
}

if (isset($_GET['details'])) {
	$maloaisanpham = $_GET['details'];
	$query = "SELECT * FROM loaisanpham WHERE Maloaisanpham=?";
	$stmt = $conn->prepare($query);
	$stmt->bind_param("s", $maloaisanpham);
	$stmt->execute();
	$result = $stmt->get_result();
	$row = $result->fetch_assoc();

	$vid = $row['Maloaisanpham'];
	$vTenloaisanpham = $row['Tenloaisanpham'];
}
