<title>Quản Lý Hoá Đơn</title>
<?php
include '../config.php';
include 'admin_header.php';
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
    GROUP BY 
        hoadon.MaHoaDon
";

$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Lỗi truy vấn: " . mysqli_error($conn));
}

if (mysqli_num_rows($result) > 0) {
?>
    <div class="p-4 sm:ml-60">
        <table class="table-auto border-collapse border">
            <h3 class="px-6 py-3 text-center text-xl font-medium text-gray-500 uppercase tracking-wider">Quản Lý Hóa Đơn</h3>
            <thead>
                <tr class="bg-blue-300">
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">mã hoá đơn</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ngày tạo</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">tên khách hàng</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">số điện thoại</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">địa chỉ</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">tình trạng đơn hàng</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">tổng tiền</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">chức năng</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                ?>
                    <tr class="bg-white hover:bg-gray-100 transition duration-300">
                        <td class="border px-6 py-3"><?php echo $row["MaHoaDon"]; ?></td>
                        <td class="border px-6 py-3"><?php echo $row["NgayLap"]; ?></td>
                        <td class="border px-6 py-3"><?php echo $row["TenKhachHang"]; ?></td>
                        <td class="border px-6 py-3"><?php echo $row["SoDienThoai"]; ?></td>
                        <td class="border px-6 py-3"><?php echo $row["DiaChi"]; ?></td>
                        <td class="border px-6 py-3"><?php echo $row["TinhTrangDonHang"]; ?></td>
                        <td class="border px-6 py-3"><?php echo number_format($row["TongTien"], 0, ',', '.') . ' VND'; ?></td>
                        <td class="flex flex-col">
                            <button type="button" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-full" data-id="<?php echo $row["MaHoaDon"]; ?>" onclick="openViewModal('<?php echo $row["MaHoaDon"]; ?>')">
                                Xem
                            </button>
                            <button type="button" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full" onclick="openUpdateModal('<?php echo $row['MaHoaDon']; ?>', '<?php echo $row['NgayLap']; ?>', '<?php echo $row['TinhTrangDonHang']; ?>')">
                                Cập nhật
                            </button>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>

    </div>
<?php
} else {
    echo "Không có kết quả";
}

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