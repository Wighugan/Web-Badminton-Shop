<?php
// Đọc từ khóa tìm kiếm và trang hiện tại
$search = isset($_GET['search']) ? $_GET['search'] : '';
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$itemsPerPage = 9;  // Số sản phẩm mỗi trang

// Tính toán offset (bắt đầu của trang)
$offset = ($page - 1) * $itemsPerPage;

// Kết nối DB và truy vấn sản phẩm
$conn = new mysqli("localhost", "username", "password", "dbname");

// Lọc tìm kiếm
$searchQuery = $search ? "WHERE name LIKE '%" . $conn->real_escape_string($search) . "%'" : "";

// Lấy tổng số sản phẩm phù hợp với tìm kiếm
$sql = "SELECT COUNT(*) AS total FROM products $searchQuery";
$result = $conn->query($sql);
$totalRows = $result->fetch_assoc()['total'];

// Tính toán số trang
$totalPages = ceil($totalRows / $itemsPerPage);

// Truy vấn sản phẩm cho trang hiện tại
$sql = "SELECT * FROM products $searchQuery LIMIT $itemsPerPage OFFSET $offset";
$result = $conn->query($sql);

// Lưu dữ liệu sản phẩm vào mảng
$products = [];
while ($row = $result->fetch_assoc()) {
    $products[] = $row;
}

// Đưa dữ liệu sản phẩm sang JavaScript
echo "<script>var products = " . json_encode($products) . ";</script>";
?>

