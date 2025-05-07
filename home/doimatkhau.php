<?php
include("../home/logIn_required.php"); 
include '../home/header.php';

$result = mysqli_query($conn, "SELECT * FROM taikhoankhachhang WHERE taikhoankhachhang.MaKhachHang = '{$_SESSION['MaKhachHang']}'");

?>

<title>Cài đặt thông tin</title>

<section class="bg-gray">
    <div class="container mx-auto">
        <h2 class="text-3xl font-semibold">Tài khoản của tôi</h2>
    </div>
</section>

<section class="bg-white py-8">
    <div class="container mx-auto">
        <div class="flex">
        <aside class="w-1/4 pr-8">
                <nav class="list-none">
                    <a class="block py-2 px-4 text-gray-700 hover:bg-gray-200 rounded mb-2" href="../home/thongtin.php"> Thông tin chung </a>
                    <a class="block py-2 px-4 text-gray-700 hover:bg-gray-200 rounded mb-2" href="../home/dondathang.php"> Đơn hàng </a>
                    <a class="block py-2 px-4 text-black bg-yellow-300 rounded mb-2" href="../home/caidatthongtin.php">Cài đặt thông tin</a>
                    <a class="block py-2 px-4 text-gray-700 hover:bg-gray-200 rounded mb-2" href="../authentication/dangxuat.php">Đăng xuất</a>
                </nav>
            </aside>

            <main class="w-3/4">
                <div class="card">
                    <div class="card-body">
                        <form method="post" action="DoiMatKhau_Check.php" class="space-y-4">
                            <div class="space-y-2 ">
                                <p class="text-green-500"><?php if (isset($_GET['success'])) echo $_GET['success'] ?></p>
                                <label class="block">Nhập mật khẩu hiện tại</label>
                                <div>
                                    <small class="text-red-500"><?php if (isset($_GET['op_error'])) echo $_GET['op_error'] ?></small>
                                    <input type="password" class="w-full border border-gray-300 px-4 py-2 rounded-full" name="MatKhau" id="MatKhau">
                                </div>
                            </div>
                            <div class="space-y-2">
                                <label class="block">Nhập mật khẩu mới</label>
                                <div>
                                    <small class="text-red-500"><?php if (isset($_GET['np_error'])) echo $_GET['np_error'] ?></small>
                                    <input type="password" class="w-full border border-gray-300 px-4 py-2 rounded-full" name="MATKHAUMOI" id="MATKHAUMOI">
                                </div>
                            </div>
                            <div class="space-y-2">
                                <label class="block">Nhập lại mật khẩu</label>
                                <div>
                                    <small class="text-red-500"><?php if (isset($_GET['c_np_error'])) echo $_GET['c_np_error'] ?></small>
                                    <input type="password" class="w-full border border-gray-300 px-4 py-2 rounded-full" name="CONFIRM_MATKHAU" id="CONFIRM_MATKHAU">
                                </div>
                            </div>
                            <div>
                                <button type="submit" name="saveChanges" class="bg-yellow-500 text-black px-4 py-2 rounded cursor-pointer">Lưu</button>
                                <a href="caidatthongtin.php" class="bg-gray-300 text-gray-800 px-4 py-2 rounded cursor-pointer">Quay lại</a>
                            </div>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </div>
</section>

<?php
include '../home/footer.php';
?>
