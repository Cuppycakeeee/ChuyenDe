<?php
header('Content-Type: application/json');

// Lấy dữ liệu từ yêu cầu POST
$request = json_decode(file_get_contents('php://input'), true);
$message = strtolower($request['message'] ?? '');

// Xử lý logic trả lời của chatbot
$response = '';

if (strpos($message, 'giày') !== false) {
    $response = 'Bạn có thể xem các sản phẩm giày tại đây: <a href="giay.php">Giày</a>';
} elseif (strpos($message, 'giày thể thao') !== false) {
    $response = 'Bạn có thể xem các sản phẩm giày thể thao tại đây: <a href="giaythethao.php">Giày Thể Thao</a>';
} elseif (strpos($message, 'phụ kiện thời trang') !== false) {
    $response = 'Bạn có thể xem các phụ kiện thời trang tại đây: <a href="phukienthoitrang.php">Phụ Kiện Thời Trang</a>';
} elseif (strpos($message, 'phụ kiện điện thoại') !== false) {
    $response = 'Bạn có thể xem các phụ kiện điện thoại tại đây: <a href="phukiendienthoai.php">Phụ Kiện Điện Thoại</a>';
} elseif (strpos($message, 'túi') !== false) {
    $response = 'Bạn có thể xem các sản phẩm túi tại đây: <a href="tui.php">Túi</a>';
} elseif (strpos($message, 'faq') !== false) {
    $response = 'Bạn có thể xem thông tin về faq tại đây: <a href="#">faq</a>';
} else {
    $response = 'Xin lỗi, tôi chưa hiểu ý bạn. Bạn có thể nói rõ hơn không?';
}

// Trả về phản hồi dưới dạng JSON
echo json_encode(['reply' => $response]);
?>