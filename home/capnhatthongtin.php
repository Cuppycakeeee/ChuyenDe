<?php
include("../home/logIn_required.php");
include("../config.php");

if (isset($_POST["saveChanges"])) {
    $makh = $_SESSION['MaKhachHang'];

    // Xử lý dữ liệu đầu vào
    $tennd = mysqli_real_escape_string($conn, $_POST["TenKhachHang"]);
    $ngaysinh = mysqli_real_escape_string($conn, $_POST["NgaySinh"]);
    $diachi = mysqli_real_escape_string($conn, $_POST["DiaChi"]);
    $sdt = mysqli_real_escape_string($conn, $_POST["SoDienThoai"]);
    $gioitinh = mysqli_real_escape_string($conn, $_POST["GioiTinh"]);

    // Câu truy vấn cập nhật thông tin khách hàng
    $update_query = "UPDATE taikhoankhachhang 
                    SET TenKhachHang = '$tennd', 
                        DiaChi = '$diachi', 
                        SoDienThoai = '$sdt', 
                        GioiTinh = '$gioitinh', 
                        NgaySinh = '$ngaysinh' 
                    WHERE MaKhachHang = '$makh'";

    // Thực thi câu truy vấn
    if (mysqli_query($conn, $update_query)) {
        // Cập nhật thành công, chuyển hướng về trang cài đặt thông tin với thông báo thành công
        header("Location: caidatthongtin.php?success=true");
        exit();
    } else {
        // Lỗi khi cập nhật, chuyển hướng về trang cài đặt thông tin với thông báo lỗi
        header("Location: caidatthongtin.php?error=true");
        exit();
    }
}
?>
