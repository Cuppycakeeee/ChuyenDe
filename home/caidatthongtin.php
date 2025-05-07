<?php
include("../home/logIn_required.php");
include '../home/header.php';

// Kiểm tra nếu có thông báo thành công từ trang cập nhật thì hiển thị thông báo
if (isset($_GET['success']) && $_GET['success'] === 'true') {
    echo '<div id="successAlert" class="fixed inset-x-0 top-0 flex items-center justify-center z-50">
            <div class="bg-green-500 text-white px-6 py-4 rounded shadow-lg">
                <span class="mr-2">Cập nhật thông tin thành công!</span>
                <button id="closeSuccessAlert" class="ml-2 text-white">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
          </div>';
}

// Kiểm tra nếu có thông báo lỗi từ trang cập nhật thì hiển thị thông báo
if (isset($_GET['error']) && $_GET['error'] === 'true') {
    echo '<div id="errorAlert" class="fixed inset-x-0 top-0 flex items-center justify-center z-50">
            <div class="bg-red-500 text-white px-6 py-4 rounded shadow-lg">
                <span class="mr-2">Có lỗi xảy ra khi cập nhật thông tin. Vui lòng thử lại!</span>
                <button id="closeErrorAlert" class="ml-2 text-white">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
          </div>';
}

$result = mysqli_query($conn, "SELECT * FROM taikhoankhachhang 
    WHERE MaKhachHang = '{$_SESSION['MaKhachHang']}'");
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
                    <a class="flex items-center py-2 px-4 text-gray-700 hover:bg-gray-200 rounded mb-2" href="../home/thongtin.php">
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
                    <a class="flex items-center py-2 px-4 text-black bg-yellow-300 rounded mb-2" href="../home/caidatthongtin.php">
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
            <?php if (mysqli_num_rows($result) != 0) : ?>
                <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                    <main class="w-3/4">
                        <div class="bg-white shadow-md p-4">
                            <form method="post" action="capnhatthongtin.php" class="space-y-4" onsubmit="return validateForm()">
                                <div class="space-y-2">
                                    <label class="block pl-4 text-2xl">Họ và tên</label>
                                    <input type="text" class="w-full border border-gray-300 px-4 py-2 rounded-full" name="TenKhachHang" id="TenKhachHang" value="<?php if (isset($row['TenKhachHang'])) echo $row['TenKhachHang'] ?>">
                                </div>
                                <div class="space-y-2">
                                    <label class="block pl-4 text-2xl">Giới tính</label>
                                    <select class="w-full border border-gray-300 px-4 py-2 rounded-full" name="GioiTinh" id="GioiTinh">
                                        <option value="">-- Chọn giới tính --</option>
                                        <option value="0" <?php if (isset($row['GioiTinh']) && $row['GioiTinh'] == '0') echo 'selected' ?>>Nam</option>
                                        <option value="1" <?php if (isset($row['GioiTinh']) && $row['GioiTinh'] == '1') echo 'selected' ?>>Nữ</option>
                                    </select>
                                </div>
                                <div class="space-y-2 ">
                                    <div class="flex items-center pl-4 text-2xl">
                                        <label class="block mr-2">Ngày Sinh</label>
                                        <small class="text-sm">Ngày tháng năm theo định dạng MM-DD-YYYY</small>
                                    </div>
                                    <input type="date" class="w-full border border-gray-300 px-4 py-2 rounded-full" name="NgaySinh" id="NgaySinh" value="<?php if (isset($row['NgaySinh'])) echo $row['NgaySinh'] ?>">
                                </div>
                                <div class="space-y-2">
                                    <label class="block pl-4 text-2xl">Số điện thoại</label>
                                    <input type="text" class="w-full border border-gray-300 px-4 py-2 rounded-full" name="SoDienThoai" id="SoDienThoai" value="<?php if (isset($row['SoDienThoai'])) echo $row['SoDienThoai'] ?>">
                                </div>
                                <div class="space-y-2">
                                    <label class="block pl-4 text-2xl">Địa chỉ</label>
                                    <input type="text" class="w-full border border-gray-300 px-4 py-2 rounded-full" name="DiaChi" id="DiaChi" value="<?php if (isset($row['DiaChi'])) echo $row['DiaChi'] ?>">
                                </div>
                                <div class="space-y-2">
                                    <label class="block pl-4 text-2xl">Email đăng nhập</label>
                                    <input disabled type="text" class="w-full border border-gray-300 px-4 py-2 rounded-full" name="Email" id="Email" value="<?php if (isset($row['Email'])) echo $row['Email'] ?>">
                                </div>
                                <div>
                                    <input type="submit" value="Lưu" name="saveChanges" class="bg-yellow-500 text-black px-4 py-2 rounded cursor-pointer">
                                    <a href="doimatkhau.php" class="bg-gray-300 text-gray-800 px-4 py-2 rounded cursor-pointer">Đổi mật khẩu</a>
                                </div>
                            </form>
                        </div>
                    </main>
                <?php endwhile; ?>
            <?php endif; ?>
        </div>
    </div>
</section>
<script>
    function validateForm() {
        var tenKhachHang = document.getElementById('TenKhachHang').value.trim();
        var gioiTinh = document.getElementById('GioiTinh').value;
        var ngaySinh = document.getElementById('NgaySinh').value;
        var soDienThoai = document.getElementById('SoDienThoai').value.trim();
        var diaChi = document.getElementById('DiaChi').value.trim();

        // Kiểm tra các trường có bị bỏ trống không
        if (tenKhachHang === '' || gioiTinh === '' || ngaySinh === '' || soDienThoai === '' || diaChi === '') {
            alert('Vui lòng điền đầy đủ thông tin.');
            return false; // Ngăn form submit nếu có trường bỏ trống
        }

        return true;
    }
    // Lấy phần tử button đóng của thông báo thành công và gán sự kiện click
    document.getElementById('closeSuccessAlert').addEventListener('click', function() {
        // Ẩn đi thông báo thành công khi người dùng nhấp vào nút đóng
        document.getElementById('successAlert').style.display = 'none';
    });
    document.getElementById('closeErrorAlert').addEventListener('click', function() {
        document.getElementById('errorAlert').style.display = 'none';
    });
</script>

<?php
include '../home/footer.php';
?>