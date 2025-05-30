<?php

session_start();
include "config.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/style.css">
    <link rel="icon" href="uploads/icon-logo.jpg" class="w-48 h-48" />
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>

<body class="bg-white">
    <div class="flex flex-col items-center z-40 w-60 fixed top-0 left-0 h-full overflow-hidden bg-gradient-to-b from-blue-500 to-purple-500 text-white rounded-t-lg">
        <a class="flex items-center w-full mt-3 pl-4 " href="home_admin.php">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
            </svg>

            <span class="ml-1 text-xl font-bold">Home</span>
        </a>
        <div class="w-full px-2">
            <?php
            // Kiểm tra nếu loại người dùng là Chủ Cửa Hàng
            if ($_SESSION['user_type'] === 'Chủ Cửa Hàng') {
            ?>
                <a class="flex items-center w-full h-12 px-3 mt-2 rounded-lg hover:bg-indigo-700" href="taikhoan_nhanvien.php">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Zm6-10.125a1.875 1.875 0 1 1-3.75 0 1.875 1.875 0 0 1 3.75 0Zm1.294 6.336a6.721 6.721 0 0 1-3.17.789 6.721 6.721 0 0 1-3.168-.789 3.376 3.376 0 0 1 6.338 0Z" />
                    </svg>
                    <span class="ml-2 text-sm font-bold">Thông Tin Nhân Viên</span>
                </a>

            <?php
            }
            ?>
            <a class="flex items-center w-full h-12 px-3 mt-2 rounded-lg hover:bg-indigo-700" href="taikhoan_khachhang.php">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                </svg>
                <span class="ml-2 text-sm font-bold">Thông Tin Khách Hàng</span>
            </a>
            <div class="flex flex-col items-center w-full mt-2 border-t border-gray-50">
                <button type="button" class="flex items-center w-full h-12 px-3 mt-2 rounded-lg hover:bg-indigo-700" aria-controls="dropdown-example" data-collapse-toggle="dropdown-example">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                    </svg>
                    <span class="flex-1 ml-2 text-sm font-bold text-left whitespace-nowrap" sidebar-toggle-item>Sản Phẩm</span>
                    <svg sidebar-toggle-item class="w-6 h-6 text-indigo-300" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
                <ul id="dropdown-example" class="hidden w-full">
                    <li>
                        <a href="sanpham.php" class="flex items-center w-full p-2 text-sm font-medium rounded-lg hover:bg-indigo-700 pl-11">Danh Sách Sản Phẩm</a>
                    </li>
                    <li>
                        <a href="loaisanpham.php" class="flex items-center w-full p-2 text-sm font-medium rounded-lg hover:bg-indigo-700 pl-11">Loại Sản Phẩm</a>
                    </li>
                    <li>
                        <a href="nhacungcap.php" class="flex items-center w-full p-2 text-sm font-medium rounded-lg hover:bg-indigo-700 pl-11">Nhà Cung Cấp</a>
                    </li>
                </ul>
                <a class="flex items-center w-full h-12 px-3 mt-2 rounded hover:bg-indigo-700" href="quanlyhoadon.php">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 0 0-3.213-9.193 2.056 2.056 0 0 0-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 0 0-10.026 0 1.106 1.106 0 0 0-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" />
                    </svg>
                    <span class="ml-2 text-sm font-bold">Quản Lý Đơn Hàng</span>
                </a>
                <a class="flex items-center w-full h-12 px-3 mt-2 rounded hover:bg-indigo-700" href="../authentication/dangxuat.php">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5.636 5.636a9 9 0 1 0 12.728 0M12 3v9" />
                    </svg>
                    <span class="ml-2 text-sm font-bold">Đăng Xuất</span>
                </a>
            </div>
        </div>
        <div class="w-full flex flex-col items-center mt-auto mb-6">
            <?php
            $sql_countHD = "SELECT * FROM taikhoannhanvien WHERE MaNhanVien = '{$_SESSION['MaNhanVien']}'";
            $result = mysqli_query($conn, $sql_countHD);
            $row = mysqli_fetch_assoc($result);
            ?>
            <button class="flex py-2.5 px-5 text-xs bg-indigo-500 text-white rounded-full cursor-pointer font-semibold text-center shadow-xs transition-all duration-500 hover:bg-indigo-700" href="#" data-tooltip-target="popover-footer">
                <svg class="w-6 h-6 stroke-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="ml-1 text-sm">Tài Khoản</span>
            </button>
            <div class="w-52 inline-block absolute mb-2 left-60 bottom-10 z-10 bg-white rounded-xl shadow-md text-left invisible" role="tooltip" id="popover-footer">
                <div class="p-5 border-b border-gray-200 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <?php if (isset($row['Anh'])) : ?>
                            <img src="<?php echo $row['Anh']; ?>" alt="image" class="w-14 h-14 rounded-full">
                        <?php endif; ?>
                        <div class="block">
                            <h5 class="text-sm text-gray-900 font-medium mb-0"><?php echo isset($row['TenNhanVien']) ? $row['TenNhanVien'] : ''; ?></h5>
                            <span class="text-sm text-gray-500 font-normal"><?php echo isset($row['Email']) ? $row['Email'] : ''; ?></span>
                        </div>
                    </div>
                </div>
                <div class="py-5 px-5">
                    <ul class="block space-y-2">
                        <li class="flex items-center gap-3 text-sm text-gray-900">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 5.25h.008v.008H12v-.008Z" />
                            </svg>
                            <?php echo isset($row['TYPE_ADMIN']) ? $row['TYPE_ADMIN'] : ''; ?>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

    </div>