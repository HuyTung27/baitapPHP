<?php
global $conn;
function connect_db()
{
  global $conn;
  try {
    $conn = new PDO("mysql:host=localhost;dbname=employee_db", 'root', '');
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Kết nối thành công";
  } catch (PDOException $e) {
    echo "Lỗi kết nối: " . $e->getMessage();
  }
}

// Hàm ngắt kết nối
function disconnect_db()
{
  $conn = null;
}

// Hàm lấy tất cả nhân viên
function get_all_employees()
{
  global $conn;
  // Hàm kết nối
  connect_db();

  try {
    //khai báo exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Sử dụng Prepare 
    $stmt = $conn->prepare("SELECT departments.department_id, employeeroles.role_id, employees.employee_id, employees.first_name, employees.last_name, departments.department_name, employeeroles.role_name FROM employees JOIN departments ON employees.department_id = departments.department_id JOIN employeeroles ON employees.role_id = employeeroles.role_id");

    // Thực thi câu truy vấn
    $stmt->execute();
    // Khai báo fetch kiểu mảng kết hợp
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    // Lấy danh sách kết quả
    $result = $stmt->fetchAll();
    return $result;
  } catch (PDOException $e) {
    echo "Lỗi: " . $e->getMessage();
  }
}

// Hàm lấy nhân viên theo ID
function get_employees($employee_id)
{
  global $conn;

  // Hàm kết nối
  connect_db();
  // Câu truy vấn lấy tất cả nhân viên
  $stmt = $conn->prepare("SELECT * FROM employees WHERE employee_id = {$employee_id}");
  // Thực thi câu truy vấn
  $stmt->execute();
  // Khai báo fetch kiểu mảng kết hợp
  $stmt->setFetchMode(PDO::FETCH_ASSOC);
  // Lấy danh sách kết quả
  $result = $stmt->fetchAll();
  return $result;
}

// Hàm thêm nhân viên
function add_employee($employee_firstname, $employee_lastname, $employee_dep, $employee_role)
{
  global $conn;

  // Hàm kết nối
  connect_db();

  try {
    //khai báo exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Câu truy vấn thêm
    $sql = "INSERT INTO employees (first_name, last_name, department_id, role_id) VALUES ('$employee_firstname', '$employee_lastname', $employee_dep, $employee_role)";

    // Thực hiện câu truy vấn
    $conn->exec($sql);
    echo "Thêm dữ liệu thành công";
  } catch (PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
  }
}

// Hàm sửa nhân viên
function edit_employee($employee_id, $employee_firstname, $employee_lastname, $employee_dep, $employee_role)
{
  global $conn;

  // Hàm kết nối
  connect_db();

  try {
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Câu truy vấn sửa
    $sql = "
            UPDATE employees SET
            first_name = '$employee_firstname',
            last_name = '$employee_lastname',
            department_id = $employee_dep,
            role_id = $employee_role
            WHERE employee_id = $employee_id";

    // Prepare statement
    $stmt = $conn->prepare($sql);

    // Thực thi câu truy vấn
    $stmt->execute();
    echo $stmt->rowCount() . " records UPDATED successfully";
  } catch (PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
  }
}

// Hàm xóa nhân viên
function delete_employee($employee_id)
{
  global $conn;

  // Hàm kết nối
  connect_db();
  try {
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Câu SQL xóa
    $sql = "DELETE FROM employees WHERE employee_id = $employee_id";

    // Prepare statement
    $stmt = $conn->prepare($sql);

    // Thực thi câu truy vấn
    $stmt->execute();
  } catch (PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
  }
}

// Hàm xử lý với role
function get_role($role_id)
{
  global $conn;

  // Hàm kết nối
  connect_db();
  // Câu truy vấn lấy thông tin role
  $stmt = $conn->prepare("SELECT * FROM employeeroles WHERE role_id = {$role_id}");
  // Thực thi câu truy vấn
  $stmt->execute();
  // Khai báo fetch kiểu mảng kết hợp
  $stmt->setFetchMode(PDO::FETCH_ASSOC);
  // Lấy danh sách kết quả
  $result = $stmt->fetchAll();
  return $result;
}

// Hàm lấy role_id khi biết role_name
function get_roleid($role_name)
{
  global $conn;

  // Hàm kết nối
  connect_db();
  // Câu truy vấn lấy thông tin chức vụ 
  $stmt = $conn->prepare("SELECT * FROM employeeroles WHERE role_name = '{$role_name}'");
  // Thực thi câu truy vấn
  $stmt->execute();
  // Khai báo fetch kiểu mảng kết hợp
  $stmt->setFetchMode(PDO::FETCH_ASSOC);
  // Lấy danh sách kết quả
  $result = $stmt->fetchAll();
  return $result;
}

// Hàm lấy danh sách tất cả role
function get_all_role()
{
  global $conn;

  // Hàm kết nối
  connect_db();

  try {
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Sử dụng Prepare 
    $stmt = $conn->prepare("SELECT * FROM employeeroles");

    // Thực thi câu truy vấn
    $stmt->execute();
    // Khai báo fetch kiểu mảng kết hợp
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    // Lấy danh sách kết quả
    $result = $stmt->fetchAll();
    return $result;
  } catch (PDOException $e) {
    echo "Lỗi: " . $e->getMessage();
  }
}

// Hàm lấy danh sách tất cả department
function get_all_department()
{
  global $conn;

  // Hàm kết nối
  connect_db();

  try {
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Sử dụng Prepare 
    $stmt = $conn->prepare("SELECT * FROM departments");

    // Thực thi câu truy vấn
    $stmt->execute();
    // Khai báo fetch kiểu mảng kết hợp
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    // Lấy danh sách kết quả
    $result = $stmt->fetchAll();
    return $result;
  } catch (PDOException $e) {
    echo "Lỗi: " . $e->getMessage();
  }
}

// Hàm lấy department theo ID
function get_department($department_id)
{
  global $conn;

  // Hàm kết nối
  connect_db();
  // Câu truy vấn lấy department
  $stmt = $conn->prepare("SELECT * FROM departments WHERE department_id = {$department_id}");
  // Thực thi câu truy vấn
  $stmt->execute();
  // Khai báo fetch kiểu mảng kết hợp
  $stmt->setFetchMode(PDO::FETCH_ASSOC);
  // Lấy danh sách kết quả
  $result = $stmt->fetchAll();
  return $result;
}

// Hàm lấy department_id khi biết department_name
function get_departmentid($department_name)
{
  global $conn;

  // Hàm kết nối
  connect_db();
  // Câu truy vấn lấy thông tin department
  $stmt = $conn->prepare("SELECT * FROM departments WHERE department_name = '{$department_name}'");
  // Thực thi câu truy vấn
  $stmt->execute();
  // Khai báo fetch kiểu mảng kết hợp
  $stmt->setFetchMode(PDO::FETCH_ASSOC);
  // Lấy danh sách kết quả
  $result = $stmt->fetchAll();
  return $result;
}
