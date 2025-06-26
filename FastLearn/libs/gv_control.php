<?php
// Biến kết nối toàn cục
global $conn;

// Hàm kết nối database
function connect_db()
{
    // Gọi tới biến toàn cục $conn
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
    // Gọi tới biến toàn cục $conn
    global $conn;

    // Nếu đã kết nối thì thực hiện ngắt kết nối
    if ($conn) {
        $conn = null;
    }
}

// Hàm lấy thông tin giáo viên khi đã biết email
function get_teacher_by_email($email)
{
    global $conn;

    connect_db(); // Gọi hàm kết nối cơ sở dữ liệu

    // Câu lệnh SQL với tham số chuẩn bị (:email)
    $sql = "SELECT name, degree, major, exp_years,intro
            FROM teachers
            WHERE email = :email";

    // Chuẩn bị câu truy vấn
    $query = $conn->prepare($sql);

    // Bind giá trị email vào tham số :email
    $query->bindParam(':email', $email);

    // Thực thi câu truy vấn
    $query->execute();

    // Lấy kết quả dưới dạng mảng
    $result = $query->fetch(PDO::FETCH_ASSOC);

    // Trả kết quả về (trả về mảng chứa thông tin giáo viên)
    return $result;
}

function update_teacher_info($email, $name, $degree, $major, $exp_years)
{
    global $conn;

    connect_db(); // Gọi hàm kết nối cơ sở dữ liệu

    // Câu lệnh SQL để cập nhật thông tin giáo viên
    $sql = "UPDATE teachers
            SET name = :name, degree = :degree, major = :major, exp_years = :exp_years
            WHERE email = :email";

    // Chuẩn bị câu truy vấn
    $query = $conn->prepare($sql);

    // Bind giá trị vào tham số
    $query->bindParam(':name', $name);
    $query->bindParam(':degree', $degree);
    $query->bindParam(':major', $major);
    $query->bindParam(':exp_years', $exp_years);
    $query->bindParam(':email', $email);

    // Thực thi câu truy vấn
    if ($query->execute()) {
        return true; // Trả về true nếu cập nhật thành công
    } else {
        return false; // Trả về false nếu có lỗi xảy ra
    }
}

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
function update_intro($email, $intro)
{
    global $conn;

    connect_db(); // Gọi hàm kết nối cơ sở dữ liệu

    // Câu lệnh SQL để cập nhật thông tin giáo viên
    $sql = "UPDATE teachers
            SET intro =  :intro
            WHERE email = :email";

    // Chuẩn bị câu truy vấn
    $query = $conn->prepare($sql);

    // Bind giá trị vào tham số
    $query->bindParam(':intro', $intro);
    $query->bindParam(':email', $email);

    // Thực thi câu truy vấn
    if ($query->execute()) {
        return true; // Trả về true nếu cập nhật thành công
    } else {
        return false; // Trả về false nếu có lỗi xảy ra
    }
}
function get_id_by_email($email)
{
    global $conn;

    connect_db(); // Kết nối cơ sở dữ liệu

    $sql = "SELECT id_tc FROM teachers WHERE email=:email";

    $query = $conn->prepare($sql);
    $query->bindParam(':email', $email);

    // Thực thi câu truy vấn
    if ($query->execute()) {
        return $query->fetchColumn(); // Trả về id_tc của giáo viên
    } else {
        return false; // Trả về false nếu có lỗi
    }
}

function get_documents_by_course_id($course_id)
{
    global $conn;

    $sql = "SELECT id_doc,doc_name, doc_url, road FROM document WHERE id_cou = :course_id";
    $query = $conn->prepare($sql);
    $query->bindParam(':course_id', $course_id, PDO::PARAM_INT);

    if ($query->execute()) {
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    return false;
}
function update_url($id_doc,$new_url){
    global $conn;

    // Câu lệnh SQL để cập nhật doc_url dựa trên id_doc
    $sql = "UPDATE document SET doc_url = :new_url WHERE id_doc = :id_doc";
    
    // Chuẩn bị truy vấn
    $query = $conn->prepare($sql);
    
    // Liên kết tham số
    $query->bindParam(':new_url', $new_url, PDO::PARAM_STR);
    $query->bindParam(':id_doc', $id_doc, PDO::PARAM_INT);
    
    // Thực thi truy vấn và kiểm tra kết quả
    return $query->execute();
}
function get_courses_by_teacher($email)
{
    global $conn;

    connect_db();  // Kết nối cơ sở dữ liệu
    $teacher_id = get_id_by_email($email); // Lấy ID giáo viên

    if (!$teacher_id) {
        return false; // Trả về false nếu không tìm thấy ID giáo viên
    }

    $sql = "SELECT c.id_cou, 
            c.cou_name, 
            c.cou_time, 
            COUNT(e.id_st) AS student_count
            FROM course c
            LEFT JOIN re_course e ON c.id_cou = e.id_cou
            WHERE c.id_tc = :teacher_id
            GROUP BY c.id_cou";

    $query = $conn->prepare($sql);
    $query->bindParam(':teacher_id', $teacher_id, PDO::PARAM_INT);

    if ($query->execute()) {
        $courses = $query->fetchAll(PDO::FETCH_ASSOC);
        
        // Add documents to each course
        foreach ($courses as &$course) {
            $course['documents'] = get_documents_by_course_id($course['id_cou']);
        }
        return $courses; // Return courses with documents
    } else {
        return false; // Return false if there is an error
    }
}
