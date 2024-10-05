<?php
global $conn;
function connect_db()
{
	global $conn;
  try {
	   $conn = new PDO("mysql:host=sql110.infinityfree.com;dbname=if0_37098463_employee_db", 'if0_37098463', 'HuyTung2707');
	  // set the PDO error mode to exception
	  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	  //echo "Kết nối thành công";
	} catch(PDOException $e) {
	  echo "Lỗi kết nối: " . $e->getMessage();
	}
}
 
// Hàm ngắt kết nối
function disconnect_db()
{
    $conn = null;
 }
// Hàm lấy tất cả nhân viên
function get_all_departments()
{
	 global $conn;
   // Hàm kết nối
    connect_db();
  
    try{
    	//khai báo exception
    	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   // Sử dụng Prepare 
    $stmt = $conn->prepare("SELECT departments.department_id,departments.department_name FROM departments"); 
     
    // Thực thi câu truy vấn
    $stmt->execute();
    // Khai báo fetch kiểu mảng kết hợp
    $stmt->setFetchMode(PDO::FETCH_ASSOC); 
    // Lấy danh sách kết quả
    $result = $stmt->fetchAll();
   return $result;
 }
 catch(PDOException $e) {
    echo "Lỗi: " . $e->getMessage();
}
}

 
// Hàm lấy nhân viên theo ID
function get_departments($department_id)
{
    // Gọi tới biến toàn cục $conn
    global $conn;
     
    // Hàm kết nối
    connect_db();
    // Câu truy vấn lấy tất cả nhân viên
    $stmt = $conn->prepare("select * from departments where department_id = {$department_id}");
    // Thực thi câu truy vấn
    $stmt->execute();
    // Khai báo fetch kiểu mảng kết hợp
    $stmt->setFetchMode(PDO::FETCH_ASSOC); 
    // Lấy danh sách kết quả
    $result = $stmt->fetchAll();
     return $result;
    // var_dump($result);
    
}
 
// Hàm thêm nhân viên
function add_department($department_name) {
    global $conn;
    connect_db();
    try {
        // Khai báo exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Câu truy vấn thêm department
        $sql = "INSERT INTO departments (department_name) VALUES (:name)";
        
        // Chuẩn bị truy vấn và bind giá trị
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':name', $department_name);

        // Thực thi câu truy vấn
        $stmt->execute();
        echo "Thêm dữ liệu thành công";
    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }
    disconnect_db(); // Đóng kết nối
}

 
// Hàm sửa nhân viên
function edit_department($id, $name)
{
    global $conn;
    connect_db();
    try {
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Sử dụng câu truy vấn với placeholders để tránh SQL injection
        $sql = "UPDATE departments SET department_name = :name WHERE department_id = :id";
        
        // Chuẩn bị và bind các giá trị
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':id', $id);

        // Thực thi truy vấn
        $stmt->execute();

        // Thông báo kết quả cập nhật
        echo $stmt->rowCount() . " records UPDATED successfully";

    } catch(PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }
    disconnect_db(); // Đóng kết nối
}

 
// Hàm xóa nhân viên
function delete_department($department_id)
{
    // Gọi tới biến toàn cục $conn
    global $conn;
     
    // Hàm kết nối
    connect_db();
    try{
     	 $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Câu SQL xóa
    $sql = " DELETE FROM departments WHERE department_id = $department_id ";
     
    // Prepare statement
  $stmt = $conn->prepare($sql);

  // execute the query
  $stmt->execute();
}
  catch(PDOException $e) {
  echo $sql . "<br>" . $e->getMessage();
}
}
?>