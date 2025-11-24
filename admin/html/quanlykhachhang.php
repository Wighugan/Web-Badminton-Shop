<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Web-Badminton-Shop/class/user.php';
$data = new Database();
$user = new QuanLyKhachHang($data);
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
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];
    $makh = (int)$_POST['makh'];
    if ($action === 'lock') {
        $result = $user->khoaTaiKhoan($makh);
        echo json_encode(['status' => $result ? 'success' : 'error', 'message' => $result ? 'Khóa thành công' : 'Lỗi khi khóa']);
        exit;
    } elseif ($action === 'unlock') {
        $result = $user->moKhoaTaiKhoan($makh);
        echo json_encode(['status' => $result ? 'success' : 'error', 'message' => $result ? 'Mở khóa thành công' : 'Lỗi khi mở khóa']);
        exit;
    }
}
// Nhận tham số từ GET
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$district = isset($_GET['district']) ? trim($_GET['district']) : '';
// Lấy danh sách và tổng
$users = $user->getUsers($page, $search, $district);
$total_users = $user->countUsers($search, $district);
$total_pages = ceil($total_users / $user->getLimit());
$stt = ($page - 1) * $user->getLimit() + 1;
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
                    <button id="adduser"><a href="themnguoidung.php">+ Thêm người dùng</a></button>
                    <form method="GET" action="">
  <div class="search-container" style="display: flex; gap: 10px; align-items: center;">
    <!-- Tìm kiếm text -->
     <select name="district" id="district">
      <option value="">Chọn Quận/Huyện</option>
      <option value="Quận 1">Quận 1</option>
      <option value="Quận 2">Quận 2</option>
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
    </select>

    
    <input id="timnguoidung" 
           type="text" 
           name="search" 
           value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>" 
           placeholder="Tên người dùng, email, số điện thoại ...">   
    
    <!-- Chọn quận/huyện -->
    
    
    <!-- Nút tìm kiếm -->
    <button type="submit" id="timnguoidung1" style="padding: 8px 15px;">
      <i class="fa fa-search"></i> 
  </div>
</form>
<!-- Thêm JavaScript để giữ giá trị select khi submit -->
            
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
                                <td>Quận</td>
                                <td>Ngày Sinh</td>
                                <td>Ghi chú</td>
                            </tr>
                        </thead>
                        <tbody>       
                        <?php
                                $stt = ($page - 1) * $user->getLimit() + 1;

                                if (!empty($users)) {
                                    foreach ($users as $row) {
                                        $username = htmlspecialchars($row['TENKH']);
                                        $fullname = htmlspecialchars($row['HOTEN']);
                                        $email = htmlspecialchars($row['EMAIL']);
                                        $phone = htmlspecialchars($row['SDT']);
                                        $address = htmlspecialchars($row['DIACHI1']);
                                        $id = (int)$row['MAKH'];
                                        $avatar = htmlspecialchars($row['AVATAR']);
                                        $birthday = date("d/m/Y", strtotime($row['NS']));
                                        $trangthai = (int)$row['TRANGTHAI'];
                                        $district = htmlspecialchars($row['DIACHI']);

                                        echo "<tr>";
                                        echo "<td>{$stt}</td>";
                                        echo "<td><img src=\"../../{$avatar}\" width=\"50\" height=\"50\" alt=\"{$fullname}\" style=\"border-radius: 50%; object-fit: cover;\" loading=\"lazy\"></td>";
                                        echo "<td>{$username}</td>";
                                        echo "<td>{$fullname}</td>";
                                        echo "<td>{$email}</td>";
                                        echo "<td>{$phone}</td>";
                                        echo "<td>{$district}</td>";
                                        echo "<td>{$birthday}</td>";       
                                    // Nút hành động
                                        echo "<td>";
                                        echo "<a href=\"suakhachhang.php?id={$id}\" class=\"btn btn-warning\"><i class=\"fas fa-edit\"></i> Sửa</a>";

                                        if ($trangthai == 1) {
                                            echo "<a onclick='lockUser({$id})'  class='btn btn-sm btn-danger' style='color: red' title='Khóa tài khoản'><i class='fa-solid fa-lock'></i>Khóa<a>";
                                        } else {
                                            echo "<a onclick='unlockUser({$id})' class='btn btn-sm btn-success' style='color: green' title='Mở khóa tài khoản'><i class='fa-solid fa-lock-open'></i> Mở khóa</a>";
                                        }
                                        echo "</td>";
                                        echo "</tr>";
                                        $stt++;
                                    }
                                } else {
                                    echo "<tr><td colspan=\"10\" class=\"text-center text-muted\">Không có người dùng nào!</td></tr>";
                                }
                                $user->__destruct();
                                ?>
                        </tbody>
                    </table>
                    <div class="pagination">
                    <?php
    // Nút Trước
    if ($page > 1) {
        echo "<a href='?page=" . ($page - 1) . "&search=" . urlencode($search) . "'>Trước</a>";
    }

    // Các số trang
    for ($i = 1; $i <= $total_pages; $i++) {
        if ($i == $page) {
            echo "<span class='hientai1'>$i</span>";  // Trang hiện tại
        } else {
            echo "<a href='?page=$i&search=" . urlencode($search) . "'>$i</a>";  // Trang khác
        }
    }

    // Nút Sau
    if ($page < $total_pages) {
        echo "<a href='?page=" . ($page + 1) . "&search=" . urlencode($search) . "'>Sau</a>";
    }
    ?>
</div>
            </div>
        </div>
        </div>
    </div>
    <script>
    function lockUser(userId) {
        if (!confirm("Bạn có chắc chắn muốn KHÓA tài khoản này?\n\nKhách hàng sẽ không thể đăng nhập!")) {
            return;
        }
        const formData = new FormData();
        formData.append('action', 'lock');
        formData.append('makh', userId);

        fetch(window.location.href, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                alert('✓ ' + data.message);
                location.reload();
            } else {
                alert('❌ ' + data.message);
            }
        })
        .catch(error => {
            console.error('Lỗi:', error);
            alert('❌ Lỗi khi khóa tài khoản!');
        });
    }

    function unlockUser(userId) {
        if (!confirm("Bạn có chắc chắn muốn MỞ KHÓA tài khoản này?\n\nKhách hàng sẽ có thể đăng nhập lại!")) {
            return;
        }

        const formData = new FormData();
        formData.append('action', 'unlock');
        formData.append('makh', userId);

        fetch(window.location.href, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                alert('✓ ' + data.message);
                location.reload();
            } else {
                alert('❌ ' + data.message);
            }
        })
        .catch(error => {
            console.error('Lỗi:', error);
            alert('❌ Lỗi khi mở khóa tài khoản!');
        });
    }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>
    <script src="../js/chartuser.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>

</html>