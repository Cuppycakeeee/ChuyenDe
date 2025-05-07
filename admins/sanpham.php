<?php
include "config.php";
include 'action_sanpham.php';
?>
<?php include 'admin_header.php' ?>
<title>Quản Lý Sản Phẩm</title>
<div class="p-4 sm:ml-60">
    <div class="container mx-auto">
        <div class="container-fluid">
            <div class="flex justify-center">
                <div class="w-10/12">
                    <h3 class="text-center text-dark mt-2 text-lg font-medium text-gray-500 uppercase tracking-wider">Thông Tin Sản Phẩm</h3>
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
                <h3 class="text-center text-info text-sm font-medium text-gray-500 uppercase tracking-wider">Thêm Sản Phẩm</h3>
                <form action="action_sanpham.php" method="post" enctype="multipart/form-data" class="mt-4">
                    <input type="hidden" name="id" value="<?= $id; ?>">
                    <div class="mb-4">
                        <input type="text" name="name" value="<?= $name; ?>" class="border rounded-lg px-4 py-2 w-full" placeholder="Nhập Tên Sản Phẩm" required>
                    </div>
                    <div class="mb-4">
                        <select name="id_lts" class="border rounded-lg px-4 py-2 w-full" required>
                            <option value="">Chọn loại Sản Phẩm</option>
                            <?php
                            $query_lts = "SELECT * FROM loaisanpham";
                            $result_lts = $conn->query($query_lts);
                            while ($row_lts = $result_lts->fetch_assoc()) {
                                $idlts = $row_lts['Maloaisanpham'];
                                $tenlts = $row_lts['Tenloaisanpham'];
                                $selected = ($id_lts == $idlts) ? "selected" : "";
                                echo "<option value=\"$idlts\" $selected>$tenlts</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-4">
                        <input type="number" name="giaban" value="<?= $giaban; ?>" class="border rounded-lg px-4 py-2 w-full" placeholder="Nhập Giá Sản Phẩm" required>
                    </div>
                    <div class="mb-4">
                        <select name="id_ncc" class="border rounded-lg px-4 py-2 w-full" required>
                            <option value="">Chọn Nhà Cung Cấp</option>
                            <?php
                            $query_ncc = "SELECT * FROM nhacungcap";
                            $result_ncc = $conn->query($query_ncc);
                            while ($row_ncc = $result_ncc->fetch_assoc()) {
                                $idncc = $row_ncc['MaNhaCungCap'];
                                $tenncc = $row_ncc['TenNhaCungCap'];
                                $selected = ($id_ncc == $idncc) ? "selected" : "";
                                echo "<option value=\"$idncc\" $selected>$tenncc</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-4">
                        <input type="text" name="mota" value="<?= $mota; ?>" class="border rounded-lg px-4 py-2 w-full" placeholder="Nhập Mô Tả" required>
                    </div>
                    <div class="mb-4">
                        <input type="text" name="soluong" value="<?= $soluong; ?>" class="border rounded-lg px-4 py-2 w-full" placeholder="Nhập Số Lượng" required>
                    </div>
                    <div class="mb-4">
                        <input type="hidden" name="oldimage" value="<?= $photo; ?>">
                        <input type="file" name="image" class="border rounded-lg px-4 py-2 w-full">
                        <img src="<?= $photo; ?>" width="120" class="rounded-lg mt-2">
                    </div>
                    <div class="mb-4">
                        <input type="hidden" name="oldimage2" value="<?= $photo2; ?>">
                        <input type="file" name="image2" class="border rounded-lg px-4 py-2 w-full">
                        <img src="<?= $photo2; ?>" width="120" class="rounded-lg mt-2">
                    </div>
                    <div class="mb-4">
                        <input type="hidden" name="oldimage3" value="<?= $photo3; ?>">
                        <input type="file" name="image3" class="border rounded-lg px-4 py-2 w-full">
                        <img src="<?= $photo3; ?>" width="120" class="rounded-lg mt-2">
                    </div>
                    <div class="mb-4">
                        <?php if ($id == true) { ?>
                            <input type="submit" name="update" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded" value="Cập nhập">
                        <?php } else { ?>
                            <input type="submit" name="add" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded" value="Thêm Sản Phẩm">
                        <?php } ?>
                    </div>
                </form>
            </div>

            <div>
                <!-- Danh sách sản phẩm -->
                <div>
                    <?php
                    // Truy vấn danh sách sản phẩm
                    $query = 'SELECT u.*, lts.Tenloaisanpham, ncc.TenNhaCungCap  
                FROM sanpham u
                JOIN loaisanpham lts ON u.Maloaisanpham = lts.Maloaisanpham
                JOIN nhacungcap ncc ON u.MaNhaCungCap = ncc.MaNhaCungCap
                ORDER BY lts.Tenloaisanpham';
                    $stmt = $conn->prepare($query);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    ?>
                    <!-- Bảng danh sách sản phẩm -->
                    <div class="account-list max-h-400 overflow-y-scroll w-900">
                        <table>
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mã Sản Phẩm</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ảnh</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ảnh2</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ảnh3</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tên Sản Phẩm</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tên Loại Sản Phẩm</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Giá Bán</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tên Nhà Cung Cấp</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mô Tả</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Số Lượng</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $result->fetch_assoc()) { ?>
                                    <tr class="bg-white hover:bg-gray-100 transition duration-300">
                                        <td class="border px-6 py-3"><?= $row['MaSanPham']; ?></td>
                                        <td><img src="<?= $row['Anh']; ?>" class="rounded-lg mt-2"></td>
                                        <td><img src="<?= $row['Anh2']; ?>" class="rounded-lg mt-2"></td>
                                        <td><img src="<?= $row['Anh3']; ?>" class="rounded-lg mt-2"></td>
                                        <td class="border px-6 py-3"><?= $row['TenSanPham']; ?></td>
                                        <td class="border px-6 py-3"><?= $row['Tenloaisanpham']; ?></td>
                                        <td class="border px-6 py-3"><?= $row['GiaBan']; ?> ₫</td>
                                        <td class="border px-6 py-3"><?= $row['TenNhaCungCap']; ?></td>
                                        <td class="border px-6 py-3"><?= $row['MoTa']; ?></td>
                                        <td class="border px-6 py-3"><?= $row['SoLuong']; ?></td>
                                        <td class="border px-6 py-3">
                                            <div class="flex flex-col">
                                                <a href="sanpham.php?edit=<?= $row['MaSanPham']; ?>" class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-3 rounded text-sm mb-2">Chỉnh sửa</a>
                                                <a href="action_sanpham.php?delete=<?= $row['MaSanPham']; ?>" onclick="return confirm('Bạn có chắc là muốn xóa?');" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded mb-2 text-sm ">Xóa</a>
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
</div>
<?php include 'admin_footer.php' ?>