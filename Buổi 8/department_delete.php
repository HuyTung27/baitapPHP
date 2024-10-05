<?php
require 'department.php';

if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    delete_department($id);
    header("Location: department_list.php"); // Chuyển hướng sau khi xóa
}
