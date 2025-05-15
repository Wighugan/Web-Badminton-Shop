<!DOCTYPE html>
<html lang="en">
<?php


// Kết nối đến MySQL
$conn = new mysqli("localhost", "root", "", "mydp");
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

$order_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_status'])) {
    $new_status = $_POST['status'];
    $update_sql = "UPDATE orders SET status = ? WHERE id = ?";
    $stmt_update = $conn->prepare($update_sql);
    $stmt_update->bind_param("si", $new_status, $order_id);
    if ($stmt_update->execute()) {
        // Load lại trang để hiển thị trạng thái mới
        echo "<script>location.href='chitietdonhang.php?id=$order_id';</script>";
        exit;
    } else {
        echo "<script>alert('Cập nhật trạng thái thất bại!');</script>";
    }
}

// Lấy thông tin đơn hàng + khách hàng
$sql_order = "SELECT orders.*, users.fullname, users.numberphone , users.address1 FROM orders 
              JOIN users ON orders.user_id = users.id 
              WHERE orders.id = ?";

              
$stmt_order = $conn->prepare($sql_order);
$stmt_order->bind_param("i", $order_id);
$stmt_order->execute();
$result_order = $stmt_order->get_result();
$order = $result_order->fetch_assoc();

// Lấy danh sách sản phẩm trong đơn hàng
$sql_detail = "SELECT order_details.*, product.image 
               FROM order_details 
             left JOIN product ON order_details.product_id = product.id 
               WHERE order_details.order_id = ?";
$stmt_detail = $conn->prepare($sql_detail);
$stmt_detail->bind_param("i", $order_id);
$stmt_detail->execute();
$result_detail = $stmt_detail->get_result();


?>


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
    <div class="container">
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
                    <a href="trangchuadmin.php" style="color: black;"  >
                        <span class="icon">
                            <ion-icon name="home-outline"></ion-icon>
                        </span>
                        <span class="title">Trang chủ</span>
                    </a>
                </li>

                <li>
                    <a href="quanlydonhang.php"style="color: black;" >
                        <span class="icon">
                            <ion-icon name="cart-outline"></ion-icon>
                        </span>
                        <span class="title">Quản lý đơn hàng</span>
                    </a>
                </li>

                <li>
                    <a href="quanlysanpham.php" style="color: black;">
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
                <div class="search" >
                    <label>
                        <input type="text" placeholder="Tìm kiếm chức năng quản trị">
                       <a href=""><ion-icon name="search-outline"></ion-icon></a>
                    </label>
                </div>
            </div>
            <!-- ======================= Cards ================== -->

            <div class="chitietdonhang">
                <div class="banner">
                    <p>Mã đơn hàng: <a href ="chitietdonhang.php"><?= $order['code'] ?></a>
                        
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
                        <p style="font-weight: bold; "><?= $order['fullname'] ?></p>
                        <p> <?= $order['numberphone'] ?></p>
                        <p>  <?= $order['address1'] ?></p>
                    </div>
                    <!-- Trong phần HTML -->
                   

                </div>
            </div>

               
               
               

                       <div class="detail">
                        <div class="recentOrder">
                           
                        <form  method="POST" enctype="multipart/form-data" id="suaUserForm">


                    <table>
                        <thead>
                            <tr>
                                
                               <td>id</td>
                                <td>Ảnh</td>
                                 <td>Tên SP</td>
                                 <td>Số lượng</td>
                                <td>Giá tiền </td>
                                
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
        $i = 1;
        $total = 0;
        while($row = $result_detail->fetch_assoc()) { 
            $thanhtien = $row['quantity'] * $row['product_price'];
            $total += $thanhtien;
        ?>
        <tr>
            <td><?= $i++ ?></td>

            <td><img src="<?= '../../' . htmlspecialchars($row['image']) ?>" width="80"></td> <!-- Ảnh -->
            <td><?= $row['product_name'] ?></td>
            <td><?= $row['quantity'] ?></td>
            <td><?= number_format($row['product_price'], 0, ',', '.') ?> VND</td>
        </tr>
        <?php } ?>
                        </tbody>
                    </table>
                    <div class="thanhtoan">
    <table>
        <tbody>
            <tr>
                <td>Tổng tiền hàng:</td>
                <td><b><?= number_format($total, 0, ',', '.') ?> VND</b></td>
            </tr>
            <tr>
                <td>Phí vận chuyển:</td>
                <td>50.000 VND</td>
            </tr>
            <tr>
                <td>Giảm giá phí vận chuyển:</td>
                <td>-50.000 VND</td>
            </tr>
            <tr>
                <td>Phí Bảo Đảm:</td>
                <td>30.000 VND</td>
            </tr>
            <tr>
                <td><b>Thành tiền:</b></td>
                <td>
                    <b>
                        <?php 
                        $total_final = $total + 30000; // phí bảo đảm, miễn phí vận chuyển
                        echo number_format($total_final, 0, ',', '.'); 
                        ?> VND
                    </b>
                </td>
            </tr>
            <tr>
                <td>Phương thức thanh toán:</td>
                <td>COD</td>
                            </tr>

                            <tr>
                            <td>Trạng thái:</td>
<td>   
    <select id="month1" name="status" required>
        <?php
        $current_status = $order['status'];
        $statuses = ['Chờ xác nhận', 'Đang giao', 'Thành công', 'Đã hủy'];
        $status_order = array_flip($statuses); // dùng để so sánh thứ tự

        foreach ($statuses as $status) {
            // Nếu trạng thái đang duyệt có thứ tự nhỏ hơn trạng thái hiện tại thì disable
            $disabled = ($status_order[$status] < $status_order[$current_status]) ? 'disabled' : '';
            $selected = ($status == $current_status) ? 'selected' : '';
            echo "<option value=\"$status\" $selected $disabled>$status</option>";
        }
        ?>
    </select>
</td>

                    

                        </tbody>
                    </table>
                    
                    <div class="chon">
                        <button type="submit" name="update_status" onclick="done()">Cập nhật trạng thái</button>
                        </div>

        

                </div>
            </div>
                </div>
                </div>
                </form>
               
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