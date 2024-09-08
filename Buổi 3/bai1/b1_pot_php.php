<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bai1.css">
    <title>Form Kết Quả</title>
</head>
<body>
<div class="container">
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors = [];
    
    // Lấy dữ liệu từ form và kiểm tra tính hợp lệ
    $tenSach = htmlspecialchars(trim($_POST['tenSach']));
    $tacGia = htmlspecialchars(trim($_POST['tacGia']));
    $nhaXuatBan = htmlspecialchars(trim($_POST['nhaXuatBan']));
    $namXuatBan = htmlspecialchars(trim($_POST['namXuatBan']));

    if (empty($tenSach)) {
        $errors[] = "Tên sách là bắt buộc.";
    }
    if (empty($tacGia)) {
        $errors[] = "Tác giả là bắt buộc.";
    }
    if (empty($nhaXuatBan)) {
        $errors[] = "Nhà xuất bản là bắt buộc.";
    }
    if (empty($namXuatBan) || !is_numeric($namXuatBan) || $namXuatBan <= 0) {
        $errors[] = "Năm xuất bản phải là một số dương.";
    }

    if (empty($errors)) {
        // Hiển thị thông tin sách nếu không có lỗi
        echo "<h2>Thông Tin Sách</h2>";
        echo "<p><strong>Tên Sách:</strong> $tenSach</p>";
        echo "<p><strong>Tác Giả:</strong> $tacGia</p>";
        echo "<p><strong>Nhà Xuất Bản:</strong> $nhaXuatBan</p>";
        echo "<p><strong>Năm Xuất Bản:</strong> $namXuatBan</p>";
    } else {
        // Hiển thị lỗi nếu có
        echo "<h2>Đã xảy ra lỗi</h2>";
        echo "<ul>";
        foreach ($errors as $error) {
            echo "<li>$error</li>";
        }
        echo "</ul>";
    }
}
?>
</div>
</body>
</html>