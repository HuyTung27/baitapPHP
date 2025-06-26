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

// Hàm lấy tất cả học sinh
function get_all_students()
{
    // Gọi tới biến toàn cục $conn
    global $conn;

    // Hàm kết nối
    connect_db();

    // Câu truy vấn lấy tất cả sinh viên
    $sql = "SELECT id_st, name, email, sex, birth_d FROM students";

    // Thực hiện câu truy vấn
    $query = $conn->query($sql);

    // Lấy kết quả dưới dạng mảng
    $result = $query->fetchAll(PDO::FETCH_ASSOC);

    // Trả kết quả về
    return $result;
}

// Hàm lấy tất cả giảng viên
function get_all_teachers()
{
    // Gọi tới biến toàn cục $conn
    global $conn;

    // Hàm kết nối
    connect_db();

    // Câu truy vấn lấy tất cả giảng viên
    $sql = "SELECT id_tc, name, email, degree, major, exp_years FROM teachers";

    // Thực hiện câu truy vấn
    $query = $conn->query($sql);

    // Lấy kết quả dưới dạng mảng
    $result = $query->fetchAll(PDO::FETCH_ASSOC);

    // Trả kết quả về
    return $result;
}

function get_all_course()
{
    global $conn;

    connect_db();

    $sql = "  SELECT course.id_cou,course.cou_name, teachers.name AS teacher_name, course.cou_des,course.cou_time,course.cost
            FROM course
            JOIN teachers ON course.id_tc = teachers.id_tc;";

    // Thực hiện câu truy vấn
    $query = $conn->query($sql);

    // Lấy kết quả dưới dạng mảng
    $result = $query->fetchAll(PDO::FETCH_ASSOC);

    // Trả kết quả về
    return $result;
}
//Hàm thêm khóa học
function add_course($course_name, $teacher_email, $description, $time,$cost)
{
    // Gọi tới biến toàn cục $conn
    global $conn;

    // Kết nối cơ sở dữ liệu (giả định hàm connect_db đã kết nối và trả về đối tượng PDO)
    connect_db();

    try {
        // Bắt đầu transaction để đảm bảo tính toàn vẹn dữ liệu
        $conn->beginTransaction();

        // Kiểm tra email giảng viên đã tồn tại
        $stmt_check = $conn->prepare("SELECT id_tc FROM teachers WHERE email = :email");
        $stmt_check->bindParam(':email', $teacher_email);
        $stmt_check->execute();

        $teacher_id = $stmt_check->fetchColumn();

        if (!$teacher_id) {
            // Nếu email không tồn tại trong bảng teachers
            echo "<script>alert('Email giảng viên này chưa được đăng ký. Vui lòng sử dụng email khác.');</script>";
            return false;
        }

        // Lấy mã khóa học cuối cùng
        $sql_last_id = "SELECT id_cou FROM course ORDER BY id_cou DESC LIMIT 1";
        $stmt_last_id = $conn->query($sql_last_id);
        $last_id = $stmt_last_id->fetchColumn();

        if ($last_id) {
            // Tách phần số từ mã khóa học (bỏ phần "222")
            $last_numeric_id = (int)substr($last_id, 4);

            // Tăng mã lên 1
            $new_numeric_id = $last_numeric_id + 1;

            // Tạo mã khóa học mới với tiền tố "222"
            $new_course_id = '2024' . str_pad($new_numeric_id, 4, '0', STR_PAD_LEFT);
        } else {
            // Nếu không có khóa học nào, khởi tạo mã khóa học đầu tiên
            $new_course_id = '20240410';  // Mã khóa học bắt đầu
        }

        // Thêm dữ liệu vào bảng course
        $stmt = $conn->prepare("INSERT INTO course (id_cou, cou_name, id_tc, cou_des, cou_time,cost) 
                                VALUES (:id_cou, :name_cou, :id_tc, :description, :time, :cost)");
        $stmt->bindParam(':id_cou', $new_course_id);
        $stmt->bindParam(':name_cou', $course_name);
        $stmt->bindParam(':id_tc', $teacher_id);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':time', $time);
        $stmt->bindParam(':cost', $cost);

        // Thực thi câu lệnh
        if ($stmt->execute()) {
            // Nếu tất cả đều thành công, commit transaction
            $conn->commit();
            echo "<script>alert('Thêm khóa học thành công!');</script>";
            return true;
        } else {
            // Nếu có lỗi, rollback transaction
            $conn->rollBack();
            echo "<script>alert('Lỗi khi thêm khóa học. Vui lòng thử lại sau!');</script>";
            return false;
        }
    } catch (Exception $e) {
        // Nếu có lỗi trong quá trình thực thi, rollback transaction
        $conn->rollBack();
        echo "<script>alert('Lỗi: " . $e->getMessage() . "');</script>";
        return false;
    }
}


