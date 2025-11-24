<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Web-Badminton-Shop/class/ncc.php';
$data = new Database();
$ncc = new Ncc();
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
// ===== XỬ LÝ XÓA/KHOÁ/MỞ KHOÁ TRỰC TIẾP =====
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];
    $mancc = (int)$_POST['mancc'];
    if ($action === 'delete') {
        $result = $ncc->deleteNcc($mancc);
        header('Content-Type: application/json');
        echo json_encode($result);
        exit;
    } elseif ($action === 'lock') {
        $result = $ncc->khoaNcc($mancc);
        header('Content-Type: application/json');
        echo json_encode(['success' => $result, 'message' => $result ? '✅ Khoá thành công' : '❌ Lỗi khi khoá']);
        exit;
    } elseif ($action === 'unlock') {
        $result = $ncc->moKhoaNcc($mancc);
        header('Content-Type: application/json');
        echo json_encode(['success' => $result, 'message' => $result ? '✅ Mở khoá thành công' : '❌ Lỗi khi mở khoá']);
        exit;
    }
}

// Nhận tham số từ GET
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
if ($page < 1) $page = 1;
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$district = isset($_GET['district']) ? trim($_GET['district']) : '';

// ===== QUAN TRỌNG: Khởi tạo biến riêng biệt =====
$ncc_list = $ncc->getNccList($page, $search, $district);
$total_ncc = $ncc->countNcc($search, $district);
$total_pages = ceil($total_ncc / $ncc->getLimit());
// ✅ Sửa: sử dụng $ncc thay vì $ncc
$stt = ($page - 1) * $ncc->getLimit() + 1;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - MMB - Shop Bán Đồ Cầu Lông</title>
    <link href='../img/logo.png' rel='icon' type='image/x-icon' />
    <link rel="stylesheet" href="../css/indexadmin.css">
    <link rel="stylesheet" href="../css/quanlykhachhang.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
</head>

<body>
    <!-- Navigation -->
     <?php 
     include $_SERVER['DOCUMENT_ROOT'] . '/Web-Badminton-Shop/class/header-admin.php';
    ?>
        <!-- Main -->
        <div class="main">
            <div class="topbar">
                <div class="hello">
                    <p>CHÀO MỪNG ADMIN CỦA MMB</p>
                </div>
            </div>

            <!-- Quản lý Nhà Cung Cấp -->
            <div class="user">         
                <div class="banner">
                    <button id="adduser"><a href="themncc.php">+ Thêm nhà cung cấp</a></button>
                    
                    <form method="GET" action="">
                        <input id="timnguoidung" type="text" name="search" value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>" placeholder="Tên người dùng ...">   
                        <button type="submit" id="timnguoidung1">
                            <i class="fa fa-search"></i> 
                        </button>  
                    </form>
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
                                // ✅ Sửa: sử dụng $ncc_list thay vì $users
                                if (!empty($ncc_list)) {
                                    foreach ($ncc_list as $row) {
                                        $id = (int)$row['MANCC'];
                                        $avatar = htmlspecialchars($row['AVATAR']);
                                        $fullname = htmlspecialchars($row['TENNCC']);
                                        $email = htmlspecialchars($row['EMAIL']);
                                        $phone = htmlspecialchars($row['SDT']);
                                        $diaChi = htmlspecialchars($row['DIACHI']);  
                                        $NguoiDaiDien = htmlspecialchars($row['NGUOIDD']);
                                        
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
                                        
                                        // ✅ Nút xóa - gọi hàm deleteNcc() trực tiếp
                                        echo "<a href='#' onclick='return deleteNcc({$row['MANCC']})' class='btn btn-sm btn-danger' style='color: red' title='Xóa nhà cung cấp'>";
                                        echo "<i class='fa-solid fa-trash'></i> Xóa";
                                        echo "</a>";

                                        echo "</td>";
                                        echo "</tr>";
                                        $stt++;
                                    }
                                } else {
                                    echo "<tr><td colspan=\"9\" class=\"text-center text-muted\">Không có nhà cung cấp nào!</td></tr>";
                                }
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
                                    echo "<span class='current'>$i</span>";
                                } else {
                                    echo "<a href='?page=$i&search=" . urlencode($search) . "'>$i</a>";
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
    </div>

    <script>
    // ✅ Hàm xóa nhà cung cấp sử dụng hàm deleteNcc() từ class
    function deleteNcc(mancc) {
        if (!confirm("Bạn có chắc chắn muốn xóa nhà cung cấp này không?")) {
            return false;
        }

        const formData = new FormData();
        formData.append('action', 'delete');
        formData.append('mancc', mancc);

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
            alert('❌ Lỗi khi xóa nhà cung cấp!');
        });
        
        return false;
    }

    function lockNcc(mancc) {
        if (!confirm("Bạn có chắc chắn muốn KHOÁ nhà cung cấp này?")) {
            return;
        }

        const formData = new FormData();
        formData.append('action', 'lock');
        formData.append('mancc', mancc);

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
            alert('❌ Lỗi khi khoá!');
        });
    }

    function unlockNcc(mancc) {
        if (!confirm("Bạn có chắc chắn muốn MỞ KHOÁ nhà cung cấp này?")) {
            return;
        }

        const formData = new FormData();
        formData.append('action', 'unlock');
        formData.append('mancc', mancc);

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
            alert('❌ Lỗi khi mở khoá!');
        });
    }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>
    <script src="../js/chartuser.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>
</html>