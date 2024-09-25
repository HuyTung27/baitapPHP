<?php 
// Biến kết nối toàn cục
global $conn;
 
// Hàm kết nối database bằng PDO
function connect_db()
{
    // Gọi tới biến toàn cục $conn
    global $conn;
     
    // Nếu chưa kết nối thì thực hiện kết nối
    if (!$conn){
        try {
            $conn = new PDO("mysql:host=localhost;dbname=qlsinhvien", "root", "");
            // Thiết lập chế độ lỗi của PDO để ném ngoại lệ
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // Thiết lập charset UTF-8
            $conn->exec("set names utf8");
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }
}
 
// Hàm ngắt kết nối
function disconnect_db()
{
    // Gọi tới biến toàn cục $conn
    global $conn;
     
    // Nếu đã kết nối thì thực hiện ngắt kết nối
    if ($conn){
        $conn = null; // PDO ngắt kết nối bằng cách gán null
    }
}
 
// Hàm lấy tất cả sinh viên
function get_all_students()
{
    // Gọi tới biến toàn cục $conn
    global $conn;
     
    // Hàm kết nối
    connect_db();
     
    // Câu truy vấn lấy tất cả sinh viên
    $sql = "SELECT * FROM sinhvien";
     
    // Thực hiện câu truy vấn
    $stmt = $conn->prepare($sql);
    $stmt->execute();
     
    // Trả về tất cả các bản ghi dưới dạng mảng kết hợp
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
     
    // Trả kết quả về
    return $result;
}
 
// Hàm lấy sinh viên theo ID
function get_student($student_id)
{
    // Gọi tới biến toàn cục $conn
    global $conn;
     
    // Hàm kết nối
    connect_db();
     
    // Câu truy vấn lấy sinh viên theo ID
    $sql = "SELECT * FROM sinhvien WHERE id = :student_id";
     
    // Chuẩn bị câu truy vấn và thực thi
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':student_id', $student_id, PDO::PARAM_INT);
    $stmt->execute();
     
    // Trả về bản ghi đầu tiên
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
     
    // Trả kết quả về
    return $result;
}
 
// Hàm thêm sinh viên
function add_student($student_name, $student_sex, $student_birthday)
{
    // Gọi tới biến toàn cục $conn
    global $conn;
     
    // Hàm kết nối
    connect_db();
     
    // Câu truy vấn thêm
    $sql = "INSERT INTO sinhvien (hoten, gioitinh, ngaysinh) 
            VALUES (:student_name, :student_sex, :student_birthday)";
     
    // Chuẩn bị câu truy vấn và thực thi
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':student_name', $student_name);
    $stmt->bindParam(':student_sex', $student_sex);
    $stmt->bindParam(':student_birthday', $student_birthday);
     
    // Thực hiện và trả về kết quả
    return $stmt->execute();
}
 
// Hàm sửa sinh viên
function edit_student($student_id, $student_name, $student_sex, $student_birthday)
{
    // Gọi tới biến toàn cục $conn
    global $conn;
     
    // Hàm kết nối
    connect_db();
     
    // Câu truy sửa
    $sql = "UPDATE sinhvien SET 
                hoten = :student_name, 
                gioitinh = :student_sex, 
                ngaysinh = :student_birthday 
            WHERE id = :student_id";
     
    // Chuẩn bị câu truy vấn và thực thi
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':student_name', $student_name);
    $stmt->bindParam(':student_sex', $student_sex);
    $stmt->bindParam(':student_birthday', $student_birthday);
    $stmt->bindParam(':student_id', $student_id, PDO::PARAM_INT);
     
    // Thực hiện và trả về kết quả
    return $stmt->execute();
}
 
// Hàm xóa sinh viên
function delete_student($student_id)
{
    // Gọi tới biến toàn cục $conn
    global $conn;
     
    // Hàm kết nối
    connect_db();
     
    // Câu truy vấn xóa sinh viên
    $sql = "DELETE FROM sinhvien WHERE id = :student_id";
     
    // Chuẩn bị câu truy vấn và thực thi
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':student_id', $student_id, PDO::PARAM_INT);
     
    // Thực hiện và trả về kết quả
    return $stmt->execute();
}
?>
