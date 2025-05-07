<?php
include "config.php";
include 'admin_header.php';
?>

<title>Home</title>
<section class="p-4 ml-60">
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 justify-center">
        <!-- small box -->
        <div class="bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 rounded-lg shadow-lg p-4 transition duration-300 transform hover:scale-110 ml-0 sm:ml-4">
            <div class="text-white">
                <?php
                $sql_countHD = "SELECT COUNT(*) FROM hoadon";
                $result = mysqli_query($conn, $sql_countHD);
                $row = mysqli_fetch_row($result);
                ?>
                <div class="flex items-center gap-[150px] justify-between w-full">
                    <div class="grid grid-cols-1">
                        <h3 class="text-4xl font-bold"><?php echo $row[0] ?></h3>
                        <p class="text-sm">Tổng đơn đặt hàng</p>
                    </div>

                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-14 h-14 ">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                    </svg>
                </div>
            </div>
            <a href="../admins/quanlyhoadon.php" class="text-white hover:text-black mt-4 block font-semibold"> Xem chi tiết <i class="fas fa-arrow-circle-right ml-2"></i></a>
        </div>
        <div class="bg-gradient-to-r from-pink-500 via-orange-500 to-yellow-500 rounded-lg shadow-lg p-4 transition duration-300 transform hover:scale-110 ml-0 sm:ml-4">
            <div class="text-white">
                <?php
                $sql_countHD = "SELECT COUNT(*) FROM sanpham";
                $result = mysqli_query($conn, $sql_countHD);
                $row = mysqli_fetch_row($result);
                ?>
                <div class="flex items-center gap-[150px] justify-between w-full">
                    <div class="grid grid-cols-1">
                        <h3 class="text-4xl font-bold"><?php echo $row[0] ?></h3>
                        <p class="text-sm">Số Lượng Sản Phẩm</p>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-14 h-14">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                    </svg>
                </div>
            </div>
            <a href="../admins/sanpham.php" class="text-white hover:text-black mt-4 block font-semibold"> Xem chi tiết <i class="fas fa-arrow-circle-right ml-2"></i></a>
        </div>
        <div class="bg-gradient-to-r from-yellow-500 via-red-500 to-purple-500 rounded-lg shadow-lg p-4 transition duration-300 transform hover:scale-110 ml-0 sm:ml-4">
            <div class="text-white">
                <?php
                $sql_countHD = "SELECT COUNT(*) FROM taikhoankhachhang";
                $result = mysqli_query($conn, $sql_countHD);
                $row = mysqli_fetch_row($result);
                ?>
                <div class="flex items-center gap-[150px] justify-between w-full">
                    <div class="grid grid-cols-1">
                        <h3 class="text-4xl font-bold"><?php echo $row[0] ?></h3>
                        <p class="text-sm">Số Lượng Khách Hàng</p>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-14 h-14">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                    </svg>
                </div>
            </div>
            <a href="../admins/taikhoan_khachhang.php" class="text-white hover:text-black mt-4 block font-semibold"> Xem chi tiết <i class="fas fa-arrow-circle-right ml-2"></i></a>
        </div>
    </div>
