<!DOCTYPE html>
<html lang="en">
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mydp";

// Kết nối đến MySQL
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if (!$conn) {
	die("Kết nối thất bại: " . mysqli_connect_error());
}




$sql = "SELECT users.id AS makh, users.fullname AS tenkh, COUNT(orders.id) AS sohoadon, SUM(orders.total) AS tongtien 
        FROM users 
        LEFT JOIN orders ON users.id = orders.user_id 
        GROUP BY users.id, users.fullname";

$result = $conn->query($sql);


?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - MMB - Shop Bán Đồ Cầu Lông</title>
    <link href='../img/logo.png' rel='icon' type='image/x-icon' />
        <!-- ======= Styles ====== -->
    <link rel="stylesheet" href="../css/indexadmin1.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">


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
                    <a href="thongke.php"style="color: black;"id="active">
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
                <div class="search">
                    <label>
                        <input type="text" placeholder="Tìm kiếm chức năng quản trị">
                        <a href=" "><ion-icon name="search-outline"></ion-icon></a>
                    </label>
                </div>
            </div>
   
   

   
   
    <div class="banner">

        <div class="date">
            <label for="start">Từ ngày: </label>
            <input type="date" id="start" name="start" value="2024-11-24" min="2018-01-01" max="2024-12-31">
            <label for="start">đến </label>
            <input type="date" id="end" name="end" value="2024-11-30" min="2018-01-01" max="2024-12-31">
            <a href ="" id="timnguoidung2" >

                <i class="fa fa-search"></i> 
    
            </a>  
        </div>
      
    
        
    
        <select id="option">
            <option>Yonex</option>
            <option>Lining</option>
            <option >Victor</option>
            <option >Mizuno</option>
            <option>VNB</option>
            <option>Apacs</option>


           

        </select>

    
        <form action="">
            <input id="timnguoidung" type="text" placeholder="Tên sản phẩm cần tìm">

            
               
          
               
            <a href ="" id="timnguoidung1" >

                <i class="fa fa-search"></i> 

            </a>  
        </form>
    </div>
            

    

      
       

   
<div class="details">
    <div class="recentOrders">
        <div class="cardHeader">
            <h2>Thống kê theo mặt hàng</h2>
            
        </div>
    <table>
        <thead>
            <tr>
                <td>Mã mặt hàng</td>
                <td>Tên mặt hàng</td>
                <td>Số Lượng bán ra</td>
                <td>Tổng tiền thu được</td>
                <td>Xem hóa đơn</td>
                <td></td>
            </tr>
        </thead>
  
        <tbody>
            <tr>
                <td>MH001</td>
                <td>Yonex</a></td>
                <td>200</td>
                <td>15.199.000 VND</td>
                <td> <a href="xemhoadon.php">Xem</td></a>
                <td></td>
            </tr>
            <tr>
                <td>MH002</td>
                <td> Lining </a></td>
                <td>100</td>
                <td>15.199.000 VND</td>
                <td> <a href="xemhoadon.php">Xem</td></a>
                <td></td>
            </tr>
            <tr>
                <td>MH003</td>
                <td>Victor </a></td>
                <td>100</td>
                <td>15.199.000 VND</td>
                <td> <a href="xemhoadon.php">Xem</td></a>
                <td></td>
            </tr>
            <tr>
                <td>MH004</td>
                <td>VNB </a></td>
                <td>50</td>
                <td>15.199.000 VND</td>
                <td> <a href="xemhoadon.php">Xem</td></a>
                <td></td>
            </tr>
            <tr>
                <td>MH005</td>
                <td>Mizuno</a></td>
                <td>100</td>
                <td>15.199.000 VND</td>
                <td> <a href="xemhoadon.php">Xem</td></a>
                <td></td>
            </tr>
            <tr>
                <td>MH005</td>
                <td>Apacs</a></td>
                <td>100</td>
                <td>15.199.000 VND</td>
                <td> <a href="xemhoadon.php">Xem</td></a>
                <td></td>
            </tr>
           
        </tbody>
  
    </table>
   
  
  
  <script>
  
        ten = document.getElementById("ten");
        loai = document.getElementById("loai");
        tenSp = document.getElementById("tenSp");
        loaiSp = document.getElementById("loaiSp");
        function checkTen(){
            tenSp.style.display="block";
            loaiSp.style.display="none";
        }
  
        function checkLoai(){
            tenSp.style.display="none";
            loaiSp.style.display="block";
        }
          
  </script>
  <div class="pagination">
    <li class="hientai">1</li>
    <li><a href="thongke.php" style="color: black;">2</a></li></a> 
    <li><a href="thongke.php" style="color: black;" >NEXT</a></li>
  </div>
  
  </div>
  </div>

  <div class="details">
    <div class="recentOrders">
        <div class="cardHeader">
            <h2>Thống kê theo khách hàng</h2>
        </div>
    <table>
        <thead>
            <tr>
                <td>Mã khách hàng</td>
                <td>Tên khách hàng</td>
                <td>Tổng số hóa đơn</td>
                <td>Tổng tiền</td>
                <td>Xem hóa đơn</td>
                <td></td>
            </tr>
        </thead>
  
        <tbody>
        <?php while($row = $result->fetch_assoc()) { ?>
<tr>
    <td><?= 'KH00'.$row['makh'] ?></td>
    <td><?= $row['tenkh'] ?></td>
    <td><?= $row['sohoadon'] ?></td>
    <td><?= number_format($row['tongtien'], 0, ',', '.') ?> VND</td>
    <td><a href="xemhoadon.php?id=<?= $row['makh'] ?>">Xem</a></td>
</tr>
<?php } ?>
            
           
        </tbody>
  
    </table>
   
  
  
  <script>
  
        ten = document.getElementById("ten");
        loai = document.getElementById("loai");
        tenSp = document.getElementById("tenSp");
        loaiSp = document.getElementById("loaiSp");
        function checkTen(){
            tenSp.style.display="block";
            loaiSp.style.display="none";
        }
  
        function checkLoai(){
            tenSp.style.display="none";
            loaiSp.style.display="block";
        }
          
  </script>
  <div class="pagination">
    <li class="hientai">1</li>
    <li><a href="thongke.html" style="color: black;">2</a></li></a> 
    <li><a href="thongke.html" style="color: black;" >NEXT</a></li>
  </div>
  
  </div>
  </div>

  <div class="details">
    <div class="recentOrders">
        <div class="cardHeader">
            <h2>Top 5 Khách Hàng Mua Nhiều Nhất</h2>
        </div>
            <table>
                <thead>
                    <tr>
                        <td>STT</td>
                        <td>Tên khách hàng</td>
                        <td>Số đơn hàng</td>
                        <td>Mã đơn hàng</td>
                        <td>Tổng tiền</td>
                        <td> Xem hóa đơn</td>

                    </tr>
                </thead>
                <tbody>
                    <?php
                $sql = "SELECT users.id AS makh, users.fullname AS tenkh, COUNT(orders.id) AS sohoadon, SUM(orders.total) AS tongtien 
        FROM users 
        LEFT JOIN orders ON users.id = orders.user_id 
        GROUP BY users.id, users.fullname 
        ORDER BY sohoadon DESC 
        LIMIT 5";

