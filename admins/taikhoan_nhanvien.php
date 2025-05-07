<?php
include "config.php";
include 'action_nhanvien.php';
?>
<?php include 'admin_header.php' ?>
<title>Quản Lý Tài Khoản Nhân Viên</title>
<div class="p-4 sm:ml-60">
    <div class="container-fluid">
        <div class="flex justify-center">
            <div class="w-10/12">
                <h3 class="text-center text-dark mt-2 text-lg font-medium text-gray-500 uppercase tracking-wider">Thông Tin Tài Khoản Nhân Viên</h3>
                <hr class="my-4">
                <?php if (isset($_SESSION['response'])) { ?>
                    <div id="alert-message" class="alert alert-<?= $_SESSION['res_type']; ?> text-center">
                        <button id="close-btn" type="button" class="close">&times;</button>
                        <b><?= $_SESSION['response']; ?></b>
                    </div>
                <?php }
                unset($_SESSION['response']); ?>
            </div>
        </div>

        <div>
            <div>
                <h3 class="text-center text-info text-xs font-medium text-gray-500 uppercase tracking-wider">Thêm Tài Khoản Nhân Viên</h3>
                <form action="action_nhanvien.php" method="post" enctype="multipart/form-data" class="mt-4">
                    <input type="hidden" name="id" value="<?= $id; ?>">
                    <div class="mb-4">
                        <input type="text" name="name" value="<?= $name; ?>" class="border rounded-lg px-4 py-2 w-full " placeholder="Nhập Tên Nhân Viên" required>
                    </div>
                    <div class="mb-4">
                        <select name="gioitinh" class="border rounded-lg px-4 py-2 w-full " required>
                            <option value="">Chọn Giới Tính</option>
                            <option value="0" <?= ($gioitinh == '0') ? 'selected' : ''; ?>>Nam</option>
                            <option value="1" <?= ($gioitinh == '1') ? 'selected' : ''; ?>>Nữ</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <input type="date" name="ngaysinh" value="<?= $ngaysinh; ?>" class="border rounded-lg px-4 py-2 w-full " placeholder="Nhập ngày sinh" required>
                    </div>
                    <div class="mb-4">
                        <input type="text" name="diachi" value="<?= $diachi; ?>" class="border rounded-lg px-4 py-2 w-full " placeholder="Nhập Địa Chỉ" required>
                    </div>
                    <div class="mb-4">
                        <input type="text" name="sodienthoai" value="<?= $sodienthoai; ?>" class="border rounded-lg px-4 py-2 w-full " placeholder="Nhập Số Điện Thoại" required>
                    </div>
                    <div class="mb-4">
                        <input type="text" name="email" value="<?= $email; ?>" class="border rounded-lg px-4 py-2 w-full " placeholder="Nhập Email" required>
                    </div>
                    <div class="mb-4">
                        <input type="text" name="pass" value="<?= $pass; ?>" class="border rounded-lg px-4 py-2 w-full " placeholder="Nhập Mật Khẩu" required>
                    </div>
                    <div class="mb-4">
                        <select name="type" class="border rounded-lg px-4 py-2 w-full ">
                            <option value="">Chọn Loại Nhân Viên</option>
                            <option value="Chủ Cửa Hàng" <?= (isset($type) && $type == 'Chủ Cửa Hàng') ? 'selected' : ''; ?>>Chủ Cửa Hàng</option>
                            <option value="Nhân Viên" <?= (isset($type) && $type == 'Nhân Viên') ? 'selected' : ''; ?>>Nhân Viên</option>
                        </select>
                    </div>
            </div>
            <div class="mb-4">
                <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                        <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                        </svg>
                        <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG or GIF (MAX. 800x400px)</p>
                    </div>
                    <input id="dropzone-file" name="image" type="file" class="hidden" />
                    <input type="hidden" name="oldimage" value="<?= $photo; ?>">
                </label>
            </div>


            <div class="mb-4">
                <?php if ($id == true) { ?>
                    <input type="submit" name="update" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded" value="Cập nhập">
                <?php } else { ?>
                    <input type="submit" name="add" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded" value="Thêm tài khoản">
                <?php } ?>
            </div>
            </form>
        </div>
        <div>
            <?php
            $query = 'SELECT * FROM taikhoannhanvien';
            $stmt = $conn->prepare($query);
            $stmt->execute();
            $result = $stmt->get_result();
            ?>
            <h3 class="text-center text-info">Các bộ phận có trong dữ liệu</h3>
            <div class="account-list max-h-500 overflow-y-scroll w-900">
                <table class="table-auto" id="data-table">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mã Nhân Viên</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ảnh</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tên Nhân Viên</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Giới Tính</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ngày Sinh</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Địa Chỉ</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Số Điện Thoại</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mật Khẩu</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Loại Tài Khoản</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()) {
                            $gioitinh = ($row['GioiTinh'] == 0) ? 'Nam' : 'Nữ';
                        ?>
                            <tr class="bg-white text-xs hover:bg-gray-100 transition duration-300">
                                <td class="border px-6 py-3"><?= $row['MaNhanVien']; ?></td>
                                <td><img src="<?= $row['Anh']; ?>" width="120" class="rounded-lg mt-2"></td>
                                <td class="border px-6 py-3 whitespace-nowrap"><?= $row['TenNhanVien']; ?></td>
                                <td class="border px-6 py-3"><?= $gioitinh; ?></td>
                                <td class="border px-6 py-3"><?= $row['NgaySinh']; ?></td>
                                <td class="border px-6 py-3"><?= $row['DiaChi']; ?></td>
                                <td class="border px-6 py-3"><?= $row['SoDienThoai']; ?></td>
                                <td class="border px-6 py-3"><?= $row['Email']; ?></td>
                                <td class="border px-6 py-3"><?= substr($row['MatKhau'], 0, 10) . '...'; ?></td>
                                <td class="border px-6 py-3"><?= $row['TYPE_ADMIN']; ?></td>
                                <td class="border px-6 py-3">
                                    <div class="flex flex-col">
                                        <a href="taikhoan_nhanvien.php?edit=<?= $row['MaNhanVien']; ?>" class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-3 rounded text-sm mb-2">Chỉnh sửa</a>
                                        <a href="action_nhanvien.php?delete=<?= $row['MaNhanVien']; ?>" onclick="return confirm('Bạn có chắc là muốn xóa?');" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded mb-2 text-sm">Xóa</a>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>
<?php include 'admin_footer.php' ?>