<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Thảo Luận</title>
    <script src="test.js" defer></script> <!-- Kết nối file JavaScript -->
</head>
<body>
    <!-- Nội dung trang -->
    <button id="notificationButton">Xem thông báo mới</button>

    <script>
        document.getElementById("notificationButton").addEventListener("click", function() {
            // Gọi hàm hiển thị thông báo từ test.js
            showNotifications();
        });
    </script>
</body>
</html>
