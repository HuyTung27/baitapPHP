<?php
$servername = "localhost";
$dbname = "employee_db"; 
$username = "root";  
$password = "";      

try {
    // Tạo kết nối PDO
    $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    
    // Thiết lập chế độ lỗi PDO thành ngoại lệ
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Tắt tự động commit để kiểm soát các giao dịch
    $conn->setAttribute(PDO::ATTR_AUTOCOMMIT, false);

    echo "Connected successfully"; 
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
