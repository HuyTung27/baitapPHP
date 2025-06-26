<?php
session_start(); // Bắt đầu session

// Kiểm tra nếu giáo viên đã đăng nhập
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'teacher') {
    header("Location: login.php");
    exit;
}

// Kết nối cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "btl_web";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Lấy dữ liệu từ form
$answer = $_POST['answer'];
$question_id = $_POST['question_id'];

// Cập nhật câu trả lời vào bảng discuss
$stmt = $conn->prepare("UPDATE discuss SET answer = ? WHERE id_discuss = ?");
$stmt->bind_param("si", $answer, $question_id);

if ($stmt->execute()) {
    // Nếu thành công, quay lại trang thảo luận
    header("Location: TL.php");
} else {
    echo "Lỗi khi cập nhật câu trả lời: " . $conn->error;
}

// Đóng kết nối
$stmt->close();
$conn->close();
?>
