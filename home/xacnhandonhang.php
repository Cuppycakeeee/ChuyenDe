<?php
include("../home/logIn_required.php");
include '../home/header.php';

// Khai báo và khởi tạo biến $tongtien
$tongtien = 0;

$statement = "";

if (isset($_POST['selectedProducts'])) {
    $selectedProducts = json_decode($_POST['selectedProducts'], true);
    $_SESSION['selectedProducts'] = $selectedProducts;
    foreach ($selectedProducts as $product) {
        $masp = $product['MaSanPham'];
        $soluong = $product['SoLuong'];

        $statement .= "'" . $masp . "',";
    }
    $statement = rtrim($statement, ","); // Loại bỏ dấu phẩy cuối cùng
    $query = "SELECT SUM(giohang.SoLuong * sanpham.GiaBan) AS total
    FROM giohang
    JOIN sanpham ON giohang.MaSanPham = sanpham.MaSanPham
    WHERE giohang.MaSanPham IN ($statement) AND giohang.MaKhachHang = '{$_SESSION['MaKhachHang']}'";
    $result = mysqli_query($conn, $query);
    $ctdh = mysqli_query($conn, "SELECT *, giohang.SoLuong AS slgh, giohang.GiaBan AS dggh FROM giohang JOIN sanpham ON giohang.MaSanPham = sanpham.MaSanPham WHERE giohang.MaSanPham IN ($statement) AND giohang.MaKhachHang = '{$_SESSION['MaKhachHang']}'");
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $tongtien = $row["total"];
    } else {
        echo "Lỗi trong quá trình thực thi câu truy vấn.";
    }
}

// Gán giá trị $tongtien vào session
$_SESSION['tongtien'] = $tongtien;
?>

<title>Xác nhận đơn hàng</title>

<section class="section-pagetop bg-gray">
    <div class="container">
        <h2 class="title-page text-center text-3xl font-bold">Xác nhận đặt hàng</h2>
    </div>
</section>
<section class="section-content py-8">
    <div class="container mx-auto flex justify-center bg-white p-6 rounded-lg shadow-lg">

        <main class="w-full md:w-9/12">

            <article class="card mb-4">
                <header class="card-header">
                    <span class="block text-sm text-gray-600">
                        <?php
                        echo 'Ngày đặt hàng: ' . date('d/m/Y', strtotime(date('Y-m-d')));
                        ?>
                    </span>
                </header>
                <div class="card-body">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <h6 class="text-sm font-bold text-gray-900">Giao đến</h6>
                            <p class="text-gray-800">
                                <?php
                                echo 'Người Đặt Hàng: ' . $_SESSION["TenKhachHang"] . '<br>' .
                                    'Số điện thoại: ' . $_SESSION["SoDienThoai"] . '<br>' .
                                    'Địa chỉ: ' . $_SESSION["DiaChi"] . '<br>';
                                ?>
                            </p>
                        </div>
                        <div>
                            <h6 class="text-sm font-bold text-gray-900">Thanh toán</h6>
                            <span class="text-green-600 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
                                </svg>

                                Số tiền thanh toán
                            </span>
                            <p>
                                Tổng tiền: <?php echo formatCurrencyVND($tongtien) ?><br>
                                <span class="font-bold">Số tiền cần thanh toán: <?php echo formatCurrencyVND($tongtien) ?></span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table-auto w-full">
                        <tbody>
                            <?php if (mysqli_num_rows($ctdh) <> 0) : ?>
                                <?php while ($row = mysqli_fetch_assoc($ctdh)) : ?>
                                    <tr>
                                        <td class="w-1/6">
                                            <img src="<?php echo $row['Anh'] ?>" class="w-16 border">
                                        </td>
                                        <td class="w-3/6">
                                            <p class="mb-1"><?php echo $row['TenSanPham'] ?></p>
                                            <span class="text-xs text-gray-600"><?php echo formatCurrencyVND($row['GiaBan']) ?></span>
                                        </td>
                                        <td class="w-1/6">Số lượng <br> <?php echo $row['slgh'] ?> </td>
                                        <td class="w-1/6">Thành tiền <br>
                                            <?php echo formatCurrencyVND($row['slgh'] * $row['GiaBan']) ?>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                    <div class="flex justify-center mt-4">
                        <a href="../home/dathangthanhcong.php" class="inline-block px-4 py-2 bg-gray-900 hover:bg-yellow-600 text-white rounded shadow">Đặt hàng</a>
                    </div>
                </div>
            </article>
        </main>

    </div>
</section>


<?php
include '../home/footer.php'; ?>