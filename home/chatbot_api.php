<?php
header('Content-Type: application/json');

// Kết nối CSDL
$conn = mysqli_connect('localhost', 'root', '', 'chuyende'); // Đổi 'ten_csdl' thành tên CSDL của bạn
if (!$conn) {
    echo json_encode(['reply' => 'Không thể kết nối cơ sở dữ liệu!']);
    exit;
}

// Lấy dữ liệu từ yêu cầu POST
$request = json_decode(file_get_contents('php://input'), true);
$message = strtolower($request['message'] ?? '');
$response = '';

// Nhận diện nhiều dạng câu hỏi
if (preg_match('/^(chào|xin chào|hello|hi|hey|alo|bắt đầu)/', $message)) {
    $response = 'Chào bạn! Tôi có thể giúp gì cho bạn? Bạn có thể hỏi về sản phẩm, giá, số lượng, v.v.';
} elseif (preg_match('/(có bao nhiêu|số lượng|tổng sản phẩm)/', $message)) {
    $sql = "SELECT COUNT(*) as total FROM sanpham";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $response = "Hiện tại có " . $row['total'] . " sản phẩm trong cửa hàng.";
} elseif (preg_match('/(liệt kê|danh sách|kể tên).*sản phẩm/', $message)) {
    $sql = "SELECT TenSanPham, Gia, HinhAnh FROM sanpham LIMIT 5";
    $result = mysqli_query($conn, $sql);
    $items = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $items[] = '
            <div style="display:flex;align-items:center;margin-bottom:10px;">
                <img src="' . htmlspecialchars($row['HinhAnh']) . '" alt="' . htmlspecialchars($row['TenSanPham']) . '" style="width:50px;height:50px;object-fit:cover;border-radius:8px;margin-right:10px;">
                <div>
                    <div style="font-weight:bold;">' . htmlspecialchars($row['TenSanPham']) . '</div>
                    <div style="color:#eab308;">' . number_format($row['Gia']) . 'đ</div>
                </div>
            </div>
        ';
    }
    if ($items) {
        $response = "Một số sản phẩm nổi bật:<br>" . implode('', $items);
    } else {
        $response = "Không tìm thấy sản phẩm nào.";
    }
} elseif (preg_match('/giày thể thao/', $message)) {
    $response = 'Bạn có thể xem các sản phẩm giày thể thao tại đây: <a href="giaythethao.php">Giày Thể Thao</a>';
} elseif (preg_match('/giày/', $message)) {
    $response = 'Bạn có thể xem các sản phẩm giày tại đây: <a href="giay.php">Giày</a>';
} elseif (preg_match('/phụ kiện thời trang/', $message)) {
    $response = 'Bạn có thể xem các phụ kiện thời trang tại đây: <a href="phukienthoitrang.php">Phụ Kiện Thời Trang</a>';
} elseif (preg_match('/phụ kiện điện thoại/', $message)) {
    $response = 'Bạn có thể xem các phụ kiện điện thoại tại đây: <a href="phukiendienthoai.php">Phụ Kiện Điện Thoại</a>';
} elseif (preg_match('/túi/', $message)) {
    $response = 'Bạn có thể xem các sản phẩm túi tại đây: <a href="tui.php">Túi</a>';
} elseif (preg_match('/faq|hỏi đáp|trợ giúp/', $message)) {
    $response = 'Bạn có thể xem thông tin về faq tại đây: <a href="#">faq</a>';
} elseif (preg_match('/sản phẩm.*(giá|bao nhiêu)/', $message, $matches)) {
    // Trả lời sản phẩm theo giá (ví dụ: "sản phẩm giá dưới 500k")
    if (preg_match('/dưới\s*(\d+)/', $message, $m)) {
        $gia = intval($m[1]) * 1000;
        $sql = "SELECT TenSanPham, Gia FROM sanpham WHERE Gia < $gia LIMIT 5";
        $result = mysqli_query($conn, $sql);
        $items = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $items[] = $row['TenSanPham'] . " (" . number_format($row['Gia']) . "đ)";
        }
        if ($items) {
            $response = "Các sản phẩm giá dưới " . number_format($gia) . "đ: " . implode(', ', $items);
        } else {
            $response = "Không tìm thấy sản phẩm nào phù hợp.";
        }
    } else {
        $response = "Bạn muốn tìm sản phẩm theo mức giá nào? (ví dụ: sản phẩm giá dưới 500k)";
    }
} else {
    $response = 'Xin lỗi, tôi chưa hiểu ý bạn. Bạn có thể hỏi về số lượng, tên sản phẩm, hoặc sản phẩm theo giá. Ví dụ: "Có bao nhiêu sản phẩm?", "Liệt kê sản phẩm", "Sản phẩm giá dưới 500k".';
}

// Trả về phản hồi dưới dạng JSON
echo json_encode(['reply' => $response]);
?>