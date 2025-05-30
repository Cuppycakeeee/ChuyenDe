<title>Quản Lý Hoá Đơn</title>
<?php
include '../config.php';
include 'admin_header.php';

// Lấy giá trị filter từ form (nếu có)
$tinhtrangFilter = isset($_GET['tinhtrang']) ? $_GET['tinhtrang'] : '';

// Lấy thông tin hóa đơn cùng thông tin khách hàng
$sql = "
    SELECT 
        hoadon.MaHoaDon, 
        hoadon.NgayLap, 
        taikhoankhachhang.TenKhachHang, 
        taikhoankhachhang.SoDienThoai, 
        taikhoankhachhang.DiaChi, 
        hoadon.TinhTrangDonHang,
        SUM(chitiethoadon.SoLuong * chitiethoadon.GiaBan) AS TongTien
    FROM 
        hoadon
    INNER JOIN 
        taikhoankhachhang ON hoadon.MaKhachHang = taikhoankhachhang.MaKhachHang
    INNER JOIN 
        chitiethoadon ON hoadon.MaHoaDon = chitiethoadon.MaHoaDon
";

// Thêm điều kiện lọc nếu có chọn tình trạng
if ($tinhtrangFilter != '') {
    $sql .= " WHERE hoadon.TinhTrangDonHang = '" . mysqli_real_escape_string($conn, $tinhtrangFilter) . "'";
}

$sql .= " GROUP BY hoadon.MaHoaDon";

