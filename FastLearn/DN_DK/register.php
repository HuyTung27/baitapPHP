<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form
    $name = $_POST['uname'];
    $email = $_POST['mail'];
    $password = trim($_POST['pass']);

    // Mã hóa mật khẩu
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Kết nối database
    $servername = "localhost";
    $username = "root"; // thay đổi nếu cần
    $dbname = "btl_web"; // thay đổi theo tên database của bạn
    $dbpassword = ""; // thay đổi nếu cần

    try {
        // Tạo kết nối
        $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $dbpassword);
        // Thiết lập chế độ báo lỗi PDO
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Kiểm tra xem email có tồn tại trong bảng user hay không
        $stmt_check = $conn->prepare("SELECT email FROM user WHERE email = :email");
        $stmt_check->bindParam(':email', $email);
        $stmt_check->execute();

        if ($stmt_check->rowCount() > 0) {
            // Nếu email đã tồn tại
            echo "<script>alert('Email này đã được đăng ký. Vui lòng sử dụng email khác.');</script>";
        } else {
            // Nếu email không tồn tại, tiến hành thêm mới

            // Lấy mã sinh viên cuối cùng
            $sql = "SELECT id_st FROM students ORDER BY id_st DESC LIMIT 1";
            $stmt_last_id = $conn->query($sql);
            $result = $stmt_last_id->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                $last_id = $result['id_st'];

                // Tách phần số từ mã sinh viên (bỏ phần "222")
                $last_numeric_id = (int)substr($last_id, 3);

                // Tăng mã lên 1
                $new_numeric_id = $last_numeric_id + 1;

                // Tạo mã sinh viên mới với tiền tố "222"
                $new_student_id = '222' . str_pad($new_numeric_id, 6, '0', STR_PAD_LEFT);
            } else {
                // Nếu không có sinh viên nào, khởi tạo mã sinh viên đầu tiên
                $new_student_id = '222001515';  // Mã sinh viên bắt đầu
            }

            // Sử dụng Prepared Statements để thêm dữ liệu vào bảng users
            $stmt1 = $conn->prepare("INSERT INTO user (email, pass) VALUES (:email, :pass)");
            $stmt1->bindParam(':email', $email);
            $stmt1->bindParam(':pass', $hashed_password);

            // Sử dụng Prepared Statements để thêm dữ liệu vào bảng students
            $stmt2 = $conn->prepare("INSERT INTO students (id_st, email, name) VALUES (:id_st, :email, :name)");
            $stmt2->bindParam(':id_st', $new_student_id);
            $stmt2->bindParam(':email', $email);
            $stmt2->bindParam(':name', $name);

            // Thực thi câu lệnh và kiểm tra
            if ($stmt1->execute() && $stmt2->execute()) {
                echo "<script>alert('Đăng ký thành công!');</script>";
            } else {
                echo "<script>alert('Lỗi khi thêm dữ liệu. Vui lòng thử lại sau.');</script>";
            }

            // Đóng Prepared Statements
            $stmt1 = null;
            $stmt2 = null;
        }

        // Đóng Prepared Statements kiểm tra
        $stmt_check = null;
    } catch (PDOException $e) {
        echo "Kết nối thất bại: " . $e->getMessage();
    }
    header('Location: DN_DK.php');
    // Đóng kết nối
    $conn = null; // Đặt biến kết nối thành null để đóng
}
?>
