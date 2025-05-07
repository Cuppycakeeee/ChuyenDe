<?php
include '../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $maHoaDon = $_POST["MaHoaDon"];
    $tinhTrangDonHang = $_POST["TinhTrangDonHang"];

    $sql = "UPDATE hoadon SET TinhTrangDonHang = ? WHERE MaHoaDon = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "si", $tinhTrangDonHang, $maHoaDon);
        mysqli_stmt_execute($stmt);
        if (mysqli_stmt_affected_rows($stmt) > 0) {
            header("Location: quanlyhoadon.php?success=1");
        } else {
            header("Location: quanlyhoadon.php?error=1");
        }
        mysqli_stmt_close($stmt);
    } else {
        die("Lỗi truy vấn: " . mysqli_error($conn));
    }
}

mysqli_close($conn);
?>
