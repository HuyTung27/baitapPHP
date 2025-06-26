<?php
// Biến kết nối toàn cục
global $conn;

// Hàm kết nối database
function connect_db()
{
    global $conn;

    // Nếu chưa kết nối thì thực hiện kết nối
    if (!$conn) {
        try {
            $conn = new PDO("mysql:host=localhost;dbname=btl_web", "root", "");
            // Thiết lập chế độ báo lỗi PDO
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // Thiết lập charset
            $conn->exec("set names utf8");
        } catch (PDOException $e) {
            die("Can't connect to database: " . $e->getMessage());
        }
    }
}

// Hàm ngắt kết nối
function disconnect_db()
{
    global $conn;

    // Nếu đã kết nối thì thực hiện ngắt kết nối
    if ($conn) {
        $conn = null;
    }
}

// Hàm lấy thông tin học sinh khi đã biết email
function get_student_by_email($email)
{
    global $conn;

    connect_db(); // Gọi hàm kết nối cơ sở dữ liệu

    // Câu lệnh SQL với tham số chuẩn bị (:email)
    $sql = "SELECT name, id_st, birth_d, sex
            FROM students
            WHERE email = :email";

    // Chuẩn bị câu truy vấn
    $query = $conn->prepare($sql);

    // Bind giá trị email vào tham số :email
    $query->bindParam(':email', $email);

    // Thực thi câu truy vấn
    $query->execute();

    // Lấy kết quả dưới dạng mảng
    $result = $query->fetch(PDO::FETCH_ASSOC);

    // Trả kết quả về (trả về mảng chứa thông tin học sinh)
    return $result;
}

// Hàm cập nhật thông tin học sinh
function update_student_info($email, $name,$id_st, $birth_d, $sex)
{
    global $conn;

    connect_db(); // Gọi hàm kết nối cơ sở dữ liệu

    // Câu lệnh SQL để cập nhật thông tin học sinh
    $sql = "UPDATE students
            SET name = :name,id_st = :id_st, birth_d = :birth_d, sex = :sex
            WHERE email = :email";

    // Chuẩn bị câu truy vấn
    $query = $conn->prepare($sql);

    // Bind giá trị vào tham số
    $query->bindParam(':name', $name);
    $query->bindParam(':id_st', $id_st);
    $query->bindParam(':birth_d', $birth_d);
    $query->bindParam(':sex', $sex);
    $query->bindParam(':email', $email);

    // Thực thi câu truy vấn
    if ($query->execute()) {
        return true; // Trả về true nếu cập nhật thành công
    } else {
        return false; // Trả về false nếu có lỗi xảy ra
    }
}

// Hàm thay đổi mật khẩu học sinh
function change_pass($email, $old_password, $new_password)
{
    global $conn;

    connect_db(); // Gọi hàm kết nối cơ sở dữ liệu

    $sql = "SELECT pass FROM user WHERE email = :email";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        // Lấy mật khẩu đã mã hóa từ cơ sở dữ liệu
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $hashed_password = $row['pass'];

        // Kiểm tra mật khẩu nhập vào với mật khẩu đã mã hóa
        if (password_verify($old_password, $hashed_password)) {
            // Mã hóa mật khẩu mới
            $hashed_password_new = password_hash($new_password, PASSWORD_DEFAULT);

            $sql = 'UPDATE user
                    SET pass = :pass 
                    WHERE email = :email';
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':pass', $hashed_password_new);
            $stmt->execute();

            // Trả về thông báo thành công
            return ['success' => true, 'message' => 'Đổi mật khẩu thành công!'];
        } else {
            // Trả về thông báo lỗi mật khẩu không đúng
            return ['success' => false, 'message' => 'Mật khẩu hiện tại không đúng!'];
        }
    } else {
        // Trả về thông báo lỗi email không tồn tại
        return ['success' => false, 'message' => 'Email không tồn tại!'];
    }
}

// Hàm lấy id_st của học sinh khi đã biết email
function get_student_id_by_email($email)
{
    global $conn;

    connect_db(); // Kết nối cơ sở dữ liệu

    $sql = "SELECT id_st FROM students WHERE email=:email";

    $query = $conn->prepare($sql);
    $query->bindParam(':email', $email);

    // Thực thi câu truy vấn
    if ($query->execute()) {
        return $query->fetchColumn(); // Trả về id_st của học sinh
    } else {
        return false; // Trả về false nếu có lỗi
    }
}

function get_teachers() {
    global $conn;
    connect_db();

    $sql = "SELECT name, intro, id_tc FROM teachers"; // Giả sử bảng giảng viên là "teachers"
    $query = $conn->prepare($sql);
    $query->execute();

    // Lấy tất cả thông tin giảng viên
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

function get_id($email) {
    global $conn;
    connect_db();

    // Truy vấn để lấy id_st của học sinh dựa trên email
    $sql = "SELECT id_st FROM students WHERE email = :email LIMIT 1";
    
    $query = $conn->prepare($sql);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->execute();

    // Trả về ID của học sinh, nếu không tìm thấy sẽ trả về false
    return $query->fetchColumn();
}

function add_discussion($student_id, $teacher_id, $question) {
    global $conn;
    connect_db();

    // Truy vấn SQL để thêm thông tin vào bảng discuss
    $sql = "INSERT INTO discuss (id_st, id_tc, question) VALUES (:student_id, :teacher_id, :question)";

    $query = $conn->prepare($sql);
    
    // Gán các giá trị vào các tham số truy vấn
    $query->bindParam(':student_id', $student_id, PDO::PARAM_INT);
    $query->bindParam(':teacher_id', $teacher_id, PDO::PARAM_INT);
    $query->bindParam(':question', $question, PDO::PARAM_STR);

    // Thực thi truy vấn và kiểm tra kết quả
    if ($query->execute()) {
        return true; // Trả về true nếu thêm thành công
    } else {
        return false; // Trả về false nếu có lỗi xảy ra
    }
}

function add_feedback($student_id, $feedback ) {
    global $conn;
    connect_db();

    // Truy vấn SQL để thêm thông tin vào bảng discuss bao gồm cả feedback
    $sql = "INSERT INTO feedback (id_st, feedback) VALUES (:student_id, :feedback)";

    $query = $conn->prepare($sql);
    
    // Gán các giá trị vào các tham số truy vấn
    $query->bindParam(':student_id', $student_id, PDO::PARAM_INT);
    $query->bindParam(':feedback', $feedback, PDO::PARAM_STR);

    // Thực thi truy vấn và kiểm tra kết quả
    if ($query->execute()) {
        return true; // Trả về true nếu thêm thành công
    } else {
        return false; // Trả về false nếu có lỗi xảy ra
    }
}