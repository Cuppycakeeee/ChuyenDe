<title>Chi tiết sản phẩm</title>
<?php
include 'header.php';
$id = "";
if (isset($_GET["id"])) {
    $id = $_GET["id"];
}
$result = mysqli_query(
    $conn,
    "SELECT * FROM sanpham 
    JOIN nhacungcap ON sanpham.MaNhaCungCap = nhacungcap.MaNhaCungCap
    JOIN loaisanpham ON sanpham.Maloaisanpham = loaisanpham.Maloaisanpham
    WHERE MaSanPham = '$id'
    LIMIT 1"
);
?>

<?php if (mysqli_num_rows($result) <> 0) : ?>
    <?php while ($row = mysqli_fetch_assoc($result)) : ?>
        <section class="bg-white py-8">
            <div class="container mx-auto">
                <div class="flex flex-wrap">
                    <div class="w-full md:w-1/2 px-4 mb-8">
                        <div class="">
                            <img id="mainImage" class=" w-full h-auto" src="<?php echo $row['Anh']; ?>" alt="Product image">
                            <div class="flex justify-center mt-4">
                                <img class="w-1/4 pr-4" src="<?php echo $row['Anh']; ?>" alt="Thumbnail 1" onclick="changeImage('<?php echo $row['Anh']; ?>')">
                                <img class="w-1/4 pr-4" src="<?php echo $row['Anh2']; ?>" alt="Thumbnail 2" onclick="changeImage('<?php echo $row['Anh2']; ?>')">
                                <?php if (!empty($row['Anh3'])) : ?>
                                    <img class="w-1/4 pr-4" src="<?php echo $row['Anh3']; ?>" alt="Thumbnail 3" onclick="changeImage('<?php echo $row['Anh3']; ?>')">
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="w-full md:w-1/2 px-4 pl-20">
                        <h2 class="text-3xl font-semibold mb-4"><?php echo $row['TenSanPham']; ?></h2>
                        <dl>
                            <div class="flex mb-2">
                                <dt class="w-1/3">Loại Sản Phẩm</dt>
                                <dd class="w-2/3"><?php echo $row['Tenloaisanpham']; ?></dd>
                            </div>
                            <div class="flex mb-2">
                                <dt class="w-1/3">Giá Bán</dt>
                                <dd class="w-2/3"><?php echo number_format($row['GiaBan'], 0, '.', ','); ?> đ</dd>
                            </div>
                            <div class="flex mb-2">
                                <dt class="w-1/3">Có sẵn</dt>
                                <dd class="w-2/3">Còn <?php echo $row['SoLuong']; ?> sản phẩm</dd>
                            </div>
                        </dl>
                        <div class="flex items-center mt-4">
                            <button id="button-minus" class="bg-black hover:bg-yellow-600 text-white px-3 py-1 rounded-full mr-2">-</button>
                            <input id="ipQuantity" type="text" class="w-16 text-center border border-black" value="1" readonly="readonly">
                            <button id="button-plus" class="bg-black hover:bg-yellow-600 text-white px-3 py-1 rounded-full ml-2">+</button>
                            <script>
                                var inputQuantity = document.getElementById("ipQuantity");
                                var buttonPlus = document.getElementById("button-plus");
                                var minValue = 1;
                                var maxValue = <?php echo $row['SoLuong']; ?> - 1;

                                buttonPlus.addEventListener("click", function() {
                                    var value = parseInt(inputQuantity.value);

                                    if (value < maxValue) {
                                        inputQuantity.value = value;
                                    }

                                    checkValue();
                                });

                                function checkValue() {
                                    var value = parseInt(inputQuantity.value);

                                    if (isNaN(value) || value <= maxValue) {
                                        buttonPlus.disabled = false;
                                    } else if (value > maxValue) {
                                        buttonPlus.disabled = false;
                                        inputQuantity.value = maxValue;
                                    } else {
                                        buttonPlus.disabled = true;
                                    }
                                }

                                checkValue();
                            </script>

                        </div>
                        <div class="mt-4">
                            <button id="addtocart" class="bg-gray-900 hover:bg-yellow-600 text-white px-4 py-2 rounded-md " onclick="addToCart('<?php echo $id; ?>')">
                                <span class="ml-2">Thêm vào giỏ hàng</span>

                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="bg-yellow-200 py-8">
            <div class="container mx-auto">
                <div class="text-3xl font-semibold mb-4">Mô tả sản phẩm</div>
                <p>Nhà Cung Cấp: <?php echo $row['TenNhaCungCap']; ?></p>
                <p><?php echo $row['MoTa']; ?></p>
            </div>
        </section>
    <?php endwhile; ?>
<?php endif; ?>
<script>
    function changeImage(imageSrc) {
        document.getElementById("mainImage").src = imageSrc;
    }
</script>
<script>
    // Lấy đối tượng input và button
    var input = document.getElementById('ipQuantity');
    var buttonMinus = document.getElementById('button-minus');
    var buttonPlus = document.getElementById('button-plus');

    // Xử lý sự kiện khi button "minus" được bấm
    buttonMinus.addEventListener('click', function() {
        var value = parseInt(input.value);
        if (value > 1) {
            input.value = value - 1;
        } else {
            input.value = 1;
        }
    });

    // Xử lý sự kiện khi button "plus" được bấm
    buttonPlus.addEventListener('click', function() {
        var value = parseInt(input.value);
        input.value = value + 1;
    });

    // Xử lý sự kiện khi giá trị trong input thay đổi
    input.addEventListener('change', function() {
        var value = parseInt(input.value);
        if (value < 1 || isNaN(value)) {
            input.value = 1;
        }
    });

    function addToCart(productId) {
    // Lấy số lượng từ input
    var quantity = document.getElementById('ipQuantity').value;

    // Send Ajax request to add product to cart
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'themvaogiohang.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                if (response.success) {
                    // Update cart quantity
                    document.getElementById('CartCount').textContent = response.slgh;
                    alert("Đã thêm sản phẩm vào giỏ hàng thành công!");
                    location.reload();
                } else {
                    alert("Không thể thêm vào giỏ hàng!");
                }
            } else {
                alert("Có lỗi xảy ra khi thêm vào giỏ hàng!");
            }
        }
    };
    xhr.send('MaSanPham=' + encodeURIComponent(productId) + '&SoLuong=' + encodeURIComponent(quantity));
}
    
</script>

<?php include 'footer.php' ?>