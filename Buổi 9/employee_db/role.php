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
    global $conn;
    $conn = null; // Ngắt kết nối
}

// Lấy tất cả roles
function get_all_roles() {
    global $conn;
    connect_db();
    
    try {
        $stmt = $conn->prepare("SELECT * FROM EmployeeRoles");
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $result = $stmt->fetchAll();
        disconnect_db(); // Ngắt kết nối sau khi hoàn thành
        return $result;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// Lấy role theo ID
function get_role($role_id) {
    global $conn;
    connect_db();

    $stmt = $conn->prepare("SELECT * FROM EmployeeRoles WHERE role_id = :role_id");
    $stmt->bindParam(':role_id', $role_id);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $result = $stmt->fetch();
    disconnect_db(); // Ngắt kết nối sau khi hoàn thành
    return $result;
}

// Thêm role
function add_role($role_name) {
    global $conn;
    connect_db();
    
    try {
        $sql = "INSERT INTO EmployeeRoles (role_name) VALUES (:role_name)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':role_name', $role_name);
        $stmt->execute();
        echo "Thêm role thành công!";
        disconnect_db(); // Ngắt kết nối sau khi hoàn thành
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// Sửa role
function edit_role($role_id, $role_name) {
    global $conn;
    connect_db();

    try {
        $sql = "UPDATE EmployeeRoles SET role_name = :role_name WHERE role_id = :role_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':role_name', $role_name);
        $stmt->bindParam(':role_id', $role_id);
        $stmt->execute();
        echo "Cập nhật role thành công!";
        disconnect_db(); // Ngắt kết nối sau khi hoàn thành
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// Xóa role
function delete_role($role_id) {
    global $conn;
    connect_db();

    try {
        $sql = "DELETE FROM EmployeeRoles WHERE role_id = :role_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':role_id', $role_id);
        $stmt->execute();
        echo "Xóa role thành công!";
        disconnect_db(); // Ngắt kết nối sau khi hoàn thành
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
