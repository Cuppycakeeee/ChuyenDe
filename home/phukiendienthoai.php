<?php include '../home/header.php'; ?>
<title>Phụ Kiện Điện Thoại</title>
<section class="pt-10">
    <div class="relative pb-6">
        <img src="uploads/bgphukien.png" class="w-full h-full object-cover">
        <div class="absolute inset-0 flex items-start justify-start p-4 md:absolute md:pt-24 md:pl-32 ">
          <p class="md:text-5xl font-bold sm:text-xl">Phụ Kiện Điện Thoại </p>
        </div>
    </div>
    <div class="flex flex-wrap justify-center">
        <?php
        $query = "SELECT * FROM sanpham WHERE Maloaisanpham = 4";
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $productTitle = $row['TenSanPham'];
                $productPrice = $row['GiaBan'];
                $productImage = $row['Anh'];
                $productImage2 = $row['Anh2'];
                $productId = $row['MaSanPham'];

                // Cắt ngắn đoạn văn bản nếu quá dài
                $shortTitle = strlen($productTitle) > 30 ? wordwrap($productTitle, 30, "<br>", true) : $productTitle;
        ?>
        <div class="md:flex md:flex-row md:justify-center w-full md:w-1/5 pb-10 transition duration-300 transform hover:scale-110">
            <div class="max-w-sm mx-auto bg-white rounded-lg overflow-hidden shadow-lg h-full">
                <div class="text-center items-center">
                    <a href="xemchitiet.php?id=<?= $productId ?>" class="hover-trigger relative block">
                        <img src="<?= $productImage ?>" class="object-contain w-full h-52" alt="<?= $productTitle ?>">
                        <div class="absolute inset-0 opacity-0 hover:opacity-100 transition-opacity duration-300">
                            <img src="<?= $productImage2 ?>" class="object-contain w-full h-52" alt="<?= $productTitle ?>">
                        </div>
                    </a>
                </div>
                <div class="p-4">
                    <!-- Sử dụng $shortTitle thay vì $productTitle để tránh dòng chữ quá dài -->
                    <h3 class="text-sm text-center mt-2" style="height: 40px; overflow: hidden;"><a href="xemchitiet.php?id=<?= $productId ?>"><?= $shortTitle ?></a></h3>
                    <p class="text-center font-bold mt-2"><?= number_format($productPrice, 0, '.', ',') ?> đ</p>
                    <div class="flex justify-center mt-4">
                        <a href="xemchitiet.php?id=<?= $productId ?>" class="inline-block px-4 py-2 bg-gray-900 hover:bg-yellow-600 text-white rounded shadow">Mua Ngay</a>
                    </div>
                </div>
            </div>
        </div>
        <?php
            }
        } else {
            echo "Không tìm thấy sản phẩm.";
        }
        ?>
    </div>
</section>
<?php include '../home/footer.php'; ?>
