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


$raw_search = isset($_GET['search']) ? trim($_GET['search']) : '';
$district = isset($_GET['district']) ? trim($_GET['district']) : ''; // Lấy giá trị quận/huyện

$limit = 5;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
if ($page < 1) $page = 1;
$offset = ($page - 1) * $limit;

$where = [];
$params = [];
$param_types = "";

// Tìm kiếm theo tên
if (!empty($raw_search)) {
    $where[] = "fullname LIKE ?";
    $params[] = "%$raw_search%";
    $param_types .= "s";
}

// Lọc theo quận/huyện
if (!empty($district)) {
    $where[] = "address LIKE ?";
    $params[] = "%$district%";
    $param_types .= "s";
}

$where_sql = "";
if (!empty($where)) {
    $where_sql = "WHERE " . implode(" AND ", $where);
}

// Đếm tổng số kết quả
$sql_total = "SELECT COUNT(*) AS total FROM users $where_sql";
$stmt_total = $conn->prepare($sql_total);
if (!empty($params)) {
    $stmt_total->bind_param($param_types, ...$params);
}
$stmt_total->execute();
$total_users = $stmt_total->get_result()->fetch_assoc()['total'];
$stmt_total->close();

// Lấy dữ liệu người dùng
$sql_data = "SELECT * FROM users $where_sql ORDER BY id DESC LIMIT ? OFFSET ?";
$stmt = $conn->prepare($sql_data);

// Gộp lại tất cả params + thêm limit, offset
$params[] = $limit;
$params[] = $offset;
$param_types .= "ii";

$stmt->bind_param($param_types, ...$params);
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
                    <button id="adduser"><a href="themnguoidung.php">+ Thêm người dùng</a></button>
                    
                   
                    <form method="GET" action="" >
<div class="date1">

    <select name="district" id="month">
        <option value="">Chọn Quận/Huyện</option>
        <option value="Quận 1">Quận 2</option>
        <option value="Quận 3">Quận 3</option>
        <option value="Quận 4">Quận 4</option>
<option value="Quận 5">Quận 5</option>
<option value="Quận 6">Quận 6</option>
<option value="Quận 7">Quận 7</option>
<option value="Quận 8">Quận 8</option>
<option value="Quận 9">Quận 9</option>
<option value="Quận 10">Quận 10</option>
<option value="Quận 11">Quận 11</option>
<option value="Quận 12">Quận 12</option>
<option value="Bình Thạnh">Bình Thạnh</option>
<option value="Gò Vấp">Gò Vấp</option>
<option value="Phú Nhuận">Phú Nhuận</option>
<option value="Tân Bình">Tân Bình</option>
<option value="Tân Phú">Tân Phú</option>
<option value="Bình Tân">Bình Tân</option>
<option value="Thủ Đức">Thủ Đức</option>
<option value="Huyện Nhà Bè">Huyện Nhà Bè</option>
<option value="Huyện Bình Chánh">Huyện Bình Chánh</option>
<option value="Huyện Hóc Môn">Huyện Hóc Môn</option>
<option value="Huyện Củ Chi">Huyện Củ Chi</option>
<option value="Huyện Cần Giờ">Huyện Cần Giờ</option>

        <!-- ... thêm các quận huyện khác -->
    </select>
    <button type="submit" class="search-btn">
            <i class="fa fa-search"></i> 
        </button>

</div>
</form>
                   

                    <form method="GET" action="">
                    <input id="timnguoidung" type="text" name="search" value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>" placeholder="Tên người dùng ...">   
                    <button type="submit" id="timnguoidung1">
        <i class="fa fa-search"></i> 
    </button>  
</form>


                
                </div>
                <div class="chartsBx">
                    <h2></h2>
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
                        <i class='fa-solid fa-lock'></i> khóa
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
        

        function deleteuser(userId) {
        const confirmation = confirm("Bạn có chắc chắn muốn khóa người dùng này?");
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