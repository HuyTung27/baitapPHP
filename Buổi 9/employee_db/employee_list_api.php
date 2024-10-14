<?php
require 'employee.php';

header('Content-Type: application/json');

// Lấy danh sách tất cả nhân viên
$employees = get_all_employees();

// Trả về dữ liệu dưới dạng JSON
echo json_encode($employees);

// Ngắt kết nối cơ sở dữ liệu
disconnect_db();
?>
