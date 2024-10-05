<?php
global $conn;
function connect_db()
{
	global $conn;
  try {
	   $conn = new PDO("mysql:host=sql110.infinityfree.com; dbname=if0_37098463_employee_db", 'if0_37098463', 'HuyTung2707');
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
// Hàm lấy tất cả chức vụ
function get_all_role()
{
    global $conn;
    connect_db();

    try{
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare("SELECT employeeroles.role_id, employeeroles.role_name FROM employeeroles"); 
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC); 
        $result = $stmt->fetchAll();
        disconnect_db(); // Ngắt kết nối sau khi lấy dữ liệu
        return $result;
    }
    catch(PDOException $e) {
        echo "Lỗi: " . $e->getMessage();
    }
}

function get_role($role_id)
{
    global $conn;
    connect_db();
    $stmt = $conn->prepare("SELECT * FROM employeeroles WHERE role_id = :role_id");
    $stmt->bindParam(':role_id', $role_id);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC); 
    $result = $stmt->fetch();
    disconnect_db(); // Ngắt kết nối sau khi lấy dữ liệu
    return $result;
}

 
// Hàm thêm chức vụ
function add_role($role_name) {
    global $conn;
    connect_db();
    try {
        // Khai báo exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Câu truy vấn thêm role
        $sql = "INSERT INTO employeeroles (role_name) VALUES (:name)";
        
        // Chuẩn bị truy vấn và bind giá trị
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':name', $role_name);

        // Thực thi câu truy vấn
        $stmt->execute();
        echo "Thêm dữ liệu thành công";
    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }
    disconnect_db(); // Đóng kết nối
}

 
// Hàm sửa chức vụ
function edit_role($id, $name)
{
    global $conn;
    connect_db();
    try {
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Sử dụng câu truy vấn với placeholders để tránh SQL injection
        $sql = "UPDATE employeeroles SET role_name = :name WHERE role_id = :id";
        
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

 
// Hàm xóa chức vụ
function delete_role($role_id)
{
    // Gọi tới biến toàn cục $conn
    global $conn;
     
    // Hàm kết nối
    connect_db();
    try{
     	 $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Câu SQL xóa
    $sql = " DELETE FROM employeeroles WHERE role_id = $role_id ";
     
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