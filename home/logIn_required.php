<?php 
 if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if(!isset($_SESSION["MaKhachHang"])){
    header("Location: ../authentication/dangnhap.php");
    exit();
}
?>