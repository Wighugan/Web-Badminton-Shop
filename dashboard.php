<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Chuyển về trang đăng nhập
    exit();
}
echo "Chào mừng, " . $_SESSION['username'] . "! <a href='logout.php'>Đăng xuất</a>";
?>