$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Lỗi truy vấn: " . mysqli_error($conn));
}
?>
<!-- Bộ lọc tình trạng đơn hàng -->
<div class="p-4 sm:ml-60">
    <h3 class="text-3xl text-center text-info font-medium text-gray-500 uppercase tracking-wider">QUẢN LÝ HÓA ĐƠN</h3>
    <div class="flex justify-end mb-6">
        <div class="bg-white shadow-lg rounded-lg px-6 py-3 flex items-center gap-3">
            <form method="get" class="flex items-center gap-2">
                <select name="tinhtrang" id="tinhtrang" class="border border-blue-300 rounded px-2 py-1 focus:ring focus:ring-blue-200">
                    <option value="">Tất cả</option>
                    <option value="Đang xử lý" <?php if($tinhtrangFilter=='Đang xử lý') echo 'selected'; ?>>Đang xử lý</option>
                    <option value="Đang giao hàng" <?php if($tinhtrangFilter=='Đang giao hàng') echo 'selected'; ?>>Đang giao hàng</option>
                    <option value="Giao hàng thành công" <?php if($tinhtrangFilter=='Giao hàng thành công') echo 'selected'; ?>>Giao hàng thành công</option>
                    <option value="Giao hàng thất bại" <?php if($tinhtrangFilter=='Giao hàng thất bại') echo 'selected'; ?>>Giao hàng thất bại</option>
                </select>
                <button type="submit" class="p-2 rounded bg-blue-500 hover:bg-blue-600 text-white flex items-center" title="Lọc">
                    <!-- Filter icon SVG -->
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zm0 6h18M4 10v10a1 1 0 001 1h14a1 1 0 001-1V10"></path>
                    </svg>
                </button>
            </form>
        </div>
    </div>
    <div class="overflow-x-auto rounded-lg shadow">
        <table class="min-w-full table-auto border-collapse border">
            <thead>
                <tr class="bg-blue-300 text-gray-700">
                    <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">Mã hoá đơn</th>
                    <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">Ngày tạo</th>
                    <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">Tên khách hàng</th>
                    <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">Số điện thoại</th>
                    <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">Địa chỉ</th>
                    <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">Tình trạng đơn hàng</th>
                    <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">Tổng tiền</th>
                    <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">Chức năng</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                ?>
                        <tr class="bg-white hover:bg-blue-50 transition duration-200">
                            <td class="border px-6 py-3"><?php echo $row["MaHoaDon"]; ?></td>
                            <td class="border px-6 py-3"><?php echo $row["NgayLap"]; ?></td>
                            <td class="border px-6 py-3"><?php echo $row["TenKhachHang"]; ?></td>
                            <td class="border px-6 py-3"><?php echo $row["SoDienThoai"]; ?></td>
                            <td class="border px-6 py-3"><?php echo $row["DiaChi"]; ?></td>
                            <td class="border px-6 py-3">
                                <span class="<?php
                                    switch($row["TinhTrangDonHang"]) {
                                        case 'Giao hàng thành công': echo 'text-green-600 font-semibold'; break;
                                        case 'Giao hàng thất bại': echo 'text-red-600 font-semibold'; break;
                                        case 'Đang giao hàng': echo 'text-yellow-600 font-semibold'; break;
                                        default: echo 'text-blue-600 font-semibold';
                                    }
                                ?>">
                                    <?php echo $row["TinhTrangDonHang"]; ?>
                                </span>
                            </td>
                            <td class="border px-6 py-3"><?php echo number_format($row["TongTien"], 0, ',', '.') . ' VND'; ?></td>
                            <td class="flex flex-col gap-2 py-3">
                                <button type="button" class="bg-green-500 hover:bg-green-600 text-white font-bold py-1 px-4 rounded-full shadow" data-id="<?php echo $row["MaHoaDon"]; ?>" onclick="openViewModal('<?php echo $row["MaHoaDon"]; ?>')">
                                    Xem
                                </button>
                                <button type="button" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-4 rounded-full shadow" onclick="openUpdateModal('<?php echo $row['MaHoaDon']; ?>', '<?php echo $row['NgayLap']; ?>', '<?php echo $row['TinhTrangDonHang']; ?>')">
                                    Cập nhật
                                </button>
                            </td>
                        </tr>
                <?php
                    }
                } else {
                    echo "<tr><td colspan='8' class='text-center py-6 text-gray-500'>Không có kết quả</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<?php
mysqli_close($conn);
?>
<?php include 'admin_footer.php' ?>
<div id="capnhathoadonModal" class="hidden fixed z-10 inset-0 overflow-y-auto">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form id="updateForm" action="update_tinhtrangdonhang.php" method="post">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                Cập nhật tình trạng đơn hàng
                            </h3>
                            <div class="mt-2">
                                <input type="hidden" name="MaHoaDon" id="MaHoaDon">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">
                                        Mã hóa đơn: <span id="modalMaHoaDon" class="font-bold"></span>
                                    </label>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">
                                        Ngày tạo: <span id="modalNgayTao" class="font-bold"></span>
                                    </label>
                                </div>
                                <div class="mt-2">
                                    <label for="TinhTrangDonHang" class="block text-sm font-medium text-gray-700">
                                        Tình trạng đơn hàng
                                    </label>
                                    <select name="TinhTrangDonHang" id="TinhTrangDonHang" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border border-spacing-2 border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                        <option value="Đang xử lý">Đang xử lý</option>
                                        <option value="Đang giao hàng">Đang giao hàng</option>
                                        <option value="Giao hàng thành công">Giao hàng thành công</option>
                                        <option value="Giao hàng thất bại">Giao hàng thất bại</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-500 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Cập nhật
                    </button>
                    <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm" onclick="closeModal('capnhathoadonModal')">
                        Hủy
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal -->
<div id="viewModal" class="fixed z-10 inset-0 overflow-y-auto hidden">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <span class="close absolute top-0 right-0 pt-4 pr-4 cursor-pointer text-xl">&times;</span>
                <h2 class="text-lg font-semibold mb-4">Hóa Đơn <span id="maHD"></span></h2>
                <p class="mb-4">Ngày tạo: <span id="ngaytao"></span></p>
                <table class="w-full mb-4">
                    <thead>
                        <tr>
                            <th class="px-4 py-2">Ảnh</th>
                            <th class="px-4 py-2">Sản Phẩm</th>
                            <th class="px-4 py-2">Số Lượng</th>
                            <th class="px-4 py-2">Thành Tiền</th>
                        </tr>
                    </thead>
                    <tbody id="list"></tbody>
                </table>
                <p>Tổng tiền: <span id="total"></span></p>
            </div>
        </div>
    </div>
</div>



<script>
    function openUpdateModal(maHoaDon, ngayTao, tinhTrangDonHang) {
        document.getElementById('MaHoaDon').value = maHoaDon;
        document.getElementById('modalMaHoaDon').innerText = maHoaDon;
        document.getElementById('modalNgayTao').innerText = ngayTao;
        document.getElementById('TinhTrangDonHang').value = tinhTrangDonHang;
        document.getElementById('capnhathoadonModal').classList.remove('hidden');
    }

    function closeModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
    }
    /////
    function openViewModal(maHoaDon) {
        fetch('view_hoadon.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    MaHoaDon: maHoaDon
                })
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('maHD').innerText = data.maHD || 'Không có dữ liệu';
                document.getElementById('ngaytao').innerText = data.ngaytao || 'Không có dữ liệu';

                const list = document.getElementById('list');
                list.innerHTML = data.list || '<tr><td colspan="4">Không có dữ liệu</td></tr>';

                document.getElementById('total').innerHTML = data.total || '0 VND';

                document.getElementById('viewModal').classList.remove('hidden');
            })
            .catch(error => console.error('Error:', error));
    }

    function closeModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
    }

    document.querySelector('.close').addEventListener('click', function() {
        closeModal('viewModal');
    });
</script>