<?php
global $conn;

function connect_db() {
    global $conn;
    try {
        $conn = new PDO("mysql:host=localhost;dbname=employee_db", 'root', '');
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
}

function disconnect_db() {
    $conn = null;
}

// Lấy tất cả department
function get_all_departments() {
    global $conn;
    connect_db();
    
    try {
        $stmt = $conn->prepare("SELECT * FROM departments"); // đổi tên bảng thành chữ thường
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// Lấy department theo ID
function get_department($department_id) {
    global $conn;
    connect_db();

    $stmt = $conn->prepare("SELECT * FROM departments WHERE department_id = :department_id"); // đổi tên bảng thành chữ thường
    $stmt->bindParam(':department_id', $department_id);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    return $stmt->fetch();
}

// Thêm department
function add_department($department_name) {
    global $conn;
    connect_db();
    
    try {
        $sql = "INSERT INTO departments (department_name) VALUES (:department_name)"; // đổi tên bảng thành chữ thường
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':department_name', $department_name);
        $stmt->execute();
        echo "Thêm department thành công!";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// Sửa department
function edit_department($department_id, $department_name) {
    global $conn;
    connect_db();

    try {
        $sql = "UPDATE departments SET department_name = :department_name WHERE department_id = :department_id"; // đổi tên bảng thành chữ thường
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':department_name', $department_name);
        $stmt->bindParam(':department_id', $department_id);
        $stmt->execute();
        echo "Cập nhật department thành công!";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// Xóa department
function delete_department($department_id) {
    global $conn;
    connect_db();

    try {
        $sql = "DELETE FROM departments WHERE department_id = :department_id"; // đổi tên bảng thành chữ thường
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':department_id', $department_id);
        $stmt->execute();
        echo "Xóa department thành công!";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
