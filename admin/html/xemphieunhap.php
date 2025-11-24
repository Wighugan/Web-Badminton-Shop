<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Web-Badminton-Shop/database/connect.php';
class ChiTietPhieuNhap extends Database
{
    private $limit;
    private $page;
    private $offset;
    private $total_rows;
    private $total_pages;
    private $data_list = [];

    public function __construct($limit = 10)
    {
        parent::__construct(); 
        $this->limit = $limit;
        $this->page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $this->offset = ($this->page - 1) * $this->limit;
    }

    private function countTotal()
    {
        $sql = "SELECT COUNT(*) AS total FROM ctpn";
        $this->select($sql);
        $row = $this->fetch();
        $this->total_rows = $row['total'] ?? 0;
        $this->total_pages = ceil($this->total_rows / $this->limit);
    }
    public function getAll()
    {
        $this->countTotal();

        $sql = "SELECT 
                    ctpn.MaCTPN,
                    ctpn.MaPN,
                    ctpn.MaSP,
                    sp.TENSP,
                    sp.MALOAI,
                    lsp.TENLOAI,
                    ctpn.SoLuong AS SOLUONG,
                    ctpn.GiaNhap AS GIANHAP,
                    ctpn.ThanhTien AS THANHTIEN
                FROM ctpn
                LEFT JOIN san_pham sp ON ctpn.MaSP = sp.MASP
                LEFT JOIN loai_sp lsp ON sp.MALOAI = lsp.MALOAI
                ORDER BY ctpn.MaPN DESC
                LIMIT ? OFFSET ?";

        $this->select_prepare($sql, 'ii', $this->limit, $this->offset);
        $this->data_list = $this->fetchAll();

        return $this->data_list;
    }

    public function getPaginationInfo()
    {
        return [
            'current_page' => $this->page,
            'total_pages'  => $this->total_pages,
            'total_rows'   => $this->total_rows,
            'limit'        => $this->limit,
            'offset'       => $this->offset
        ];
    }
    public function getStartIndex()
    {
        return ($this->page - 1) * $this->limit + 1;
    }
}


$chitietObj = new ChiTietPhieuNhap(10);
$chitiet = $chitietObj->getAll();
$pageInfo = $chitietObj->getPaginationInfo();
$stt = $chitietObj->getStartIndex();
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
    <link rel="stylesheet" href="../css/indexadmin2.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>
<style>
    .success {
        color: green;
        font-weight: bold;
    }
    .pending {
        color: red;
        font-weight: bold;
    }
    .cancelled {
        color: gray;
        font-weight: bold;
    }
    .shipping {
        color: blue;
        font-weight: bold;
    }
   
</style>
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
                    <a href="trangchuadmin.php" style="color: black;">
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
                    <a href="quanlysanpham.php"style="color: black;">
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
                    <a href="quanlynhanvien.php"style="color: black;">
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

            <!-- ================ LÀM QUẢN LÝ ĐƠN HÀNG Ở ĐÂY ================= -->
            <div class="order">
                <!-- ================ LÀM BANNER ================= -->
              
                <div class="chartsBx">
                  
                </div>
            

                    <div class="details">
                        <div class="recentOrders">
                            <div class="cardHeader">
                                <h2>DANH SÁCH PHIẾU NHẬP </h2>
                            </div>
        <table>
            <thead>
                <tr style="text-align: center;">
                     <th>STT</th>
                        <th>Tên sản phẩm</th>
                        <th>Loại hàng</th>
                        <th>Số lượng </th>
                        <th>Đơn giá</th>
                        <th>Thành tiền</th>

                </tr>
            </thead>
            <tbody>
                <?php
                if (!empty($chitiet)) {
                    foreach ($chitiet as $chitiet) {
                      
                        ?>
                        <tr>
                           <td><?php echo $stt++; ?></td>
    <td><?php echo htmlspecialchars($chitiet['TENSP'] ?? ''); ?></td>
    <td><?php echo htmlspecialchars($chitiet['TENLOAI'] ?? ''); ?></td>
    <td><?php echo htmlspecialchars($chitiet['SOLUONG'] ?? ''); ?></td>
    <td><?php echo number_format($chitiet['GIANHAP'] ?? 0, 0, ',', '.'); ?> ₫</td>
    <td><?php echo number_format(($chitiet['SOLUONG'] * $chitiet['GIANHAP']) ?? 0, 0, ',', '.'); ?> ₫</td>                          
                        </tr>
                        <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td colspan="8" class="text-center text-muted">
                            Không có phiếu nào
                        </td>
                    </tr>
                    <?php
                }
                ?>
                        </tbody>
                    </table>
                    <style>
.table-wrapper {
            overflow-x: auto;
        }

        .table {
            margin-bottom: 0;
            border-collapse: separate;
            border-spacing: 0;
        }

        .table thead {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .table thead th {
            color: white;
            font-weight: 600;
            padding: 18px 12px;
            text-align: center;
            border: none;
            text-transform: uppercase;
            font-size: 13px;
            letter-spacing: 0.5px;
            vertical-align: middle;
        }

        .table tbody tr {
            border-bottom: 1px solid #e9ecef;
            transition: all 0.3s ease;
        }

        .table tbody tr:hover {
            background-color: #f8f9ff;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .table tbody td {
            padding: 16px 12px;
            vertical-align: middle;
            color: #333;
            text-align: center;
        }
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
       <!-- Phân trang -->
<div class="pagination">
    <?php
    $current = $pageInfo['current_page'];
    $total_pages = $pageInfo['total_pages'];

    // Nút "Trước"
    if ($current > 1) {
        echo "<a href='xemphieunhap.php?page=" . ($current - 1) . "'>Trước</a>";
    }

    // Các nút số trang
    for ($i = 1; $i <= $total_pages; $i++) {
        if ($i == $current) {
            echo "<span class='current'>$i</span>";
        } else {
            echo "<a href='xemphieunhap.php?page=$i'>$i</a>";
        }
    }

    // Nút "Sau"
    if ($current < $total_pages) {
        echo "<a href='xemphieunhap.php?page=" . ($current + 1) . "'>Sau</a>";
    }
    ?>
</div>
                <!-- ================ Add Charts JS ================= -->


            </div>
        </div>
    </div>
    <!-- ======= Charts JS ====== -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>
    <script src="../js/chartdonhang.js"></script>
    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>

</html>