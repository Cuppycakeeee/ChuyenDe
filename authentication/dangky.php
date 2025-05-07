<?php
include '../home/header.php';
include("../config.php");
include("../authentication/dangky_check.php");

// Khởi tạo các biến để tránh lỗi "Undefined variable"
$id = "";
$name = "";
$email = "";
$gioitinh = "";
$ngaysinh = "";
$diachi = "";
$sodienthoai = "";
$pass = "";

?>
<title>Đăng Ký</title>
<section class="bg-white">
    <div class="lg:grid lg:min-h-screen lg:grid-cols-12">
        <aside class="relative block h-16 lg:order-last lg:col-span-5 lg:h-full xl:col-span-6">
            <img alt="" src="../home/uploads/dangki.png" class="absolute inset-0 h-full w-full object-cover rounded-3xl" />
        </aside>
        <main class="flex items-center justify-center px-8 py-8 sm:px-12 lg:col-span-7 lg:px-16 lg:py-12 xl:col-span-6">
            <div class="max-w-xl lg:max-w-3xl">
                <h1 class="mt-6 text-xl font-bold text-gray-900 sm:text-2xl md:text-3xl">
                    Chào mừng tới của hàng KickZspot
                </h1>
                <form action="../authentication/dangky_check.php" method="post" class="mt-8 grid grid-cols-6 gap-6">
                    <!-- Các trường dữ liệu của biểu mẫu -->
                    <input type="hidden" name="id" value="<?= $id; ?>">

                    <!-- Họ và tên Khách Hàng -->
                    <div class="col-span-6 sm:col-span-3">
                        <label class="block text-sm font-medium text-gray-700">Họ và tên Khách Hàng</label>
                        <input type="text" name="name" value="<?= $name; ?>" class="mt-1 p-2 w-full rounded-md border-gray-200 bg-white text-sm text-gray-700 shadow-lg" required>
                    </div>

                    <!-- Email -->
                    <div class="col-span-6 sm:col-span-3">
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="text" name="email" value="<?= $email; ?>" class="mt-1 p-2 w-full rounded-md border-gray-200 bg-white text-sm text-gray-700 shadow-lg" required>
                    </div>

                    <!-- Giới Tính -->
                    <div class="col-span-6 sm:col-span-3">
                        <label class="block text-sm font-medium text-gray-700">Giới Tính</label>
                        <select name="gioitinh" class="mt-1 p-2 w-full rounded-md border-gray-200 bg-white text-sm text-gray-700 shadow-lg" required>
                            <option value="">Chọn giới tính</option>
                            <option value="0" <?= ($gioitinh == '0') ? 'selected' : ''; ?>>Nam</option>
                            <option value="1" <?= ($gioitinh == '1') ? 'selected' : ''; ?>>Nữ</option>
                        </select>
                    </div>

                    <!-- Ngày Sinh -->
                    <div class="col-span-6 sm:col-span-3">
                        <label class="block text-sm font-medium text-gray-700">Ngày Sinh</label>
                        <input type="date" name="ngaysinh" value="<?= $ngaysinh; ?>" class="mt-1 p-2 w-full rounded-md border-gray-200 bg-white text-sm text-gray-700 shadow-lg" required>
                    </div>

                    <!-- Địa Chỉ -->
                    <div class="col-span-6 sm:col-span-3">
                        <label class="block text-sm font-medium text-gray-700">Địa Chỉ</label>
                        <input type="text" name="diachi" value="<?= $diachi; ?>" class="mt-1 p-2 w-full rounded-md border-gray-200 bg-white text-sm text-gray-700 shadow-lg" required>
                    </div>

                    <!-- Số Điện Thoại -->
                    <div class="col-span-6 sm:col-span-3">
                        <label class="block text-sm font-medium text-gray-700">Số Điện Thoại</label>
                        <input type="text" name="sodienthoai" value="<?= $sodienthoai; ?>" class="mt-1 p-2 w-full rounded-md border-gray-200 bg-white text-sm text-gray-700 shadow-lg" required>
                    </div>

                    <!-- Mật Khẩu -->
                    <div class="col-span-6 sm:col-span-3">
                        <label class="block text-sm font-medium text-gray-700">Mật Khẩu</label>
                        <input type="text" name="pass" value="<?= $pass; ?>" class="mt-1 p-2 w-full rounded-md border-gray-200 bg-white text-sm text-gray-700 shadow-lg" required>
                    </div>

                    <!-- Nút Tạo Tài Khoản và Đăng Nhập -->
                    <div class="col-span-6 sm:flex sm:items-center sm:gap-4">
                        <input type="submit" name="add" class="inline-block shrink-0 rounded-md border border-yellow-600 bg-yellow-600 px-12 py-3 text-sm font-medium text-white transition hover:bg-transparent hover:text-yellow-600 focus:outline-none focus:ring active:text-yellow-500" value="Thêm tài khoản">
                        <p class="mt-4 text-sm text-gray-500 sm:mt-0">Bạn đã có tài khoản rồi ư??? <a href="../authentication/dangnhap.php" class="text-gray-700 underline">Đăng Nhập</a>.</p>
                    </div>
                </form>
            </div>
        </main>
    </div>
</section>

<?php include '../home/footer.php' ?>

