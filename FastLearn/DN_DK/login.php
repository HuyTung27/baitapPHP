<?php
session_start(); // Bắt đầu session

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form đăng nhập
    $email = $_POST['lmail'];
    $password = trim($_POST['lpass']);

    // Kết nối cơ sở dữ liệu
    $servername = "127.0.0.1";
    $username = "root"; // thay đổi nếu cần
    $dbname = "btl_web"; // thay đổi theo tên database của bạn
    $dbpassword = ""; // thay đổi nếu cần

    try {
        // Tạo kết nối PDO
        $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $dbpassword);
        // Thiết lập chế độ báo lỗi PDO
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Truy vấn để lấy mật khẩu đã mã hóa và trạng thái khóa từ cơ sở dữ liệu
        $sql = "SELECT pass, role, is_locked FROM user WHERE email = :email";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            // Lấy dữ liệu từ kết quả truy vấn
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $hashed_password = $row['pass'];
            $role = $row['role'];
            $is_locked = $row['is_locked'];

            // Kiểm tra xem tài khoản có bị khóa hay không
            if ($is_locked == 1) {
                echo "Tài khoản của bạn đã bị khóa. Vui lòng liên hệ quản trị viên.";
            } else {
                // Kiểm tra mật khẩu nhập vào với mật khẩu đã mã hóa
                if (password_verify($password, $hashed_password)) {
                    $_SESSION['email'] = $email;
                    $_SESSION['role'] = $role;
                    // Đăng nhập thành công
                    $token = bin2hex(random_bytes(16));
                    $_SESSION['token'] = $token;
                    $_SESSION['last_activity'] = time(); // Thời gian bắt đầu phiên
                    echo "Đăng nhập thành công!";
                    if ($role == 'admin') {
                        header("Location: ../QTV/QTV.php");
                        exit();
                    } else if ($role == 'teacher') {
                        header('Location: ../GV/GV.php');
                        exit();
                    } else {
                        header('Location: ../HS/HS.php');
                        exit();
                    }
                } else {
                    echo "Mật khẩu không đúng!";
                }
            }
        } else {
            echo "Email không tồn tại!";
        }
    } catch (PDOException $e) {
        echo "Kết nối thất bại: " . $e->getMessage();
    }

    // Đóng kết nối
    $conn = null; // Không cần gọi close() như MySQLi, chỉ cần đặt biến kết nối thành null
}
?>
