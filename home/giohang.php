<?php
include("../home/logIn_required.php");
include("../config.php");

// Kiểm tra đăng nhập
if (!isset($_SESSION['MaKhachHang'])) {
    header("Location: ../authentication/dangnhap.php");
    exit();
}

include '../home/header.php';

// Xử lý yêu cầu xóa sản phẩm
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['masp'])) {
    $masp = $_GET['masp'];
    $makh = $_SESSION['MaKhachHang'];

    $deleteQuery = "DELETE FROM giohang WHERE MaSanPham = ? AND MaKhachHang = ?";
    $deleteStmt = mysqli_prepare($conn, $deleteQuery);

    if ($deleteStmt) {
        mysqli_stmt_bind_param($deleteStmt, "ss", $masp, $makh);
        if (mysqli_stmt_execute($deleteStmt)) {
            $rowsAffected = mysqli_stmt_affected_rows($deleteStmt);
            if ($rowsAffected > 0) {
                $_SESSION['SLGH'] -= $rowsAffected;
            }
        } else {
            // Xử lý lỗi một cách cẩn thận, có thể ghi nhật ký hoặc hiển thị thông báo lỗi cho người dùng
            echo "Xóa sản phẩm không thành công: " . mysqli_error($conn);
        }
    }

    mysqli_stmt_close($deleteStmt);

    if (isset($_SESSION["MaKhachHang"])) {
        echo '<script>document.getElementById("CartCount").innerHTML = ' . $_SESSION['SLGH'] . ';</script>';
    }
}

