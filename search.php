<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "mydp";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

if (isset($_GET['query'])) {
    $search = $conn->real_escape_string($_GET['query']);
    $sql = "SELECT * FROM products WHERE name LIKE '%$search%'";
    $result = $conn->query($sql);
    ?>
    <!DOCTYPE html>
    <html lang="vi">
    <head>
        <meta charset="UTF-8">
        <title>Kết quả tìm kiếm</title>
    </head>
    <body>
        <h1>Kết quả cho "<?php echo htmlspecialchars($search); ?>"</h1>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<p>" . htmlspecialchars($row['name']) . "</p>";
            }
        } else {
            echo "<p>Không tìm thấy sản phẩm nào.</p>";
        }
        ?>
        <a href="index.php">Quay lại tìm kiếm</a>
    </body>
    </html>
<?php
}
?>