<?php
include("../home/logIn_required.php");
include "../config.php";

if (isset($_POST['MatKhau']) && isset($_POST['MATKHAUMOI']) && isset($_POST['CONFIRM_MATKHAU'])) {

    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $op = validate($_POST['MatKhau']);
    $np = validate($_POST['MATKHAUMOI']);
    $c_np = validate($_POST['CONFIRM_MATKHAU']);
    $op_error = $c_np_error = $np_error = "";
    $error_check = false;

    if (empty($op)) {
        $op_error = "op_error=Yêu cầu nhập mật khẩu hiện tại";
        $error_check = true;
    }
    if (empty($np)) {
        $np_error = "np_error=Yêu cầu nhập mật khẩu mới";
        $error_check = true;
    }
    if ($np !== $c_np) {
        $c_np_error = "c_np_error=Mật khẩu không khớp";
        $error_check = true;
    }
    if ($error_check) {
        $error_query =  $op_error . "&" .  $np_error . "&" . $c_np_error;
        header("Location: DoiMatKhau.php?" . $error_query);
        exit();
    } else {
        $id = $_SESSION['MaKhachHang'];
        $op_hashed = password_hash($op, PASSWORD_DEFAULT); // Mã hoá mật khẩu hiện tại
        $sql = "SELECT MatKhau FROM taikhoankhachhang WHERE MaKhachHang='$id'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $hashed_password = $row['MatKhau'];

        if (password_verify($op, $hashed_password)) { // Kiểm tra mật khẩu hiện tại đã được mã hoá đúng không
            $hashed_new_password = password_hash($np, PASSWORD_DEFAULT); // Mã hoá mật khẩu mới
            $sql_2 = "UPDATE taikhoankhachhang SET MatKhau='$hashed_new_password' WHERE MaKhachHang='$id'";
            mysqli_query($conn, $sql_2);
            header("Location: DoiMatKhau.php?success=Đổi mật khẩu thành công");
            exit();
        } else {
            header("Location: DoiMatKhau.php?error=Mật khẩu hiện tại không đúng");
            exit();
        }
    }
} else {
    header("Location: ../home/home.php");
    exit();
}
?>