// Lấy dữ liệu giỏ hàng
$result = mysqli_query($conn, "SELECT giohang.*, sanpham.*, loaisanpham.*, giohang.SoLuong as SLGH, sanpham.GiaBan as DGSP, sanpham.SoLuong as SLSP
                            FROM giohang
                            JOIN sanpham ON giohang.MaSanPham = sanpham.MaSanPham 
                            JOIN loaisanpham ON sanpham.Maloaisanpham = loaisanpham.Maloaisanpham
                            WHERE giohang.MaKhachHang = '{$_SESSION['MaKhachHang']}'");

?>
<title>Giỏ Hàng</title>
<section class="section-content py-10">
    <div class="container mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <main class="md:col-span-2">
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <?php if (mysqli_num_rows($result) == 0) : ?>
                        <h3 class="text-muted">Không có sản phẩm trong giỏ hàng</h3>
                    <?php else : ?>
                        <table class="w-full table-auto">
                            <thead class="text-muted">
                                <tr class="text-sm text-left uppercase">
                                    <th scope="col" class="w-1/12"></th>
                                    <th scope="col" class="w-5/12">Sản phẩm</th>
                                    <th scope="col" class="w-2/12">Số lượng</th>
                                    <th scope="col" class="w-2/12">Giá</th>
                                    <th scope="col" class="w-2/12">Thành tiền</th>
                                    <th scope="col" class="text-right"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                                    <tr class="border-b border-gray-200">
                                        <td>
                                            <input type="checkbox" class="sanpham-checkbox" style="height: 20px" id="sanpham" data-idsp="<?php echo $row['MaSanPham'] ?>" onchange="calculateTotalPrice()">
                                        </td>
                                        <td class="text-sm">
                                            <div class="flex items-center space-x-4">
                                                <div class="w-16 h-16 overflow-hidden">
                                                    <a href="../home/xemchitiet.php?id=<?php echo $row['MaSanPham'] ?>">
                                                        <img src="<?php echo $row['Anh'] ?>" alt="Product image" class="object-cover w-full h-full">
                                                    </a>
                                                </div>
                                                <div>
                                                    <a href="#" class="text-gray-800 font-medium"><?php echo $row['TenSanPham'] ?></a>
                                                    <p class="text-gray-600 text-sm"> Loại Sản Phẩm: <?php echo $row['Tenloaisanpham'] ?></p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group input-group-sm">
                                                <button class="button-minus bg-gray-200 px-2" type="button" onclick="updateQuantity('<?php echo $row['MaSanPham'] ?>', -1)">-</button>
                                                <input id="quantity_<?php echo $row['MaSanPham'] ?>" type="text" class="form-input w-16 text-center" readonly="readonly" value="<?php echo $row['SLGH']; ?>" min="1" max="<?php echo $row['SLSP']; ?>">
                                                <button class="button-plus bg-gray-200 px-2" type="button" onclick="updateQuantity('<?php echo $row['MaSanPham'] ?>', 1)">+</button>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="text-gray-800">
                                                <?php echo formatCurrencyVND($row['DGSP']); ?>
                                            </div>
                                        </td>
                                        <td>
                                            <div id="subtotal_<?php echo $row['MaSanPham'] ?>" class="text-gray-800">
                                                <?php echo formatCurrencyVND($row['DGSP'] * $row['SLGH']); ?>
                                            </div>
                                        </td>

                                        <td class="text-right">
                                            <a href="giohang.php?action=delete&masp=<?php echo $row['MaSanPham'] ?>" class="btn-delete" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này khỏi giỏ hàng không?');">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                </svg>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                    <button onclick="checkAll()">Chọn tất cả</button>
                    <div class="pt-4 border-t border-gray-200">
                        <a href="#" id="sendSelectedProducts" class="btn-primary btn-sm float-right" onclick="sendSelectedProducts()">
                            <span class="inline-block align-middle">Thanh toán giỏ hàng</span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 inline-block align-middle ml-2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m12.75 15 3-3m0 0-3-3m3 3h-7.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                        </a>

                        <a href="../home/home.php" class="btn-light btn-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 inline-block align-middle mr-2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 9-3 3m0 0 3 3m-3-3h7.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                            <span class="inline-block align-middle">Tiếp tục xem hàng</span>
                        </a>
                    </div>
                </div>
            </main>
            <aside class="md:col-span-1">
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <dl class="flex justify-between">
                        <dt class="text-sm">Tổng tiền:</dt>
                        <dd class="text-right text-lg" id="TongTien">0</dd>
                    </dl>
                    <dl class="flex justify-between mt-2">
                        <dt class="text-sm">Thành tiền:</dt>
                        <dd class="text-right text-lg" id="ThanhTien"><strong>0</strong></dd>
                    </dl>
                </div>
            </aside>
        </div>
    </div>
</section>
<section class="section-name border-t border-gray-200 py-10">
    <form id="hiddenForm" action="../home/xacnhandonhang.php" method="POST">
        <input type="hidden" name="selectedProducts" id="hiddenSelectedProducts">
    </form>
</section>
<script>
    // Tăng số lượng sản phẩm
    function updateQuantity(productId, change) {
        var quantityInput = document.getElementById('quantity_' + productId);
        var newQuantity = parseInt(quantityInput.value) + change;
        var maxQuantity = parseInt(quantityInput.getAttribute('max'));

        // Kiểm tra giới hạn số lượng
        if (newQuantity < 1) {
            newQuantity = 1;
        } else if (newQuantity > maxQuantity) {
            newQuantity = maxQuantity;
        }

        quantityInput.value = newQuantity;

        // Gửi dữ liệu lên server thông qua Ajax để cập nhật số lượng
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "capnhatsoluong.php", true); // Đã sửa lại tên file thành update_quantity.php
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var response = JSON.parse(xhr.responseText);
                if (response.status === "success") {
                    // Hiển thị thông báo thành công
                    alert(response.message);

                    // Cập nhật tổng thành tiền
                    var subtotalElement = document.getElementById('subtotal_' + productId);
                    var newSubtotal = response.newSubtotal; // Giả sử server trả về tổng thành tiền mới
                    subtotalElement.innerHTML = newSubtotal;
                } else {
                    // Hiển thị thông báo lỗi
                    alert(response.message);
                }
            }
        };
        xhr.send("productId=" + productId + "&quantity=" + newQuantity);
    }

    // hàm hiển thị thông báo cạnh viền

    $(function() {
        // Lấy các phần tử DOM cần thiết
        var checkboxes = document.querySelectorAll('[id="sanpham"]');
        var checkAllCheckbox = document.getElementById('check-all');
        // Thiết lập sự kiện cho checkbox check-all
        $("#check-all").click(function() {
            for (var i = 0; i < checkboxes.length; i++) {
                checkboxes[i].checked = this.checked;
            }
            calculateTotalPrice();
            calculateSelectedCount();
        });
        // Thiết lập sự kiện cho các checkbox sản phẩm
        checkboxes.forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {

                calculateTotalPrice();
                calculateSelectedCount();
                // Kiểm tra nếu tất cả các checkbox sản phẩm đều được chọn
                var allChecked = Array.from(checkboxes).every(function(checkbox) {
                    return checkbox.checked;
                });
                // Cập nhật trạng thái của checkbox "Tất cả"
                checkAllCheckbox.checked = allChecked;
            });
        });
    });

    function sendSelectedProducts() {
        var checkboxes = document.querySelectorAll('.sanpham-checkbox:checked');
        var selectedProducts = [];

        // Kiểm tra xem có checkbox nào được chọn không
        if (checkboxes.length === 0) {
            alert("Vui lòng chọn sản phẩm trong giỏ hàng để thanh toán");
            return; // Dừng hàm nếu không có checkbox nào được chọn
        }

        checkboxes.forEach(function(checkbox) {
            var masp = checkbox.getAttribute('data-idsp'); // Thay đổi từ dataset sang getAttribute
            var soluong = parseInt(document.getElementById('quantity_' + masp).value);
            var selectedProduct = {
                'MaSanPham': masp, // Loại bỏ khoảng trắng trong key
                'SoLuong': soluong
            };
            selectedProducts.push(selectedProduct);
        });

        // Sửa đổi ID của input hidden và action của form
        document.getElementById('hiddenSelectedProducts').value = JSON.stringify(selectedProducts);
        document.getElementById('hiddenForm').submit();
    }

    function calculateSelectedCount() {
        var checkboxes = document.querySelectorAll('.sanpham-checkbox');
        var countElement = document.querySelector('.countslsp');
        var countElement1 = document.querySelector('.countslsp1');
        var selectedCount = 0;

        checkboxes.forEach(function(checkbox) {
            if (checkbox.checked) {
                selectedCount++;
            }
        });

        countElement.innerText = selectedCount;
        countElement1.innerText = selectedCount;
    }
    function checkAll() {
    var checkboxes = document.querySelectorAll('.sanpham-checkbox');
    checkboxes.forEach(function(checkbox) {
        checkbox.checked = true;
    });

    // Gọi lại các hàm tính toán
    calculateSelectedCount();
    calculateTotalPrice();
}

function calculateTotalPrice() {
    var total = 0;
    var checkboxes = document.querySelectorAll('.sanpham-checkbox');
    checkboxes.forEach(function(checkbox) {
        if (checkbox.checked) {
            var idsp = checkbox.getAttribute('data-idsp');
            var subtotalElement = document.getElementById('subtotal_' + idsp);

            var subtotalPrice = parseInt(subtotalElement.innerText.replace(/\D/g, ''));
            total += subtotalPrice;

        }
    });

    var sumElement = document.getElementById('TongTien');
    sumElement.innerText = formatCurrency(total);
    var finalSumElement = document.getElementById('ThanhTien');
    finalSumElement.innerText = formatCurrency(total);
}

function formatCurrency(number) {
    return number.toLocaleString("vi-VN", {
        style: "currency",
        currency: "VND"
    });
}    
</script>
<?php include '../home/footer.php'; ?>