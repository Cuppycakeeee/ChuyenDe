<?php
include "config.php";
include 'action_ncc.php';
?>
<?php include 'admin_header.php' ?>
<title>Quản Lý Nhà Cung Cấp</title>
<div class="p-4 sm:ml-60">
    <div class="container-fluid">
        <div class="flex justify-center">
            <div class="w-10/12">
                <h3 class="text-center text-dark mt-2 text-xl font-medium text-gray-500 uppercase tracking-wider">Thông Tin Nhà Cung Cấp</h3>
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
            <!-- Phần cột trái (col-md-4) -->
            <div>
                <h3 class="text-center text-info text-lg font-medium text-gray-500 uppercase tracking-wider">Thêm nhà cung cấp</h3>
                <form action="action_ncc.php" method="post" enctype="multipart/form-data" class="mt-4">
                    <input type="hidden" name="id" value="<?= $id; ?>">
                    <div class="mb-4">
                        <input type="text" name="tenncc" value="<?= $tenncc; ?>" class="border rounded-lg px-4 py-2 w-full   " placeholder="Nhập tên NCC" required>
                    </div>
                    <div class="mb-4">
                        <input type="email" name="email" value="<?= $email; ?>" class="border rounded-lg px-4 py-2 w-full  " placeholder="Nhập email NCC" required>
                    </div>
                    <div class="mb-4">
                        <input type="text" name="addncc" value="<?= $addncc; ?>" class="border rounded-lg px-4 py-2 w-full  " placeholder="Nhập địa chỉ NCC" required>
                    </div>
                    <div class="mb-4">
                        <input type="text" name="phonencc" value="<?= $phonencc; ?>" class="border rounded-lg px-4 py-2 w-full  " placeholder="Nhập SĐT NCC" required>
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

            <!-- Phần cột phải (col-md-8) -->
            <div>
                <?php
                $query = 'SELECT * FROM nhacungcap';
                $stmt = $conn->prepare($query);
                $stmt->execute();
                $result = $stmt->get_result();
                ?>
                <h3 class="text-center text-info text-xl font-medium text-gray-500 uppercase tracking-wider">Các nhà cung cấp có trong dữ liệu</h3>
                <div class="account-list max-h-500 overflow-y-scroll w-900">
                    <table class="table-auto" id="data-table">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mã Nhà Cung Cấp</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tên Nhà Cung Cấp</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email Nhà Cung Cấp</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Địa Chỉ Nhà Cung Cấp</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Số Điện Thoại</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $result->fetch_assoc()) { ?>
                                <tr class="bg-white hover:bg-gray-100 transition duration-300">
                                    <td class="border px-4 py-2"><?= $row['MaNhaCungCap']; ?></td>
                                    <td class="border px-4 py-2"><?= $row['TenNhaCungCap']; ?></td>
                                    <td class="border px-4 py-2"><?= $row['Email']; ?></td>
                                    <td class="border px-4 py-2"><?= $row['DiaChi']; ?></td>
                                    <td class="border px-4 py-2"><?= $row['SoDienThoai']; ?></td>
                                    <td class="border px-4 py-2">
                                        <div class="flex flex-col">
                                            <a href="nhacungcap.php?edit=<?= $row['MaNhaCungCap']; ?>" class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-3 rounded text-sm mb-2 ">Chỉnh sửa</a>
                                            <a href="action_ncc.php?delete=<?= $row['MaNhaCungCap']; ?>" onclick="return confirm('Bạn có chắc là muốn xóa?');" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded mb-2 text-sm">Xóa</a>
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