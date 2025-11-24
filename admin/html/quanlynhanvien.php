<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Web-Badminton-Shop/class/nhanvien.php';
// Khởi tạo
$data = new database();
$nhanvien = new Nhanvien();
if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], ['admin', 'nhanvien'])) {
    header("Location: ../../Signin.php");
    exit();
}
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    $quanly = new Database();
    $quanly->dangxuat();
    header('Location: ../../signin.php');
    exit();
}
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
</head>

<body>
    <!-- =============== Navigation ================ -->
 <?php 
     include $_SERVER['DOCUMENT_ROOT'] . '/Web-Badminton-Shop/class/header-admin.php';
    ?>
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