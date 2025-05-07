<?php
session_start();
include("../config.php");

if (isset($_POST['Email']) && isset($_POST['MatKhau'])) {
    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $email = validate($_POST['Email']);
    $matkhau = validate($_POST['MatKhau']);
    $user_data = 'Email=' . $email;

    if (empty($email) || empty($matkhau)) {
        header("Location: dangnhap.php?error=Vui lòng nhập tên đăng nhập và mật khẩu&$user_data");
        exit();
    } else {
        // Kiểm tra trong bảng taikhoankhachhang
        $sql_khachhang = "SELECT * FROM taikhoankhachhang WHERE Email=?";
        $stmt_khachhang = $conn->prepare($sql_khachhang);
        $stmt_khachhang->bind_param("s", $email);
        $stmt_khachhang->execute();
        $result_khachhang = $stmt_khachhang->get_result();

        if ($result_khachhang->num_rows === 1) {
            $row_khachhang = $result_khachhang->fetch_assoc();
            if (password_verify($matkhau, $row_khachhang['MatKhau'])) {
                // Thiết lập session cho khách hàng
                $_SESSION['user_type'] = 'Khách Hàng';
                $_SESSION['TenKhachHang'] = $row_khachhang['TenKhachHang'];
                $_SESSION['MaKhachHang'] = $row_khachhang['MaKhachHang'];
                $_SESSION['GioiTinh'] = $row_khachhang['GioiTinh'];
                $_SESSION['SoDienThoai'] = $row_khachhang['SoDienThoai'];
                $_SESSION['DiaChi'] = $row_khachhang['DiaChi'];
                $_SESSION['Email'] = $row_khachhang['Email'];

                header("Location: ../home/home.php");
                exit();
            } else {
                header("Location: dangnhap.php?error=Sai tên đăng nhập hoặc mật khẩu&$user_data");
                exit();
            }
        } else {
            // Kiểm tra trong bảng taikhoannhanvien
            $sql_nhanvien = "SELECT * FROM taikhoannhanvien WHERE Email=?";
            $stmt_nhanvien = $conn->prepare($sql_nhanvien);
            $stmt_nhanvien->bind_param("s", $email);
            $stmt_nhanvien->execute();
            $result_nhanvien = $stmt_nhanvien->get_result();

            if ($result_nhanvien->num_rows === 1) {
                $row_nhanvien = $result_nhanvien->fetch_assoc();
                if (password_verify($matkhau, $row_nhanvien['MatKhau'])) {
                    // Thiết lập session cho nhân viên
                    if ($row_nhanvien['TYPE_ADMIN'] === 'Chủ Cửa Hàng') {
                        $_SESSION['user_type'] = 'Chủ Cửa Hàng';
                    } elseif ($row_nhanvien['TYPE_ADMIN'] === 'Nhân Viên') {
                        $_SESSION['user_type'] = 'Nhân Viên';
                    }
                    $_SESSION['Anh'] = $row_nhanvien['Anh'];
                    $_SESSION['TenNhanVien'] = $row_nhanvien['TenNhanVien'];
                    $_SESSION['MaNhanVien'] = $row_nhanvien['MaNhanVien'];
                    $_SESSION['GioiTinh'] = $row_nhanvien['GioiTinh'];
                    $_SESSION['SoDienThoai'] = $row_nhanvien['SoDienThoai'];
                    $_SESSION['DiaChi'] = $row_nhanvien['DiaChi'];
                    $_SESSION['Email'] = $row_nhanvien['Email'];

                    header("Location: ../admins/home_admin.php");
                    exit();
                } else {
                    header("Location: dangnhap.php?error=Sai tên đăng nhập hoặc mật khẩu&$user_data");
                    exit();
                }
            } else {
                header("Location: dangnhap.php?error=Sai tên đăng nhập hoặc mật khẩu&$user_data");
                exit();
            }
        }
    }
} else {
    header("Location: dangnhap.php");
    exit();
}
?>
