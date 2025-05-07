<?php
    include "config.php";
    mysqli_set_charset($conn, 'utf8mb4');

    $id="";
    $name="";
    $id_lts = "";
    $giaban ="";
    $id_ncc ="";
    $mota ="";
    $photo="";
    $photo2="";
    $photo3="";
    $soluong = "";

    $update=false;

if (isset($_POST['add'])) {

    $id = $_POST['id'];
    $name = $_POST['name'];
    $id_lts = $_POST['id_lts'];
    $giaban = $_POST['giaban'];
    $id_ncc = $_POST['id_ncc'];
    $mota = $_POST['mota'];
    $photo=$_FILES['image']['name'];
    $photo2=$_FILES['image2']['name'];
    $photo3=$_FILES['image3']['name'];
    $upload="uploads/".$photo;
    $upload2="uploads/".$photo2;
    $upload3="uploads/".$photo3;
    $soluong = $_POST['soluong'];

    $query = "INSERT INTO sanpham (MaSanPham, TenSanPham, Maloaisanpham, GiaBan , MaNhaCungCap , MoTa,
    Anh, Anh2, Anh3, SoLuong) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssssssss", $id, $name, $id_lts, $giaban, $id_ncc, $mota, $upload, $upload2, $upload3, $soluong);
    $stmt->execute();
    move_uploaded_file($_FILES['image']['tmp_name'], $upload);
    $_SESSION['response'] = "Thêm Dữ Liệu Thành Công!";
    $_SESSION['res_type'] = "success";
    header('location: sanpham.php');
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $query = "DELETE FROM sanpham WHERE MaSanPham=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $id);
    $stmt->execute();

    $_SESSION['response'] = "Xoá Dữ Liệu Thành Công!";
    $_SESSION['res_type'] = "danger";
    header('location: sanpham.php');
}

if (isset($_GET['edit'])) {
    $id = $_GET['edit'];

    $query = "SELECT * FROM sanpham WHERE MaSanPham=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    $id = $row['MaSanPham'];
    $name = $row['TenSanPham'];
    $id_lts = $row['Maloaisanpham'];
    $giaban = $row['GiaBan'];
    $id_ncc = $row['MaNhaCungCap'];
    $mota = $row['MoTa'];
    $photo= $row['Anh'];
    $photo2= $row['Anh2'];
    $photo3= $row['Anh3'];
    $soluong = $row['SoLuong'];

    $update = true;
}

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $id_lts = $_POST['id_lts'];
    $giaban = $_POST['giaban'];
    $id_ncc = $_POST['id_ncc'];
    $mota = $_POST['mota'];
    $oldimage=$_POST['oldimage'];
    $oldimage2=$_POST['oldimage2'];
    $oldimage3=$_POST['oldimage3'];
    $soluong = $_POST['soluong'];

    if(isset($_FILES['image']['name'])&&($_FILES['image']['name']!="")){
        $newimage="uploads/".$_FILES['image']['name'];
        unlink($oldimage);
        move_uploaded_file($_FILES['image']['tmp_name'], $newimage);
    }
    else{
        $newimage=$oldimage;
    }
    if(isset($_FILES['image2']['name'])&&($_FILES['image2']['name']!="")){
        $newimage2="uploads/".$_FILES['image2']['name'];
        unlink($oldimage2);
        move_uploaded_file($_FILES['image']['tmp_name'], $newimage2);
    }
    else{
        $newimage2=$oldimage2;
    }
    if(isset($_FILES['image3']['name'])&&($_FILES['image3']['name']!="")){
        $newimage3="uploads/".$_FILES['image3']['name'];
        unlink($oldimage3);
        move_uploaded_file($_FILES['image3']['tmp_name'], $newimage3);
    }
    else{
        $newimage3=$oldimage3;
    }

    $query = "UPDATE sanpham SET TenSanPham=?, Maloaisanpham=?, GiaBan=?, MaNhaCungCap=?, MoTa=?, Anh=?, Anh2=?, Anh3=?, 
    SoLuong=? WHERE MaSanPham=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssssssss",$name ,$id_lts, $giaban, $id_ncc, $mota, $newimage, $newimage2, $newimage3, $soluong, $id);
    $stmt->execute();

    $_SESSION['response'] = "Cập Nhật Thành Công!";
    $_SESSION['res_type'] = "primary";
    header('location: sanpham.php');
}