$result = $conn->query($sql);
?>
                   <tbody>
<?php while($row = $result->fetch_assoc()) { ?>
<tr>
    <td><?= 'KH00'.$row['makh'] ?></td>
    <td><?= $row['tenkh'] ?></td>
    
    <td><?= $row['sohoadon'] ?></td>
    <td>  </td>
    <td><?= number_format($row['tongtien'], 0, ',', '.') ?> VND</td>
    <td><a href="xemhoadon.php?id=<?= $row['makh'] ?>">Xem</a></td>
</tr>
<?php } ?>
</tbody>

                </tbody>
            </table>
        </div>
    </div>

    <div class="details">
        <div class="recentOrders">
            <div class="cardHeader">
                <h2>Sản phẩm bán chạy nhất</h2>
                
            </div>
        <table>
            <thead>
                <tr>
                    <td>Mã mặt hàng</td>
                    <td>Tên mặt hàng</td>
                    <td>Ảnh</td>
                    <td>Số Lượng bán ra</td>
                    <td>Tổng tiền thu được</td>
                    <td></td>
                </tr>
            </thead>
      
            <tbody>
                <tr>
                    <td>MH001</td>
                    <td>Vợt Yonex Astrox 100zz</a></td>
                                                <td><img src="../img/product-1.jpg"></td>
                
                    <td>200</td>
                    <td>150.199.000 VND</td>
                    <td></td>
                </tr>
                
               
            </tbody>
      
        </table>
       
      
      
      
      
      </div>
      </div>
      <div class="details">
        <div class="recentOrders">
            <div class="cardHeader">
                <h2>Sản phẩm bán ế nhất</h2>
                
            </div>
        <table>
            <thead>
                <tr>
                    <td>Mã mặt hàng</td>
                    <td>Tên mặt hàng</td>
                    <td>Ảnh</td>
                    <td>Số Lượng bán ra</td>
                    <td>Tổng tiền thu được</td>
                    <td></td>
                </tr>
            </thead>
      
            <tbody>
                <tr>
                    <td>MH002</td>
                    <td>Vợt Lining Calibar 900B</a></td>
                    <td><img src="../img/product-8.jpg"></td>
                
                    <td>50</td>
                    <td>15.199.000 VND</td>
                    <td></td>
                </tr>
                
               
            </tbody>
      
        </table>
       
      
      
      
      
      </div>
      </div>
  
    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>

</html>