<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Web-Badminton-Shop/class/nhanvien.php';
// Khởi tạo
$data = new database();
$nhanvien = new Nhanvien();
// ===== XỬ LÝ XÓA NHÂN VIÊN TRỰ TIẾP =====
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];
    $manv = (int)$_POST['id'];
    
    if ($action === 'delete' && $manv > 0) {
        $result = $nhanvien->xoaNhanVien($manv);
        header('Content-Type: application/json');
        echo json_encode($result);
        exit;
    }
}
// Nhận tham số từ GET
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
if ($page < 1) $page = 1;
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$district = isset($_GET['district']) ? trim($_GET['district']) : '';
// Lấy danh sách và tổng
$users = $nhanvien->getNhanvienList($page, $search);
$total_users = $nhanvien->countNhanvien($search, $district);
$total_pages = ceil($total_users / $nhanvien->getLimit());
$stt = ($page - 1) * $nhanvien->getLimit() + 1;
?>
<!DOCTYPE html>
<html lang="en">
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
                    <a href="quanlynhanvien.php"style="color: black;"id="active">
                        <span class="icon">
                            <ion-icon name="person-circle-outline"></ion-icon>
                        </span>
                        <span class="title">Quản lý nhân viên</span>
                    </a>
                </li>
</li>

<li>
                    <a href="quanlyncc.php"style="color: black;">
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
                    <button id="adduser"><a href="themnhanvien.php">+ Thêm nhân viên</a></button>
                        <form method="GET" action="">
        <div class="search-container" style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
            
            <!-- Tìm kiếm text -->
            <input id="timnhanvien" 
                   type="text" 
                   name="search" 
                   value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>" 
                   placeholder="Tên nhân viên, email, số điện thoại ...">   
                        <!-- Nút tìm kiếm -->
            <button type="submit" id="timnhanvien1" style="padding: 8px 15px; cursor: pointer;">
                <i class="fa fa-search"></i> Tìm kiếm
            </button>
        </div>
    </form>


                
                </div>
                <div class="chartsBx">
                    <h2></h2>
                </div>
                

                <div class="details">
                    <div class="recentOrders">
                        <div class="cardHeader">
                            <h2>DANH SÁCH NHÂN VIÊN</h2>
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
                               <td>Ngày vào làm</td>
                                <td>Ngày Sinh</td>
                                <td>Ghi chú</td>
                            </tr>
                        </thead>

                        <tbody>
                           
            
              <?php
                                $stt = ($page - 1) * $nhanvien->getLimit() + 1; 

                                if (!empty($users)) {
                                    foreach ($users as $row) {
                                        $username = htmlspecialchars($row['TENNV']);
                                        $fullname = htmlspecialchars($row['HOTEN']);
                                        $email = htmlspecialchars($row['EMAIL']);
                                        $phone = htmlspecialchars($row['SDT']);
                                        $daywork = date("d/m/Y", strtotime($row['NGAYLAM']));
                                        $id = (int)$row['MANV'];
                                        $avatar = htmlspecialchars($row['AVATAR']);
                                        $birthday = date("d/m/Y", strtotime($row['NS']));
                                        
                                        echo "<tr>";
                                        echo "<td>{$stt}</td>";
                                        echo "<td><img src=\"../../{$avatar}\" width=\"50\" height=\"50\" alt=\"$fullname\" style=\"border-radius: 50%; object-fit: cover;\" loading=\"lazy\"></td>";
                                        echo "<td>{$username}</td>";
                                        echo "<td>{$fullname}</td>";
                                        echo "<td>{$email}</td>";
                                        echo "<td>{$phone}</td>";
                                        echo "<td>{$daywork}</td>";
                                        echo "<td>{$birthday}</td>";
                                        
                                        echo "<td>";
                                        echo "<a href=\"suanhanvien.php?id={$id}\" class=\"btn btn-warning\" title=\"Sửa\"><i class=\"fas fa-edit\"></i> Sửa</a> ";
                                        echo "<a onclick='deleteNhanVien({$id})' class=\"btn btn-danger\" title=\"Xóa nhân viên\"><i class=\"fa-solid fa-trash\"></i> Xóa<a>";
                                        echo "</td>";
                                        echo "</tr>";
                                        $stt++;
                                    }
                                } else {
                                    echo "<tr><td colspan=\"9\" class=\"text-center text-muted\">Không có nhân viên nào!</td></tr>";
                                }
                                ?>
                        </tbody>
                    </table>

                    <div class="pagination">
                            <?php
                            if ($page > 1) {
                                echo "<a href='?page=" . ($page - 1) . "&search=" . urlencode($search) . "'>Trước</a>";
                            }

                            for ($i = 1; $i <= $total_pages; $i++) {
                                if ($i == $page) {
                                    echo "<span class='hientai1'>$i</span>";
                                } else {
                                    echo "<a href='?page=$i&search=" . urlencode($search) . "'>$i</a>";
                                }
                            }

                            if ($page < $total_pages) {
                                echo "<a href='?page=" . ($page + 1) . "&search=" . urlencode($search) . "'>Sau</a>";
                            }
                            ?>
                        </div>


            <!-- ================ Add Charts JS ================= -->
            </div>
        </div>
        </div>
    </div>
    <script>
    function deleteNhanVien(id) {
        if (!confirm("Bạn có chắc chắn muốn XÓA nhân viên này?\n\nHành động này không thể hoàn tác!")) {
            return;
        }

        const formData = new FormData();
        formData.append('action', 'delete');
        formData.append('id', id);

        fetch(window.location.href, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                location.reload();
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Lỗi:', error);
            alert('❌ Lỗi khi xóa nhân viên!');
        });
    }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>
    <script src="../js/chartuser.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>
</html>