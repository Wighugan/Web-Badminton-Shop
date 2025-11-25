<?php
require_once dirname(__DIR__, 2) . '/class/order.php';
$data = new Database();
$orderObj = new Order($data);
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

$order_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
// Khi admin bấm cập nhật trạng thái
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_status'])) {
    $new_status = $_POST['TRANGTHAI'] ?? '';
    if (!empty($new_status)) {
        $result = $orderObj->updateStatus($order_id, $new_status);       
        if ($result['success']) {
            echo "<script>alert('" . $result['message'] . "'); location.href='chitietdonhang.php?id=$order_id';</script>";
            exit;
        } else {
            echo "<script>alert('" . $result['message'] . "');</script>";
        }
    }
}
// Lấy thông tin đơn (kiểm tra tồn tại)
$order = $orderObj->getOrderInfo($order_id);
if (!$order) {
    echo "<p style='color:red'>Không tìm thấy đơn hàng với id = {$order_id}</p>";
    exit;
}
// Lấy chi tiết đơn, đảm bảo là mảng (không để null)
$details = $orderObj->getOrderDetails($order_id);
if (!is_array($details)) {
    $details = []; // fallback an toàn
}
$next_statuses = $orderObj->getNextStatuses($order['TRANGTHAI']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - MMB - Shop Bán Đồ Cầu Lông</title>
    <link href='../img/logo.png' rel='icon' type='image/x-icon' />
    <title>ĐH 5728319</title>
    <!-- ======= Styles ====== -->
    <link rel="stylesheet" href="../css/indexadmin.css">
    <link rel="stylesheet" href="../css/chitietdonhang.css">
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
            <!-- ======================= Cards ================== -->

            <div class="chitietdonhang">
                <div class="banner">
                    <p>Mã đơn hàng: <a href ="chitietdonhang.php"><?= $order['CODE'] ?></a>
                        
                    </p>
                    <p>20/11/2024 - 23:51 | NV tư vấn: Nguyễn Văn B - nguyenvanB@gmail.com</p>
                </div>


              
               
                <div class="address2">
                <div class="diachigiaohang">
                    <div class="address">
                        <p >ĐỊA CHỈ LẤY HÀNG</p>

                    </div>
                   
                    <div class="thongtinnguoimua">
                        <p style="font-weight: bold; ">MMB SHOP</p>
                        <p> (+84) 0123456789</p>
                        <p> 273 An Dương Vương, Phường 3, Quận 5, Thành Phố Hồ Chí Minh</p>
                    </div>
                    <!-- Trong phần HTML -->
                    

                </div>
                <div class="diachigiaohang">
                    <div class="address">
                        <p >ĐỊA CHỈ GIAO HÀNG</p>

                    </div>
                   
                    <div class="thongtinnguoimua">
                        <p style="font-weight: bold; "><?= $order['HOTEN'] ?></p>
                        <p> <?= $order['SDT'] ?></p>
                        <p>  <?= $order['DIACHI1'] ?></p>
                    </div>
                    <!-- Trong phần HTML -->
                   

                </div>
            </div>

               
               
               

                      <?php if (!$order) { echo "<p style='color:red;'>⚠ Không tìm thấy đơn hàng!</p>"; } ?>

<div class="detail">
    <div class="recentOrder">
        <form method="POST" enctype="multipart/form-data" id="suaUserForm">
            <table>
                <thead>
                    <tr>
                        <td>ID</td>
                        <td>Ảnh</td>
                        <td>Tên SP</td>
                        <td>Số lượng</td>
                        <td>Giá tiền</td>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $i = 1;
                    $total = 0;
                    foreach ($details as $row) { 
                        $thanhtien = $row['SOLUONG'] * $row['DONGIA'];
                        $total += $thanhtien;
                    ?>
                    <tr>
                        <td><?= $i++ ?></td>
                        <td><img src="../<?= htmlspecialchars($row['IMAGE']) ?>" width="80"></td>
                        <td><?= htmlspecialchars($row['TENSP']) ?></td>
                        <td><?= $row['SOLUONG'] ?></td>
                        <td><?= number_format($row['DONGIA'], 0, ',', '.') ?> VND</td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>

            <div class="thanhtoan">
                <table>
                    <tbody>
                        <tr><td>Tổng tiền hàng:</td><td><b><?= number_format($total, 0, ',', '.') ?> VND</b></td></tr>
                        <tr><td>Phí vận chuyển:</td><td>50.000 VND</td></tr>
                        <tr><td>Giảm giá phí vận chuyển:</td><td>-50.000 VND</td></tr>
                        <tr><td>Phí Bảo Đảm:</td><td>30.000 VND</td></tr>
                        <tr><td><b>Thành tiền:</b></td>
                            <td><b><?= number_format($total + 30000, 0, ',', '.') ?> VND</b></td></tr>
                        <tr><td>Phương thức thanh toán:</td><td>COD</td></tr>

                        <tr>
                            <td>Trạng thái:</td>
                            <td>
                                <select name="TRANGTHAI" required style="padding: 8px; border-radius: 4px; border: 1px solid #ddd;">
                                    <option value="Chờ xác nhận" <?= ($order['TRANGTHAI'] === 'Chờ xác nhận') ? 'selected' : '' ?>>Chờ xác nhận</option>
                                    <option value="Đang giao" <?= ($order['TRANGTHAI'] === 'Đang giao') ? 'selected' : '' ?>>Đang giao</option>
                                    <option value="Thành công" <?= ($order['TRANGTHAI'] === 'Thành công') ? 'selected' : '' ?>>Thành công</option>
                                    <option value="Đã hủy" <?= ($order['TRANGTHAI'] === 'Đã hủy') ? 'selected' : '' ?>>Đã hủy</option>
                                </select>
                            </td>
                        </tr>
                    </tbody>
                </table>

  <div class="chon">
                        <button type="submit" name="update_status" onclick="done()">Cập nhật trạng thái</button>
                        </div>
            </div>
        </form>
    </div>
</div>
                    <script>
                        function done() {
                          alert("Đã cập nhật trạng thái thành công!");
                        }
                      </script>

                      <script>
                        function tra() {
                            const confirmation = confirm("Bạn có chắc chắn muốn thu hồi đơn hàng này?");
                            if (confirmation) {
                                alert("Lệnh thu hồi đơn hàng sẽ được thông báo đến đơn vị vận chuyển!")
                            }
                        }
                    </script>
            </div>
        </div>
    </div>
    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>

</html>