<title>Xu Hướng</title>
<?php include 'header.php' ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sneaker Trending</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">

    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-6 text-center text-gray-800">🔥 Sneaker Trending</h1>

        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
            <?php
            $url = "https://api.sneakersapi.dev/product/trending";
            $ch = curl_init($url);

            // Thiết lập cURL để kiểm tra lỗi
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Để xử lý các chuyển hướng nếu có
            $response = curl_exec($ch);

            // Kiểm tra lỗi cURL
            if(curl_errno($ch)) {
                echo "<p class='text-red-500 text-center'>Lỗi cURL: " . curl_error($ch) . "</p>";
            }

            // Kiểm tra mã trạng thái HTTP
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if ($http_code != 200) {
                echo "<p class='text-red-500 text-center'>Lỗi HTTP: Mã lỗi $http_code</p>";
            }

            curl_close($ch);

            // Kiểm tra xem dữ liệu có hợp lệ không
            $data = json_decode($response, true);
            if (isset($data['data']) && is_array($data['data']) && !empty($data['data'])) {
                foreach ($data['data'] as $item) {
                    $title = $item['title'] ?? 'No name';
                    $image = $item['media']['imageUrl'] ?? 'https://via.placeholder.com/300';
                    $price = $item['retailPrice'] ?? 'N/A';
                    $url = $item['url'] ?? '#';

                    echo "
                    <div class='bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-lg transition'>
                        <img src='$image' alt='$title' class='w-full h-60 object-cover'>
                        <div class='p-4'>
                            <h2 class='text-lg font-semibold text-gray-800 mb-2'>$title</h2>
                            <p class='text-gray-600 mb-4'>Giá: <strong>" . ($price !== 'N/A' ? "\$$price" : "Chưa cập nhật") . "</strong></p>
                            <a href='$url' target='_blank' class='inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700'>Xem chi tiết</a>
                        </div>
                    </div>
                    ";
                }
            } else {
                echo "<p class='text-center text-red-500 col-span-full'>Không lấy được dữ liệu từ API hoặc dữ liệu trả về rỗng.</p>";
            }
            ?>
        </div>
    </div>

</body>
</html>

<?php include 'footer.php' ?>