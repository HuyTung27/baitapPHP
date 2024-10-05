<?php
require 'roles.php';

if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    delete_role($id);
    header("Location: roles_list.php"); // Chuyển hướng sau khi xóa
}
