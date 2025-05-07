<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../home/uploads/icon-logo.jpg" class="w-48 h-48" />
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <style>
        .swiper-wrapper {
            width: 100%;
            height: max-content !important;
            padding-bottom: 64px !important;
            -webkit-transition-timing-function: linear !important;
            transition-timing-function: linear !important;
            position: relative;
        }

        .swiper-pagination-progressbar .swiper-pagination-progressbar-fill {
            background: linear-gradient(96deg, rgba(34,193,195,1) 0%, rgba(253,187,45,1) 100%);
        }

        .hover-trigger:hover img:first-child {
            opacity: 0;
        }

        .hover-trigger:hover img:last-child {
            opacity: 1;
        }
    </style>
</head>

<body>
    <?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    include "../config.php";
    function formatCurrencyVND($number)
    {
        $formattedNumber = number_format($number, 0, '.', ',') . ' VND';
        return $formattedNumber;
    }
    ?>
    <nav>
        <div id="nav-top" class="flex flex-wrap justify-between items-center mx-auto max-w-screen-xl p-4">
            <a href="<?php echo '../home/home.php'; ?>" class="flex items-center space-x-1 ">
                <img src="../home/uploads/icon-logo.jpg" class="h-8" alt="Logo" />
                <span class="self-center text-2xl font-semibold whitespace-nowrap">KickZspot Giày và Phụ Kiện  </span>
            </a>
            <div class="flex items-center justify-between">
                <div class="pt-2 relative mx-auto text-gray-600">
                    <form action="timkiem.php" method="GET">
                        <input class="border-2 border-gray-300 bg-white h-10 px-5 pr-16 rounded-lg text-sm focus:outline-none" type="text" name="q" placeholder="Tìm sản phẩm..." autocomplete="off" required>
                        <input type="hidden" name="type" value="product">
                        <button type="submit" class="absolute right-0 top-0 mt-5 mr-4">
                            <svg class="text-gray-600 h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 56.966 56.966" style="enable-background:new 0 0 56.966 56.966;" xml:space="preserve" width="512px" height="512px">
                                <path d="M55.146,51.887L41.588,37.786c3.486-4.144,5.396-9.358,5.396-14.786c0-12.682-10.318-23-23-23s-23,10.318-23,23  s10.318,23,23,23c4.761,0,9.298-1.436,13.177-4.162l13.661,14.208c0.571,0.593,1.339,0.92,2.162,0.92  c0.779,0,1.518-0.297,2.079-0.837C56.255,54.982,56.293,53.08,55.146,51.887z M23.984,6c9.374,0,17,7.626,17,17s-7.626,17-17,17  s-17-7.626-17-17S14.61,6,23.984,6z" />
                            </svg>
                        </button>
                    </form>
                </div>
                <div class="flex items-center">
                    <?php if (isset($_SESSION["MaKhachHang"])): ?>
                        <a href="../home/thongtin.php" class="mx-4">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                            </svg>
                        </a>
                    <?php else: ?>
                        <a href="../authentication/dangnhap.php" class="mx-4">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
                        </a>
                    <?php endif; ?>
                    <a href="../home/giohang.php" class="relative mx-4">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                        </svg>
                        <?php
                        if (isset($_SESSION["MaKhachHang"])) {
                            $query = "SELECT COUNT(MaGioHang) AS SoLuong FROM giohang WHERE MaKhachHang = '{$_SESSION['MaKhachHang']}'";
                            $result = mysqli_query($conn, $query);
                            $row = mysqli_fetch_assoc($result);
                            $_SESSION['SLGH'] = $row['SoLuong'];
                            $_SESSION['SLGH'] == "" ? 0 : $_SESSION['SLGH'];
                            echo '<span class="notify absolute top-0 right-0 bg-red-600 text-white rounded-full px-1.5 py-0.5 text-xs" id="CartCount">' . $_SESSION['SLGH'] . '</span>';
                        }
                        ?>
                    </a>
                </div>
            </div>
        </div>
        <div id="nav-bottom" class="max-w-screen-xl px-1 py-3 mx-auto">
            <button id="navbar-toggle" data-collapse-toggle="navbar-dropdown" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-900 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none" aria-controls="navbar-dropdown" aria-expanded="false">
                <span class="sr-only">Open main menu</span>
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15" />
                </svg>
            </button>
            <div class="items-center hidden w-full md:block md:w-auto" id="navbar-dropdown">
                <ul class="flex flex-col font-medium p-4 md:p-0 mt-4 border-t-4 border-yellow-300 md:flex-row md:space-x-8 md:mt-0">
                    <li class="mr-4">
                        <a href="<?php echo '../home/home.php'; ?>" class="block py-2 pl-3 pr-4 text-gray-900 font-semibold border-b-2 border-transparent hover:border-yellow-300">Trang Chủ</a>
                    </li>
                    <li class="relative group">
                        <button id="dropdownNavbarLink" class="flex items-center justify-between w-full py-2 pl-3 pr-4 font-semibold border-b-2 border-transparent hover:border-yellow-300">
                            Sản Phẩm
                            <svg class="w-2.5 h-2.5 ml-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                            </svg>
                        </button>

                        <div id="dropdownNavbar" class="absolute z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-lg w-44">
                            <ul class="py-2 text-sm text-gray-700 dark:text-gray-400" aria-labelledby="dropdownLargeButton">
                                <li>
                                    <a href="../home/giay.php" class="block px-4 py-2 hover:bg-gray-100 font-semibold">Giày</a>
                                </li>
                                <li>
                                    <a href="../home/giaythethao.php" class="block px-4 py-2 hover:bg-gray-100 font-semibold">Giày Thể Thao</a>
                                </li>
                                <li>
                                    <a href="../home/phukienthoitrang.php" class="block px-4 py-2 hover:bg-gray-100 font-semibold">Phụ Kiện Thời Trang</a>
                                </li>
                                <li>
                                    <a href="../home/phukiendienthoai.php" class="block px-4 py-2 hover:bg-gray-100 font-semibold">Phụ Kiện điện Thoại</a>
                                </li>
                                <li>
                                    <a href="../home/tui.php" class="block px-4 py-2 hover:bg-gray-100 font-semibold">Túi</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="mr-4">
                        <a href="../home/lienhe.php" class="block py-2 pl-3 pr-4 text-gray-900 font-semibold border-b-2 border-transparent hover:border-yellow-300"> Liên Hệ</a>
                    </li>
                    <li class="mr-4">
                        <a href="../home/#" class="block py-2 pl-3 pr-4 text-gray-900 font-semibold border-b-2 border-transparent hover:border-yellow-300">  Sản phẩm mới / Hàng mới về</a>
                    </li>
                    <li class="mr-4">
                        <a href="../home/test.php" class="block py-2 pl-3 pr-4 text-gray-900 font-semibold border-b-2 border-transparent hover:border-yellow-300">Bộ sưu tập / Xu hướng hot</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
