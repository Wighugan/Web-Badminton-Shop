<!DOCTYPE html>
<html lang="en">
<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Web-Badminton-Shop/database/connect.php';$data = new database();
$raw_search = isset($_GET['search']) ? trim($_GET['search']) : '';
$district = isset($_GET['district']) ? trim($_GET['district']) : '';

$limit = 5;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
if ($page < 1) $page = 1;
$offset = ($page - 1) * $limit;

// Xây dựng WHERE
$where_parts = [];
$params = [];
$param_types = "";

// Tìm kiếm theo tên
if (!empty($raw_search)) {
    $where_parts[] = "fullname LIKE ?";
    $params[] = "%$raw_search%";
    $param_types .= "s";
}

// Lọc theo quận/huyện
if (!empty($district)) {
    $where_parts[] = "address LIKE ?";
    $params[] = "%$district%";
    $param_types .= "s";
}

// QUAN TRỌNG: Ghép WHERE clause từ mảng
$where_sql = "";
if (!empty($where_parts)) {
    $where_sql = "WHERE " . implode(" AND ", $where_parts);
}

// ===== ĐẾM TỔNG =====
$sql_total = "SELECT COUNT(*) AS total FROM users $where_sql";

if (!empty($params)) {
    $data->select_prepare($sql_total, $param_types, ...$params);
} else {
    $data->select($sql_total);
}

$total_row = $data->fetch();
$total_users = $total_row['total'] ?? 0;
$total_pages = ceil($total_users / $limit);

// ===== LẤY DỮ LIỆU =====
$sql_data = "SELECT * FROM nhacungcap $where_sql ORDER BY id ASC LIMIT ? OFFSET ?";

// Copy params và thêm LIMIT/OFFSET
$params_data = $params;
$params_data[] = $limit;
$params_data[] = $offset;
$types_data = $param_types . "ii";

$data->select_prepare($sql_data, $types_data, ...$params_data);
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
                    <a href="quanlykhachhang.php" style="color: black;" >
                        <span class="icon">
                            <ion-icon name="people-outline"></ion-icon>
                        </span>
                        <span class="title">Quản lý khách hàng</span>
                    </a>
                </li>
                                         
<li>
                    <a href="quanlynhanvien.php"style="color: black;">
                        <span class="icon">
                            <ion-icon name="person-circle-outline"></ion-icon>
                        </span>
                        <span class="title">Quản lý nhân viên</span>
                    </a>
                </li>
</li>

<li>
                    <a href="quanlyncc.php"style="color: black;"id="active">
                        <span class="icon">
                            <ion-icon name="business-outline"></ion-icon>
                        </span>
                        <span class="title">Quản lý nhà cung cấp</span>
                    </a>
                </li>

                </li>

<li>
                    <a href="quanlykho.php"style="color: black;">
                        <span class="icon">
                            <ion-icon name="cube-outline"></ion-icon>
                        </span>
                        <span class="title">Quản lý kho</span>
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
                    <button id="adduser"><a href="themncc.php">+ Thêm nhà cung cấp</a></button>
                    
                   
                    <form method="GET" action="" >

                   

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
                            <h2>DANH SÁCH NHÀ CUNG CẤP</h2>
                        </div>
                    <table>
                        <thead>
                            <tr>
                                <td>STT</td>
                                <td>Logo</td>
                                <td>Tên nhà cung cấp </td>
                            
                                <td>Email</td>
                                <td>Số điện thoại</td>
                                <td>Địa chỉ</td>
                                <td>Người đại diện</td>
                                <td>Ghi chú</td>
                            </tr>
                        </thead>

                        <tbody>
                           
            
   <?php
        $stt = ($page - 1) * $limit + 1;
        $users = $data->fetchAll(); // LẤY TẤT CẢ DÒNG MỘT LẦN
        
        if (!empty($users)) {
            foreach ($users as $row) {
                // Escape output để tránh XSS
                  $id = (int)$row['id'];
    $avatar = htmlspecialchars($row['avatar']);
    $fullname = htmlspecialchars($row['fullname']);
    $email = htmlspecialchars($row['email']);
    $phone = htmlspecialchars($row['numberphone']);
    $diaChi = htmlspecialchars($row['diaChi']);
    $NgayHopTac = date("d/m/Y", strtotime($row['NgayHopTac']));
  
    $NguoiDaiDien = htmlspecialchars($row['NguoiDaiDien']);
                
                echo "<tr>";
                echo "<td>{$stt}</td>";
                
                // Ảnh đại diện
                echo "<td>";
                echo "<img src=\"../../{$avatar}\" width=\"50\" height=\"50\" alt=\"$fullname\" style=\"border-radius: 50%; object-fit: cover;\" loading=\"lazy\">";
                echo "</td>";
                
                echo "<td>{$fullname}</td>";
                echo "<td>{$email}</td>";
                echo "<td>{$phone}</td>";
                echo "<td>{$diaChi}</td>";
                   echo "<td>{$NguoiDaiDien}</td>";

                // Thao tác
                echo "<td>";
                echo "<a href=\"suancc.php?id={$id}\" class=\"btn btn-sm btn-warning\" title=\"Sửa\">";
                echo "<i class=\"fas fa-edit\"></i> Sửa";
                echo "</a> ";
               // Nút khóa / mở khóa
echo "<a href='#' onclick='return confirmDelete({$row['id']}, \"nhacungcap\")' class='btn btn-sm btn-danger' style='color: red' title='Xóa nhân viên'>";
echo "<i class='fa-solid fa-trash'></i> Xóa";
echo "</a>";


echo "</td>";
echo "</tr>";
                $stt++;
            }
        } else {
            echo "<tr><td colspan=\"9\" class=\"text-center text-muted\">Không có người dùng nào!</td></tr>";
        }
        $data->close();
        ?>

<script>
function confirmDelete(id, type) {
    if (confirm("Bạn có chắc chắn muốn xóa mục này không?")) {
        window.location.href = `deleteuser.php?id=${id}&type=${type}`;
    }
    return false; // Ngăn chặn hành động mặc định của <a>
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