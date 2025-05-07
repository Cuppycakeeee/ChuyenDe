<?php
include("../home/logIn_required.php");

if (!isset($_SESSION['MaKhachHang'])) {
    header("Location: ../authentication/dangnhap.php");
    exit();
}
include '../home/header.php';

$result = mysqli_query($conn, "SELECT * FROM taikhoankhachhang 
WHERE MaKhachHang = '{$_SESSION['MaKhachHang']}'");
?>
<title>Thông tin cá nhân</title>
<section class="bg-gray">
    <div class="container mx-auto">
        <h2 class="text-3xl font-semibold">Tài khoản của tôi</h2>
    </div>
</section>
<?php if (mysqli_num_rows($result) <> 0) : ?>
    <?php while ($row = mysqli_fetch_assoc($result)) : ?>
        <section class="py-8">
            <div class="container mx-auto">
                <div class="flex">
                    <aside class="w-1/4 pr-8">
                        <nav class="list-none">
                            <a class="flex items-center py-2 px-4  text-black bg-yellow-300 rounded mb-2" href="../home/thongtin.php">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Zm6-10.125a1.875 1.875 0 1 1-3.75 0 1.875 1.875 0 0 1 3.75 0Zm1.294 6.336a6.721 6.721 0 0 1-3.17.789 6.721 6.721 0 0 1-3.168-.789 3.376 3.376 0 0 1 6.338 0Z" />
                                </svg>
                                <span class="ml-2 text-sm font-bold">Thông Tin</span>
                            </a>
                            <a class="flex items-center py-2 px-4 text-gray-700 hover:bg-gray-200 rounded mb-2" href="../home/dondathang.php">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                                </svg>
                                <span class="ml-2 text-sm font-bold">Đơn hàng</span>
                            </a>
                            <a class="flex items-center py-2 px-4 text-gray-700 hover:bg-gray-200 rounded mb-2" href="../home/caidatthongtin.php">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.723 7.723 0 0 1 0 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 0 1 0-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>
                                <span class="ml-2 text-sm font-bold">Cài đặt thông tin</span>
                            </a>
                            <a class="flex items-center py-2 px-4 text-gray-700 hover:bg-gray-200 rounded mb-2" href="../authentication/dangxuat.php">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5.636 5.636a9 9 0 1 0 12.728 0M12 3v9" />
                                </svg>
                                <span class="ml-2 text-sm font-bold">Đăng xuất</span>
                            </a>
                        </nav>
                    </aside>
                    <main class="w-3/4">
                        <article class="mb-6">
                            <div class="p-6 bg-white border rounded">
                                <div class="mb-4">
                                    <strong class="text-xl">
                                        <?php echo $row['TenKhachHang']; ?>
                                    </strong>
                                    <p class="text-gray-700">
                                        <?php echo $row['Email']; ?>
                                    </p>
                                </div>
                                <hr class="my-4">
                                <p class="text-gray-700">
                                    <span class="text-xl flex items-center">
                                        &nbsp;
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                        </svg>

                                        Địa chỉ của tôi: <?php echo $row['DiaChi']; ?>
                                    </span>
                                </p>
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="p-3 bg-gray-100 rounded">
                                        <h4 class="text-xl">
                                            <?php
                                            $result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM taikhoankhachhang
                                                JOIN hoadon ON taikhoankhachhang.MaKhachHang = hoadon.MaKhachHang
                                                WHERE taikhoankhachhang.MaKhachHang = '{$_SESSION['MaKhachHang']}'");
                                            $row = mysqli_fetch_assoc($result);
                                            $total = $row['total'];
                                            echo $total;
                                            ?>
                                        </h4>
                                        <span>Đơn đặt hàng</span>
                                    </div>
                                    <div class="p-3 bg-gray-100 rounded">
                                        <h4 class="text-xl">
                                            <?php
                                            $query = "SELECT SUM(ct.SoLuong) AS total
                                                FROM hoadon hd
                                                JOIN chitiethoadon ct ON hd.MaHoaDon = ct.MaHoaDon
                                                join taikhoankhachhang on hd.MaKhachHang = taikhoankhachhang.MaKhachHang
                                                WHERE hd.TinhTrangDonHang = 'Giao hàng thành công' and taikhoankhachhang.MaKhachHang = '{$_SESSION['MaKhachHang']}'";
                                            $result = mysqli_query($conn, $query);
                                            $row = mysqli_fetch_assoc($result);
                                            $total = $row['total'];
                                            echo isset($total) ? $total : 0;
                                            ?>
                                        </h4>
                                        <span>Sản phẩm đã mua</span>
                                    </div>
                                    <div class="p-3 bg-gray-100 rounded">
                                        <h4 class="text-xl">
                                            <?php
                                            $result = mysqli_query($conn, "SELECT count(hoadon.MaHoaDon) as total
                                                from hoadon join taikhoankhachhang on hoadon.MaKhachHang = taikhoankhachhang.MaKhachHang
                                                where hoadon.MaKhachHang = '{$_SESSION['MaKhachHang']}'and hoadon.TinhTrangDonHang = 'Đang giao hàng'");
                                            $row = mysqli_fetch_assoc($result);
                                            $total = $row['total'];
                                            echo isset($total) ? $total : 0;
                                            ?>
                                        </h4>
                                        <span>Đơn hàng đang giao</span>
                                    </div>
                                    <div class="p-3 bg-gray-100 rounded">
                                        <h4 class="text-xl">
                                            <?php
                                            $result = mysqli_query($conn, "SELECT count(hoadon.MaHoaDon) as total
                                                from hoadon join taikhoankhachhang on hoadon.MaKhachHang = taikhoankhachhang.MaKhachHang
                                                where hoadon.MaKhachHang = '{$_SESSION['MaKhachHang']}'and hoadon.TinhTrangDonHang = 'Giao hàng thành công'");
                                            $row = mysqli_fetch_assoc($result);
                                            $total = $row['total'];
                                            echo isset($total) ? $total : 0;
                                            ?>
                                        </h4>
                                        <span>Đơn hàng đã giao</span>
                                    </div>
                                </div>
                            </div>
                        </article>
                        <article class="bg-white shadow-lg mb-3">
                            <div class="px-6 py-4">
                                <h5 class="text-xl font-semibold mb-4">Đơn hàng gần đây</h5>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <?php
                                    $result = mysqli_query($conn, "SELECT * 
                                    FROM hoadon 
                                    JOIN chitiethoadon ON hoadon.MaHoaDon = chitiethoadon.MaHoaDon 
                                    JOIN sanpham ON chitiethoadon.MaSanPham = sanpham.MaSanPham
                                    WHERE hoadon.MaKhachHang = '{$_SESSION['MaKhachHang']}'
                                    ORDER BY hoadon.NgayLap DESC
                                    LIMIT 4");

                                    if (mysqli_num_rows($result) > 0) :
                                        while ($row = mysqli_fetch_assoc($result)) :
                                    ?>
                                            <div class="flex items-center border-b pb-4">
                                                <img src="<?php echo $row['Anh']; ?>" alt="Product Image" class="w-16 h-16 object-cover border rounded-md mr-4">
                                                <div>
                                                    <time class="text-gray-500 block"><i class="fas fa-calendar-alt mr-1"></i><?php echo $row['NgayLap']; ?></time>
                                                    <a href="../home/xemchitiet.php?id=<?php echo $row['MaSanPham']; ?>" class="text-black hover:text-yellow-500 block"><?php echo $row['TenSanPham']; ?></a>
                                                    <span class="text-green-500 block"><?php echo $row['TinhTrangDonHang']; ?></span>
                                                </div>
                                            </div>
                                    <?php
                                        endwhile;
                                    else :
                                        echo "<p class='text-gray-500'>Không có đơn hàng gần đây.</p>";
                                    endif;
                                    ?>
                                </div>
                            </div>
                            <div class="px-6 py-4">
                                <a href="DonDatHang.php" class="inline-block px-4 py-2 text-blue-500 border border-blue-500 rounded hover:bg-blue-500 hover:text-white transition duration-300 ease-in-out">Xem tất cả <i class="fas fa-chevron-down"></i></a>
                            </div>
                        </article>
                    </main>
                </div>
            </div>
        </section>
    <?php endwhile; ?>
<?php endif; ?>
<?php include '../home/footer.php' ?>