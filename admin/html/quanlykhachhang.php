<!DOCTYPE html>
<html lang="en">
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mydp";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Lấy dữ liệu từ GET
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
$types = "";  // loại dữ liệu cho bind_param

if (!empty($raw_search)) {
    $where .= " AND users.fullname LIKE ?";
    $params[] = "%$raw_search%";
    $types .= "s";
}

if (!empty($start) && !empty($end)) {
    $where .= " AND orders.created_at BETWEEN ? AND ?";
    $params[] = $start . " 00:00:00";
    $params[] = $end . " 23:59:59";
    $types .= "ss";
}

// Đếm tổng số khách hàng
$sql_count = "SELECT COUNT(DISTINCT users.id) AS total 
              FROM users 
              LEFT JOIN orders ON users.id = orders.user_id 
              WHERE $where";
$stmt_total = $conn->prepare($sql_count);
if (!empty($params)) {
    $stmt_total->bind_param($types, ...$params);
}
$stmt_total->execute();
$total_row = $stmt_total->get_result()->fetch_assoc();
$total_users = $total_row['total'];
$stmt_total->close();

// Truy vấn danh sách users
// Truy vấn danh sách users
$sql = "SELECT users.* 
        FROM users 
        LEFT JOIN orders ON users.id = orders.user_id 
        WHERE $where 
        GROUP BY users.id 
        LIMIT ? OFFSET ?";
$stmt = $conn->prepare($sql);

// Gắn limit và offset vào
$params[] = $limit;
$params[] = $offset;
$full_types = $types . "ii"; // bổ sung loại dữ liệu
$stmt->bind_param($full_types, ...$params);

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
    <link rel="stylesheet" href="../css/quanlykhachhang.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    

   
      
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
    

</head>

<body>
    <!-- =============== Navigation ================ -->
    <div class="container">
        <div class="navigation">
            <ul>
                <li>
                    <a href="#">
                        <div style="display: flex; align-items: center; position: relative;">

                            <img src="../img/logo.png" alt="a logo" width="85px" height="85px">
    
                            <span class="custom-font" style="margin-left: 10px; position: relative; top: 20px;">Shop</span>
    </div>
    
                        </a>
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
                    <a href="quanlysanpham.php"style="color: black;">
                        <span class="icon">
                            <ion-icon name="book-outline"></ion-icon>
                        </span>
                        <span class="title">Quản lý sản phẩm</span>
                    </a>
                </li>

                <li>
                    <a href="quanlykhachhang.php" style="color: black;" id="active">
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

            <!-- ================ LÀM QUẢN LÝ KHÁCH HÀNG Ở ĐÂY ================= -->
            <div class="user"  >         
            <div class="banner">

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
                <div class="details">
                    <div class="recentOrders">
                        <div class="cardHeader">
                            <h2>THỐNG KÊ LƯỢNG ĐĂNG KÝ NĂM 2024</h2>
                        </div>
                    <table>
                        <thead>
                            <tr>
                                <td>STT</td>
                                <td>Ảnh đại diện </td>
                                <td>Tên đăng nhập </td>
                                <td>Họ và tên</td>
                                <td>Email</td>
                                <td>Số điện thoại</td>
                                <td>Địa chỉ</td>
                                <td>Ngày Sinh</td>
                                <td>Ghi chú</td>
                            </tr>
                        </thead>

                        <tbody>
                           
            
                        <?php
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['id']}</td>
                <td>  <img src='../../{$row['avatar']}' width='50' height='50' style='border-radius: 0%;'>    </td>
                <td>{$row['username']}</td>
                <td>{$row['fullname']}</td>
                <td>{$row['email']}</td>
                <td>{$row['numberphone']}</td>
                <td>{$row['address']}</td>
                <td>" . date("d/m/Y", strtotime($row['birthday'])) . "</td>
                <td>
                    <a href='suakhachhang.php?id={$row['id']}' id='suanguoidung'_{$row['id']}'>
                        <i class='fas fa-edit'></i> Sửa
                    </a>
                    <a href='#' onclick='deleteuser({$row['id']})' style='color: red;'>
                        <i class='fa-solid fa-trash'></i> Xóa
                    </a>
                </td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='8'>Không có người dùng nào!</td></tr>";
}
$conn->close();
?>
        <script>
        function lockUser(userId) {
            const confirmation = confirm("Bạn có chắc chắn muốn khóa người dùng này?");
            if (confirmation) {
                alert("Khóa người dùng thành công!");
                window.location.href = 'quanlykhachhang.php?id=' + userId;
            }
        }

        function deleteuser(userId) {
        const confirmation = confirm("Bạn có chắc chắn muốn xóa người dùng này?");
        if (confirmation) {
            window.location.href = 'deleteuser.php?id=' + userId;

        }
    }
    </script>
                        </tbody>
                    </table>

                    <div class="pagination">
    <?php
    // Nút Trước
    if ($page > 1) {
        echo "<a href='?page=" . ($page - 1) . "&search=" . urlencode($raw_search) . "'>Trước</a>";
    }

    // Các số trang
    for ($i = 1; $i <= $total_pages; $i++) {
        if ($i == $page) {
            echo "<span class='hientai1'>$i</span>";  // Trang hiện tại
        } else {
            echo "<a href='?page=$i&search=" . urlencode($raw_search) . "'>$i</a>";  // Trang khác
        }
    }

    // Nút Sau
    if ($page < $total_pages) {
        echo "<a href='?page=" . ($page + 1) . "&search=" . urlencode($raw_search) . "'>Sau</a>";
    }
    ?>
</div>


            <!-- ================ Add Charts JS ================= -->
            </div>
        </div>
        </div>
    </div>
    <!-- ======= Charts JS ====== -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>
    <script src="../js/chartuser.js"></script>
    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
   
</body>

</html>