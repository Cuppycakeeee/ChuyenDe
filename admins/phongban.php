<?php
include "config.php";
include 'action_phongban.php';
?>
<?php include 'admin_header.php' ?>
<title>Quản Lý Bộ Phận</title>
<div class="p-4 sm:ml-60">
    <div class="container-fluid">
        <div class="flex justify-center">
            <div class="w-10/12">
                <h3 class="text-center text-dark mt-2">Thông Tin Phòng Ban</h3>
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

        <div class="grid grid-cols-12 gap-4">
            <div class="col-span-6">
                <h3 class="text-center text-info">Thêm Phòng Ban</h3>
                <form action="action_phongban.php" method="post" enctype="multipart/form-data" class="mt-4">
                    <input type="hidden" name="id" value="<?= $id; ?>">
                    <div class="mb-4">
                        <input type="text" name="tenpb" value="<?= $tenpb; ?>" class="border rounded-lg px-4 py-2 w-full" placeholder="Nhập tên phòng ban" required>
                    </div>
                    <div class="mb-4">
                        <select name="id_bp" class="border rounded-lg px-4 py-2 w-full" required>
                            <option value="">Chọn bộ phận</option>
                            <?php
                            $query_bp = "SELECT * FROM bophan";
                            $result_bp = $conn->query($query_bp);
                            while ($row_bp = $result_bp->fetch_assoc()) {
                                $idbp = $row_bp['MaBoPhan'];
                                $tenbp = $row_bp['TenBoPhan'];
                                $selected = ($id_bp == $idbp) ? "selected" : "";
                                echo "<option value=\"$idbp\" $selected>$tenbp</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-4">
                        <?php if ($id == true) { ?>
                            <input type="submit" name="update" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded" value="Cập nhập">
                        <?php } else { ?>
                            <input type="submit" name="add" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded" value="Thêm Phòng Ban">
                        <?php } ?>
                    </div>
                </form>
            </div>

            <div class="col-span-6">
                <?php
                $query = 'SELECT u.*, d.TenBoPhan FROM phongban u
                    JOIN bophan d ON u.MaBoPhan = d.MaBoPhan';
                $stmt = $conn->prepare($query);
                $stmt->execute();
                $result = $stmt->get_result();
                ?>

                <h3 class="text-center text-info text-xs font-medium text-gray-500 uppercase tracking-wider">Các Phòng Ban Có trong Dữ Liệu</h3>
                <div class="account-list max-h-500 overflow-y-scroll w-900">
                    <table>
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mã Nhà Phòng Ban</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tên Phòng Ban</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tên Bộ Phận</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $result->fetch_assoc()) { ?>
                                <tr class="bg-white hover:bg-gray-100 transition duration-300">
                                    <td class="border px-6 py-3"><?= $row['MaPhongBan']; ?></td>
                                    <td class="border px-6 py-3"><?= $row['TenPhongBan']; ?></td>
                                    <td class="border px-6 py-3"><?= $row['TenBoPhan']; ?></td>
                                    <td class="border px-6 py-3">
                                        <div class="flex flex-col">
                                            <a href="phongban.php?edit=<?= $row['MaPhongBan']; ?>" class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-3 rounded text-sm mb-2">Chỉnh sửa</a>
                                            <a href="action_phongban.php?delete=<?= $row['MaPhongBan']; ?>" onclick="return confirm('Bạn có chắc là muốn xóa?');" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded text-sm mb-2">Xóa</a>
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