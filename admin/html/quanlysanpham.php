<!DOCTYPE html>
<html lang="en">
<?php
// Thông tin kết nối database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mydp";

// Kết nối đến MySQL
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if (!$conn) {
    die("Kết nối thất bại: " . mysqli_connect_error());
}

// Lấy dữ liệu tìm kiếm và ngày tháng
$raw_search = isset($_GET['search']) ? trim($_GET['search']) : '';
$start = isset($_GET['start']) ? $_GET['start'] : '';
$end = isset($_GET['end']) ? $_GET['end'] : '';

$limit = 5;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
if ($page < 1) $page = 1;
$offset = ($page - 1) * $limit;

// Xây dựng điều kiện WHERE
$where = "1"; // mặc định luôn đúng

$params = []; // tham số bind
$types = "";  // chuỗi loại dữ liệu cho bind_param

if (!empty($raw_search)) {
    $where .= " AND name LIKE ?";
    $params[] = "%$raw_search%";
    $types .= "s";
}

if (!empty($start) && !empty($end)) {
    $where .= " AND updated_at BETWEEN ? AND ?";
    $params[] = $start . " 00:00:00";
    $params[] = $end . " 23:59:59";
    $types .= "ss";
}

// Đếm tổng số sản phẩm
$sql_count = "SELECT COUNT(*) AS total FROM product WHERE $where";
$stmt_total = $conn->prepare($sql_count);
if (!empty($params)) {
    $stmt_total->bind_param($types, ...$params);
}
$stmt_total->execute();
$total_row = $stmt_total->get_result()->fetch_assoc();
$total_users = $total_row['total'];
$stmt_total->close();

// Lấy dữ liệu sản phẩm
$sql_data = "SELECT * FROM product WHERE $where LIMIT ? OFFSET ?";
$stmt = $conn->prepare($sql_data);

// Thêm limit và offset vào params
$params_with_limit = $params;
$params_with_limit[] = $limit;
$params_with_limit[] = $offset;
$types_with_limit = $types . "ii";

$stmt->bind_param($types_with_limit, ...$params_with_limit);

$stmt->execute();
$result = $stmt->get_result();

$total_pages = ceil($total_users / $limit);
?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - MMB - Shop Bán Đồ Cầu Lông</title>
    <link href='../img/logo.png' rel='icon' type='image/x-icon' />
    <!-- ======= Styles ====== -->
    <link rel="stylesheet" href="../css/indexadmin.css">
    <link rel="stylesheet" href="../css/quanlysanpham.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<style>
.pagination {
    display: flex;
    justify-content: center;
    align-items: center;
    margin: 30px 0;
    font-family: Arial, sans-serif;
    font-size: 13px; /* giảm cỡ chữ */
}

.pagination a, .pagination .current {
    margin: 0 5px;
    padding: 5px 10px; /* giảm padding cho gọn */
    text-decoration: none;
    border: 1px solid #ccc;
    border-radius: 4px;
    color: #333;
    background-color: #f9f9f9;
    transition: background-color 0.3s, color 0.3s;
}

.pagination a:hover {
    background-color:rgb(103, 104, 106);
    color: white;
    border-color:rgb(117, 119, 121);
}

.pagination .current {
    font-weight: bold;
    background-color:rgb(0, 0, 0);
    color: white;
    border-color:rgb(0, 0, 0);
    cursor: default;
}
</style> 
    
<body>
    <div class="container">
        <!-- =============== Navigation ================ -->
       




        <div class="navigation">
       

            
            <ul>


                <li>
                    <div style="display: flex; align-items: center; position: relative;">

                        <img src="../img/logo.png" alt="a logo" width="85px" height="85px">
            
                        <span class="custom-font" style="margin-left: 10px; position: relative; top: 20px;">Shop</span>
            </div>
                       
    
                        
                </li>
    
                <div class="">
                    <li>
                        <a href="" style="color: black;" id="">
                            <span class="icon">
                                <ion-icon name="person-outline"></ion-icon>
                            </span>
                            <span class="title">ADMIN</span>
                        </a>
                    </li>
                </div>
                <li>
                    <a href="trangchuadmin.php"style="color: black;">
                        <span class="icon">
                            <ion-icon name="home-outline"></ion-icon>
                        </span>
                        <span class="title">Trang chủ</span>
                    </a>
                </li>

                <li>
                    <a href="quanlydonhang.php"style="color: black;">
                        <span class="icon">
                            <ion-icon name="cart-outline"></ion-icon>
                        </span>
                        <span class="title">Quản lý đơn hàng</span>
                    </a>
                </li>

                <li>
                    <a href="quanlysanpham.php"style="color: black;" id="active">
                        <span class="icon">
                            <ion-icon name="book-outline"></ion-icon>
                        </span>
                        <span class="title">Quản lý sản phẩm</span>
                    </a>
                </li>

                <li>
                    <a href="quanlykhachhang.php"style="color: black;">
                        <span class="icon">
                            <ion-icon name="people-outline"></ion-icon>
                        </span>
                        <span class="title">Quản lý khách hàng</span>
                    </a>
                </li>
                <li>
                    <a href="thongke.php"style="color: black;">
                        <span class="icon">
                            <ion-icon name="bar-chart-outline"></ion-icon>
                        </span>
                        <span class="title">Thống kê</span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- ========================= Main ==================== -->
        <div class="main">
            <div class="topbar">
                <div class="hello">
                    <p>CHÀO MỪNG ADMIN CỦA MMB</p>
                </div>
                
            </div>
            <!-- ================ LÀM QUẢN LÝ SẢN PHẨM Ở ĐÂY ================= -->
            <div class="user">
                <div class="banner">


               
                    <button id="adduser"><a href="themsanpham.php">+ Thêm sản phẩm</a></button>
                    
                    <form method="GET" action="">
    <div class="date1">
        <label for="start">Từ ngày: </label>
        <input type="date" id="start" name="start" value="<?= isset($_GET['start']) ? $_GET['start'] : '' ?>" min="2023-01-01" max="2025-12-31">

        <label for="end">đến</label>
        <input type="date" id="end" name="end" value="<?= isset($_GET['end']) ? $_GET['end'] : '' ?>" min="2023-01-01" max="2025-12-31">

        <button type="submit" class="search-btn">
            <i class="fa fa-search"></i> 
        </button>
    </div>
