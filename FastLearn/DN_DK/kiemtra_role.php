<?php
session_start();

// Kiểm tra xem người dùng có đăng nhập không
if (!isset($_SESSION['token']) || !isset($_SESSION['role'])) {
    header("Location: ../DN_DK/DN_DK.php"); // Nếu không đăng nhập, quay lại trang đăng nhập
    exit();
}

// Kiểm tra thời gian không hoạt động
$inactive = 900; // 15 phút
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $inactive) {
    session_unset(); // Xóa session
    session_destroy(); // Hủy session
    header("Location: ../DN_DK/DN_DK.php"); // Yêu cầu đăng nhập lại
    exit();
}
$_SESSION['last_activity'] = time(); // Cập nhật thời gian hoạt động mới nhất

// Kiểm tra quyền truy cập
function checkRole($requiredRole) {
    if ($_SESSION['role'] !== $requiredRole) {
        echo "Bạn không có quyền truy cập vào trang này!";
        exit();
    }
}
?>