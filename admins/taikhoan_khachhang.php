<?php
include "config.php";
include 'action_khachhang.php';
?>
<title>Quản Lý Tài Khoản Khách Hàng</title>
<?php include 'admin_header.php' ?>
<div class="p-4 sm:ml-60">
    <?php
    $query = 'SELECT * FROM taikhoankhachhang';
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();
    ?>
    <h3 class="text-center text-info text-lg font-medium text-gray-500 uppercase tracking-wider">Các tài khoản khách hàng có trong dữ liệu</h3>
    <div class="account-list max-h-500 overflow-y-scroll w-900">
        <table class="">
            <tr class="bg-blue-300">
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mã Khách Hàng</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider ">Tên Khách Hàng</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Giới Tính</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ngày Sinh</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Địa Chỉ</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Số Điện Thoại</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mật Khẩu</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Thao tác</th>
            </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) {
                    $gioitinh = ($row['GioiTinh'] == 0) ? 'Nam' : 'Nữ';
                ?>
                    <tr class="bg-white hover:bg-gray-100 transition duration-300">
                        <td class="border px-6 py-3"><?= $row['MaKhachHang']; ?></td>
                        <td class="border px-6 py-3 whitespace-nowrap"><?= $row['TenKhachHang']; ?></td>
                        <td class="border px-6 py-3"><?= $gioitinh; ?></td>
                        <td class="border px-6 py-3"><?= $row['NgaySinh']; ?></td>
                        <td class="border px-6 py-3"><?= $row['DiaChi']; ?></td>
                        <td class="border px-6 py-3"><?= $row['SoDienThoai']; ?></td>
                        <td class="border px-6 py-3"><?= $row['Email']; ?></td>
                        <td class="border px-6 py-3"><?= substr($row['MatKhau'], 0, 10) . '...'; ?></td>
                        <td class="border px-6 py-3">
                            <div class="flex flex-col">
                                <a href="taikhoan_khachhang.php?edit=<?= $row['MaKhachHang']; ?>" class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-3 rounded mb-2 text-sm">Chỉnh sửa</a>
                                <a href="action_khachhang.php?delete=<?= $row['MaKhachHang']; ?>" onclick="return confirm('Bạn có chắc là muốn xóa?');" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded mb-2 text-sm">Xóa</a>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
    </div>
</div>
<?php include 'admin_footer.php' ?>