</form>

                  
                    <form method="GET" action="">
                    <input id="timnguoidung" type="text" name="search" value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>" placeholder="Tên sản phẩm ...">   
                    <button type="submit" id="timnguoidung1">
        <i class="fa fa-search"></i> 
    </button>  
</form>
                </div>
                <!-- ================ Add Charts JS ================= -->
                <div class="chartsBx">
                    <h2></h2>
                   
                </div>

                

                
                <div class="details">
                    <div class="recentOrders">
                    <table>
                        <thead>
                            <tr>
                                <td>STT</td>
                                <td>Mã Sản Phẩm</td>
                                <td>Ảnh</td>
                                <td>Tên SP </td>
                                <td>Danh mục</td>
                                <td>Giá</td>
                                <td>Ngày cập nhật</td>
                                <td>Thao tác</td>
                            </tr>
                        </thead>
                        <!-- ================ bảng sửa sản phẩm  ================= -->
                        <tbody>

                        <?php
// Duyệt qua từng sản phẩm và hiển thị
 // Biến đếm số thứ tự
while ($row = mysqli_fetch_assoc($result)) {  
    $formatted_price = number_format($row['price'], 0, ',', '.') . " VND"; // Định dạng giá
?>          
    <tr>
    <td><?= htmlspecialchars($row['id']) ?></td> <!-- Tên sản phẩm -->
    <td><?= htmlspecialchars($row['productcode']) ?></td> <!-- Tên sản phẩm -->

        <td><img src="<?= '../../' . htmlspecialchars($row['image']) ?>" width="80"></td> <!-- Ảnh -->
        <td><?= htmlspecialchars($row['name']) ?></td> <!-- Tên sản phẩm -->
        <td><?= htmlspecialchars($row['category']) ?></td> <!-- Danh mục (Cố định, bạn có thể sửa thành dynamic nếu cần) -->
        <td><?= $formatted_price ?></td> <!-- Giá -->

        <td><?= date("d/m/Y H:i", strtotime($row['updated_at'])) ?></td>
<td>
            <a href="suasanpham.php?id=<?= $row['id']?>" id="suanguoidung" style="display: block;">
                <i class="fas fa-edit"></i> Sửa
            </a>  
            <a href="#" onclick="return confirmDelete(<?= $row['id'] ?>)" id="xoanguoidung" style="display: block;">
    <i class="fas fa-trash-alt"></i> Xóa
</a>  

<script>
    function confirmDelete(productId) {
        if (confirm("Bạn có chắc chắn muốn xóa sản phẩm này không?")) {
            // Gửi yêu cầu xoá đến file deleteproduct.php
            window.location.href = 'deleteproduct.php?id=' + productId;
        }
    }
</script>


        </td>
    </tr>
<?php
}
?>

<?php				

?>
   </table>                         
                   
                
   <div class="pagination">
    <?php
    // Build base URL giữ lại search, start, end
    $base_url = "?search=" . urlencode($raw_search) . "&start=" . urlencode($start) . "&end=" . urlencode($end);

    // Nút Trước
    if ($page > 1) {
        echo "<a href='{$base_url}&page=" . ($page - 1) . "'>Trước</a>";
    }

    // Các số trang
    for ($i = 1; $i <= $total_pages; $i++) {
        if ($i == $page) {
            echo "<span class='hientai1'>$i</span>";  // Trang hiện tại
        } else {
            echo "<a href='{$base_url}&page=$i'>$i</a>";  // Trang khác
        }
    }

    // Nút Sau
    if ($page < $total_pages) {
        echo "<a href='{$base_url}&page=" . ($page + 1) . "'>Sau</a>";
    }
    ?>
</div>
   
            </div>

            </div>
        <!-- ======= Charts JS ====== -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>
        <script src="../js/chartsachbanchay.js"></script>
        <!-- ====== ionicons ======= -->
        <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>

</html>