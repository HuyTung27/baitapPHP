<?php
header('Content-Type: text/plain'); // Đặt kiểu nội dung
$notifications = [];
if (file_exists('noti.txt')) {
    $notifications = file('noti.txt', FILE_IGNORE_NEW_LINES);
}

if (!empty($notifications)) {
    // Tạo chuỗi thông báo
    $alertMessage = implode("\n", $notifications); // Nối các thông báo bằng dấu xuống dòng
    echo $alertMessage; // Gửi thông báo về phía client
} else {
    echo ''; // Trả về chuỗi rỗng nếu không có thông báo
}
?>
