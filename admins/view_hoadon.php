<?php
require("../config.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $id = $input['MaHoaDon'];
    $output = array('list' => '', 'maHD' => '', 'ngaytao' => '', 'total' => '');

    $sql = "SELECT
                h.NgayLap AS NgayLap,
                c.MaHoaDon AS MaHoaDon,
                p.TenSanPham AS TenSanPham,
                p.Anh AS Anh,
                c.GiaBan AS GiaBan,
                c.SoLuong as SoLuong,
                (c.GiaBan * c.SoLuong) AS 'TONGCONG'
            FROM
                chitiethoadon c
                JOIN
                hoadon h ON c.MaHoaDon = h.MaHoaDon
                JOIN
                sanpham p ON c.MaSanPham = p.MaSanPham
            WHERE c.MaHoaDon = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $id);
    $stmt->execute();
    
    $result = $stmt->get_result();
    $total = 0;
    
    while ($row = $result->fetch_assoc()) {
        if (!$output['maHD']) {
            $output['maHD'] = $row['MaHoaDon'];
            $output['ngaytao'] = date('d \t\h\á\n\g m \n\ă\m Y', strtotime($row['NgayLap']));
        }
        $subtotal = $row['TONGCONG'];
        $total += $subtotal;
        $output['list'] .= "
            <tr class='prepend_items'>
                <td class='border px-4 py-2'><img src='" . $row['Anh'] . "' class='w-16 h-16 object-cover' alt='Product Image'></td>
                <td class='border px-4 py-2'>" . $row['TenSanPham'] . "</td>
                <td class='border px-4 py-2'>" . $row['SoLuong'] . "</td>
                <td class='border px-4 py-2'>" . number_format($subtotal) . " VND</td>
            </tr>
        ";
    }
    
    $output['total'] = '<b>' . number_format($total, 0, ',', '.') . ' VND<b>';
    
    $stmt->close();
    mysqli_close($conn);
    
    echo json_encode($output);
}
?>