</section>
<section class="p-4 ml-60">
    <?php
    $months = array();
    $sales = array();
    $productSales = array();
    $totalRevenue = 0;
    $totalProductsSold = 0;

    // Initialize arrays for each month
    for ($m = 1; $m <= 12; $m++) {
        $sales[$m] = 0;
        $productSales[$m] = 0;
        $months[] = date('M', mktime(0, 0, 0, $m, 1));
    }

    // Ensure the year parameter is valid
    $selectedYear = isset($_GET['year']) ? intval($_GET['year']) : date('Y');

    // Fetch data for the selected year
    $stmt = $conn->prepare("
    SELECT 
        MONTH(hoadon.NgayLap) AS month, 
        SUM(chitiethoadon.GiaBan * chitiethoadon.SoLuong) AS total, 
        SUM(chitiethoadon.SoLuong) AS totalProducts
    FROM 
        chitiethoadon
    JOIN 
        hoadon ON hoadon.MaHoaDon = chitiethoadon.MaHoaDon
    WHERE 
        YEAR(hoadon.NgayLap) = ? 
        AND hoadon.TinhTrangDonHang = 'Giao hàng thành công'
    GROUP BY 
        MONTH(hoadon.NgayLap)
");
    $stmt->bind_param("i", $selectedYear);  // Sử dụng "i" để liên kết số nguyên
    $stmt->execute();
    $result = $stmt->get_result();

    // Điền mảng dữ liệu
    while ($srow = $result->fetch_assoc()) {
        $sales[$srow['month']] = round($srow['total'], 2);
        $productSales[$srow['month']] = $srow['totalProducts'];
        $totalRevenue += $srow['total'];
        $totalProductsSold += $srow['totalProducts'];
    }

    $stmt->close();

    $months = json_encode($months);
    $sales = json_encode(array_values($sales));
    $productSales = json_encode(array_values($productSales));
    ?>

    <canvas id="barChart" height="100"></canvas>
    <div id="legend"></div>
    <div class="flex flex-col text-center mt-2">
        <b>Tổng doanh thu: <?php echo number_format($totalRevenue); ?> VNĐ</b>
        <br>
        <b>Tổng số lượng sản phẩm đã bán: <?php echo number_format($totalProductsSold); ?> sản phẩm</b>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(function() {
        var barChartCanvas = $('#barChart').get(0).getContext('2d');
        var barChartData = {
            labels: <?php echo $months; ?>,
            datasets: [{
                    label: 'Doanh thu',
                    backgroundColor: 'rgba(153, 102, 255, 0.9)',
                    borderColor: 'rgba(60,141,188,0.8)',
                    yAxisID: 'y-axis-revenue',
                    data: <?php echo $sales; ?>
                },
                {
                    label: 'Số lượng sản phẩm đã bán',
                    backgroundColor: 'rgba(75, 192, 192, 0.9)',
                    borderColor: 'rgba(75, 192, 192, 0.8)',
                    yAxisID: 'y-axis-products',
                    data: <?php echo $productSales; ?>
                }
            ]
        };

        var barChartOptions = {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
                yAxes: [{
                        id: 'y-axis-revenue',
                        position: 'left',
                        ticks: {
                            beginAtZero: true,
                            callback: function(value) {
                                return value.toLocaleString();
                            }
                        },
                        scaleLabel: {
                            display: true,
                            labelString: 'Doanh thu (VNĐ)'
                        }
                    },
                    {
                        id: 'y-axis-products',
                        position: 'right',
                        ticks: {
                            beginAtZero: true,
                            callback: function(value) {
                                return value.toLocaleString();
                            }
                        },
                        scaleLabel: {
                            display: true,
                            labelString: 'Số lượng sản phẩm'
                        },
                        gridLines: {
                            display: false
                        }
                    }
                ],
                xAxes: [{
                    scaleLabel: {
                        display: true,
                        labelString: 'Tháng'
                    }
                }]
            },
            tooltips: {
                callbacks: {
                    label: function(tooltipItem, data) {
                        return tooltipItem.raw.toLocaleString();
                    }
                }
            }
        };

        var myChart = new Chart(barChartCanvas, {
            type: 'bar',
            data: barChartData,
            options: barChartOptions
        });

        document.getElementById('legend').innerHTML = myChart.generateLegend();
    });
</script>
<script>
    $(function() {
        function changeYearAndSave(value) {
            window.location.href = 'Index.php?year=' + value;
            localStorage.setItem('selectedYear', value);
        }

        $('#select_year').change(function() {
            changeYearAndSave($(this).val());
        });

        var selectedYear = localStorage.getItem('selectedYear');
        if (selectedYear) {
            $('#select_year').val(selectedYear);
        } else {
            var urlParams = new URLSearchParams(window.location.search);
            var yearFromURL = urlParams.get('year');

            if (yearFromURL) {
                $('#select_year').val(yearFromURL);
            } else {
                $('#select_year').val(new Date().getFullYear());
            }
        }
    });
</script>

<?php include 'admin_footer.php' ?>