// Hàm thêm học sinh
function add_student($student_name, $student_mail, $student_sex, $student_birthday)
{
    // Gọi tới biến toàn cục $conn
    global $conn;

    // Kết nối cơ sở dữ liệu (giả định hàm connect_db đã kết nối và trả về đối tượng PDO)
    connect_db();

    try {
        // Bắt đầu transaction để đảm bảo tính toàn vẹn dữ liệu
        $conn->beginTransaction();

        // Kiểm tra email đã tồn tại
        $stmt_check = $conn->prepare("SELECT email FROM user WHERE email = :email");
        $stmt_check->bindParam(':email', $student_mail);
        $stmt_check->execute();

        if ($stmt_check->rowCount() > 0) {
            // Nếu email đã tồn tại
            return "Email này đã được đăng ký. Vui lòng sử dụng email khác.";
        }

        // Mã hóa mật khẩu (ở đây tạm dùng email làm mật khẩu, nhưng bạn có thể thay đổi theo yêu cầu)
        $hashed_password = password_hash($student_mail, PASSWORD_DEFAULT);

        // Lấy mã sinh viên cuối cùng
        $sql_last_id = "SELECT id_st FROM students ORDER BY id_st DESC LIMIT 1";
        $stmt_last_id = $conn->query($sql_last_id);
        $last_id = $stmt_last_id->fetchColumn();

        if ($last_id) {
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

        // Thêm dữ liệu vào bảng user
        $stmt1 = $conn->prepare("INSERT INTO user (email, pass) VALUES (:email, :pass)");
        $stmt1->bindParam(':email', $student_mail);
        $stmt1->bindParam(':pass', $hashed_password);

        // Thêm dữ liệu vào bảng students
        $stmt2 = $conn->prepare("INSERT INTO students (id_st, email, name, sex, birth_d) 
                                 VALUES (:id_st, :email, :name, :sex, :birthday)");
        $stmt2->bindParam(':id_st', $new_student_id);
        $stmt2->bindParam(':email', $student_mail);
        $stmt2->bindParam(':name', $student_name);
        $stmt2->bindParam(':sex', $student_sex);
        $stmt2->bindParam(':birthday', $student_birthday);

        // Thực thi câu lệnh
        if ($stmt1->execute() && $stmt2->execute()) {
            // Nếu tất cả đều thành công, commit transaction
            $conn->commit();
            return true; // Thành công
        } else {
            // Nếu có lỗi, rollback transaction
            $conn->rollBack();
            return "Lỗi khi thêm học sinh. Vui lòng thử lại!";
        }
    } catch (Exception $e) {
        // Nếu có lỗi trong quá trình thực thi, rollback transaction
        $conn->rollBack();
        return "Lỗi: " . $e->getMessage();
    }
}


function add_teacher($teacher_name, $teacher_mail, $teacher_degree, $teacher_major)
{
    // Gọi tới biến toàn cục $conn
    global $conn;

    // Kết nối cơ sở dữ liệu (giả định hàm connect_db đã kết nối và trả về đối tượng PDO)
    connect_db();

    try {
        // Bắt đầu transaction để đảm bảo tính toàn vẹn dữ liệu
        $conn->beginTransaction();

        // Kiểm tra email đã tồn tại
        $stmt_check = $conn->prepare("SELECT email FROM user WHERE email = :email");
        $stmt_check->bindParam(':email', $teacher_mail);
        $stmt_check->execute();

        if ($stmt_check->rowCount() > 0) {
            // Nếu email đã tồn tại
            echo "<script>alert('Email này đã được đăng ký. Vui lòng sử dụng email khác.');</script>";
            return false;
        }

        // Mã hóa mật khẩu (ở đây tạm dùng email làm mật khẩu, nhưng bạn có thể thay đổi theo yêu cầu)
        $hashed_password = password_hash($teacher_mail, PASSWORD_DEFAULT);

        // Lấy mã giảng viên cuối cùng
        $sql_last_id = "SELECT id_tc FROM teachers ORDER BY id_tc DESC LIMIT 1";
        $stmt_last_id = $conn->query($sql_last_id);
        $last_id = $stmt_last_id->fetchColumn();

        if ($last_id) {
            // Tách phần số từ mã giảng viên (bỏ phần "214")
            $last_numeric_id = (int)substr($last_id, 3);

            // Tăng mã lên 1
            $new_numeric_id = $last_numeric_id + 1;

            // Tạo mã giảng viên mới với tiền tố "214"
            $new_teacher_id = '214' . str_pad($new_numeric_id, 6, '0', STR_PAD_LEFT);
        } else {
            // Nếu không có giảng viên nào, khởi tạo mã giảng viên đầu tiên
            $new_teacher_id = '214000001';  // Mã giảng viên bắt đầu
        }

        // Thêm dữ liệu vào bảng user
        $stmt1 = $conn->prepare("INSERT INTO user (email, pass,role) VALUES (:email, :pass,'teacher')");
        $stmt1->bindParam(':email', $teacher_mail);
        $stmt1->bindParam(':pass', $hashed_password);

        // Thêm dữ liệu vào bảng teachers
        $stmt2 = $conn->prepare("INSERT INTO teachers (id_tc, email, name, degree, major) 
                                 VALUES (:id_tc, :email, :name, :degree, :major)");
        $stmt2->bindParam(':id_tc', $new_teacher_id);
        $stmt2->bindParam(':email', $teacher_mail);
        $stmt2->bindParam(':name', $teacher_name);
        $stmt2->bindParam(':degree', $teacher_degree);
        $stmt2->bindParam(':major', $teacher_major);

        // Thực thi câu lệnh
        if ($stmt1->execute() && $stmt2->execute()) {
            // Nếu tất cả đều thành công, commit transaction
            $conn->commit();
            echo "<script>alert('Đăng ký thành công!');</script>";
            return true;
        } else {
            // Nếu có lỗi, rollback transaction
            $conn->rollBack();
            echo "<script>alert('Lỗi khi đăng ký. Vui lòng thử lại sau!');</script>";
            return false;
        }
    } catch (Exception $e) {
        // Nếu có lỗi trong quá trình thực thi, rollback transaction
        $conn->rollBack();
        echo "<script>alert('Lỗi: " . $e->getMessage() . "');</script>";
        return false;
    }
}

function delete_st($id_st)
{
    // Gọi tới biến toàn cục $conn
    global $conn;

    // Hàm kết nối
    connect_db();

    try {
        // Bắt đầu giao dịch
        $conn->beginTransaction();

        // Truy vấn email từ bảng students dựa vào id_st
        $sql_email = "SELECT email FROM students WHERE id_st = :id";
        $stmt_email = $conn->prepare($sql_email);
        $stmt_email->bindParam(':id', $id_st, PDO::PARAM_INT);
        $stmt_email->execute();

        // Lấy email từ kết quả truy vấn
        $email = $stmt_email->fetchColumn();

        if ($email === false) {
            // Nếu không tìm thấy email, hủy giao dịch và trả về false
            $conn->rollBack();
            return false;
        }

        // Câu truy vấn cập nhật trạng thái khóa tài khoản trong bảng user
        $sql_user = "UPDATE user SET is_locked = 1 WHERE email = :mail";
        $stmt_user = $conn->prepare($sql_user);
        $stmt_user->bindParam(':mail', $email, PDO::PARAM_STR);
        $stmt_user->execute();

        // Xác nhận giao dịch
        $conn->commit();

        return true;
    } catch (Exception $e) {
        // Nếu có lỗi, hủy giao dịch
        $conn->rollBack();
        return false;
    }
}

function delete_tc($id_tc)
{
    // Gọi tới biến toàn cục $conn
    global $conn;

    // Hàm kết nối
    connect_db();

    try {
        // Bắt đầu giao dịch
        $conn->beginTransaction();

        // Truy vấn email từ bảng teachers dựa vào id_tc
        $sql_email = "SELECT email FROM teachers WHERE id_tc = :id";
        $stmt_email = $conn->prepare($sql_email);
        $stmt_email->bindParam(':id', $id_tc, PDO::PARAM_INT);
        $stmt_email->execute();

        // Lấy email từ kết quả truy vấn
        $email = $stmt_email->fetchColumn();

        if ($email === false) {
            // Nếu không tìm thấy email, hủy giao dịch và trả về false
            $conn->rollBack();
            return false;
        }

        // Câu truy vấn cập nhật trạng thái khóa tài khoản trong bảng user
        $sql_user = "UPDATE user SET is_locked = 1 WHERE email = :mail";
        $stmt_user = $conn->prepare($sql_user);
        $stmt_user->bindParam(':mail', $email, PDO::PARAM_STR);
        $stmt_user->execute();

        // Xác nhận giao dịch
        $conn->commit();

        return true;
    } catch (Exception $e) {
        // Nếu có lỗi, hủy giao dịch
        $conn->rollBack();
        // Ghi log lỗi để kiểm tra (nếu cần)
        error_log("Khóa tài khoản giảng viên thất bại: " . $e->getMessage());
        return false;
    }
}

function update_st($id_st, $name_st, $mail_st, $gender_st, $birth_d)
{
    // Gọi tới biến toàn cục $conn
    global $conn;

    // Hàm kết nối
    connect_db();

    $sql = "UPDATE students SET ";
}
function update_student($student_name, $student_mail, $student_sex, $student_birthday)
{
    // Gọi tới biến toàn cục $conn
    global $conn;

    // Kết nối cơ sở dữ liệu
    connect_db();

    try {
        // Bắt đầu transaction
        $conn->beginTransaction();

        // Câu truy vấn cập nhật thông tin học sinh trong bảng students
        $sql_update_students = "UPDATE students SET name = :name, sex = :sex, birth_d = :birthday WHERE email = :mail";
        $stmt_students = $conn->prepare($sql_update_students);
        $stmt_students->bindParam(':mail', $student_mail);
        $stmt_students->bindParam(':name', $student_name);
        $stmt_students->bindParam(':sex', $student_sex);
        $stmt_students->bindParam(':birthday', $student_birthday);

        // Thực thi câu lệnh
        if ($stmt_students->execute()) {
            // Nếu cập nhật thành công, commit transaction
            $conn->commit();
            echo "<script>alert('Cập nhật thông tin học sinh thành công!');</script>";
            return true;
        } else {
            // Nếu có lỗi, rollback transaction
            $conn->rollBack();
            echo "<script>alert('Lỗi khi cập nhật. Vui lòng thử lại sau!');</script>";
            return false;
        }
    } catch (Exception $e) {
        // Nếu có lỗi, rollback transaction
        $conn->rollBack();
        echo "<script>alert('Lỗi: " . $e->getMessage() . "');</script>";
        return false;
    }
}
function update_teacher($teacher_name, $teacher_mail, $teacher_degree, $teacher_major, $teacher_experience)
{
    // Gọi tới biến toàn cục $conn
    global $conn;

    // Kết nối cơ sở dữ liệu
    connect_db();

    try {
        // Bắt đầu transaction
        $conn->beginTransaction();

        // Câu truy vấn cập nhật thông tin giảng viên trong bảng teachers
        $sql_update_teacher = "UPDATE teachers SET name = :name, degree = :degree, major = :major, exp_years = :experience WHERE email = :mail";
        $stmt_teacher = $conn->prepare($sql_update_teacher);
        $stmt_teacher->bindParam(':mail', $teacher_mail);
        $stmt_teacher->bindParam(':name', $teacher_name);
        $stmt_teacher->bindParam(':degree', $teacher_degree);
        $stmt_teacher->bindParam(':major', $teacher_major);
        $stmt_teacher->bindParam(':experience', $teacher_experience);

        // Thực thi câu lệnh
        if ($stmt_teacher->execute()) {
            // Nếu cập nhật thành công, commit transaction
            $conn->commit();
            echo "<script>alert('Cập nhật thông tin giảng viên thành công!');</script>";
            return true;
        } else {
            // Nếu có lỗi, rollback transaction
            $conn->rollBack();
            echo "<script>alert('Lỗi khi cập nhật. Vui lòng thử lại sau!');</script>";
            return false;
        }
    } catch (Exception $e) {
        // Nếu có lỗi, rollback transaction
        $conn->rollBack();
        echo "<script>alert('Lỗi: " . $e->getMessage() . "');</script>";
        return false;
    }
}

function get_students_by_email($email)
{
    // Gọi tới biến toàn cục $conn
    global $conn;

    // Hàm kết nối (nếu cần thiết)
    connect_db(); // Nếu bạn đã kết nối ở nơi khác, có thể không cần gọi lại

    // Câu truy vấn lấy tất cả sinh viên
    $sql = "SELECT id_st, name, email, sex, birth_d FROM students WHERE email = :email"; // Xóa khoảng trắng trước ':email'
    
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function get_students_by_name($name)
{
    // Gọi tới biến toàn cục $conn
    global $conn;

    
    connect_db(); 

    // Câu truy vấn lấy tất cả sinh viên
    $sql = "SELECT id_st, name, email, sex, birth_d FROM students WHERE name LIKE :name"; 
    
    $stmt = $conn->prepare($sql);
    $search_name='%' . $name;
    $stmt->bindParam(':name', $search_name);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function get_students_by_gender($gender)
{
    // Gọi tới biến toàn cục $conn
    global $conn;

    
    connect_db(); 

    // Câu truy vấn lấy tất cả sinh viên
    $sql = "SELECT id_st, name, email, sex, birth_d FROM students WHERE sex = :sex"; 
    
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':sex', $gender);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function get_course_by_name($name)
{
    global $conn;

    connect_db();

    $sql = "  SELECT course.id_cou,course.cou_name, teachers.name AS teacher_name, course.cou_des,course.cou_time,course.cost
            FROM course
            JOIN teachers ON course.id_tc = teachers.id_tc
            where course.cou_name like :name";

    $stmt = $conn->prepare($sql);
    $search_name ='%' . $name . '%';
    $stmt->bindParam(':name',$search_name);
    $stmt->execute();

    // Trả kết quả về
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function get_course_by_email($email)
{
    global $conn;

    connect_db();

    $sql = "  SELECT course.id_cou,course.cou_name, teachers.name AS teacher_name, course.cou_des,course.cou_time,course.cost
            FROM course
            JOIN teachers ON course.id_tc = teachers.id_tc
            where teachers.email = :email";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':email',$email);
    $stmt->execute();

    // Trả kết quả về
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function get_course_by_time($time)
{
    global $conn;

    connect_db();

    $sql = "  SELECT course.id_cou,course.cou_name, teachers.name AS teacher_name, course.cou_des,course.cou_time,course.cost
            FROM course
            JOIN teachers ON course.id_tc = teachers.id_tc
            where course.cou_time = :time";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':time',$time);
    $stmt->execute();

    // Trả kết quả về
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function get_course_by_cost($cost)
{
    global $conn;

    connect_db();

    $sql = "  SELECT course.id_cou,course.cou_name, teachers.name AS teacher_name, course.cou_des,course.cou_time,course.cost
            FROM course
            JOIN teachers ON course.id_tc = teachers.id_tc
            where course.cost = :cost";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':cost',$cost);
    $stmt->execute();

    // Trả kết quả về
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function get_teacher_by_name($name)
{
    // Gọi tới biến toàn cục $conn
    global $conn;

    // Hàm kết nối
    connect_db();

    // Câu truy vấn lấy tất cả giảng viên
    $sql = "SELECT id_tc, name, email, degree, major, exp_years FROM teachers where name like :name";

    $stmt =$conn->prepare($sql);
    $search_name='%' . $name;
    $stmt->bindParam(':name',$search_name);
    $stmt->execute();

    // Trả kết quả về
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function get_teacher_by_mail($email)
{
    // Gọi tới biến toàn cục $conn
    global $conn;

    // Hàm kết nối
    connect_db();

    // Câu truy vấn lấy tất cả giảng viên
    $sql = "SELECT id_tc, name, email, degree, major, exp_years FROM teachers where email = :mail";

    $stmt =$conn->prepare($sql);
    $stmt->bindParam(':mail',$email);
    $stmt->execute();

    // Trả kết quả về
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function get_teacher_by_degree($degree)
{
    // Gọi tới biến toàn cục $conn
    global $conn;

    // Hàm kết nối
    connect_db();

    // Câu truy vấn lấy tất cả giảng viên
    $sql = "SELECT id_tc, name, email, degree, major, exp_years FROM teachers where degree = :degree";

    $stmt =$conn->prepare($sql);
    $stmt->bindParam(':degree',$degree);
    $stmt->execute();

    // Trả kết quả về
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function get_teacher_by_major($major)
{
    // Gọi tới biến toàn cục $conn
    global $conn;

    // Hàm kết nối
    connect_db();

    // Câu truy vấn lấy tất cả giảng viên
    $sql = "SELECT id_tc, name, email, degree, major, exp_years FROM teachers where major = :major";

    $stmt =$conn->prepare($sql);
    $stmt->bindParam(':major',$major);
    $stmt->execute();

    // Trả kết quả về
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function get_teacher_by_exp($exp)
{
    // Gọi tới biến toàn cục $conn
    global $conn;

    // Hàm kết nối
    connect_db();

    // Câu truy vấn lấy tất cả giảng viên
    $sql = "SELECT id_tc, name, email, degree, major, exp_years FROM teachers where exp_years = :exp";

    $stmt =$conn->prepare($sql);
    $stmt->bindParam(':exp',$exp);
    $stmt->execute();

    // Trả kết quả về
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function change_pass($email,$old_password,$new_password){
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
function get_locked_students()
{
    // Gọi tới biến toàn cục $conn
    global $conn;

    // Hàm kết nối (nếu cần thiết)
    connect_db(); // Nếu bạn đã kết nối ở nơi khác, có thể không cần gọi lại

    // Câu truy vấn lấy các học sinh bị khóa tài khoản
    $sql = "
        SELECT s.id_st, s.name, s.email, s.sex, s.birth_d 
        FROM students s 
        JOIN user u ON s.email = u.email
        WHERE u.is_locked = 1";

    $stmt = $conn->prepare($sql);
    $stmt->execute();

    // Trả về danh sách sinh viên bị khóa
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function get_locked_teachers()
{
    // Gọi tới biến toàn cục $conn
    global $conn;

    // Hàm kết nối (nếu cần thiết)
    connect_db(); // Nếu bạn đã kết nối ở nơi khác, có thể không cần gọi lại

    // Câu truy vấn lấy các giảng viên bị khóa tài khoản
    $sql = "
        SELECT t.id_tc, t.name, t.email, t.degree, t.major, t.exp_years 
        FROM teachers t 
        JOIN user u ON t.email = u.email
        WHERE u.is_locked = 1";

    $stmt = $conn->prepare($sql);
    $stmt->execute();

    // Trả về danh sách giảng viên bị khóa
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}