<?php
session_start();
require_once 'database.php';

$db = new Database();
$conn = $db->getConnection();
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = md5($_POST['password']); 

    // Lấy thông tin người dùng từ bảng users
    $result = $db->select("SELECT * FROM users WHERE username = ?", [$username]);
    if ($result) {
        $user = $result[0];
        if ($password === $user['password']) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['student_id'] = $user['student_id'];
            
            // Kiểm tra nếu người dùng là admin
            if ($username === 'admin') {
                $_SESSION['role'] = 'admin';
                $_SESSION['student_name'] = 'Admin';
                header('Location: admin.php');
            } else {
                $_SESSION['role'] = 'student';

                // Lấy thông tin sinh viên từ bảng students
                $student_result = $db->select("SELECT * FROM students WHERE student_id = ?", [$user['student_id']]);
                if ($student_result) {
                    $student = $student_result[0];
                    $_SESSION['student_name'] = $student['name'];
                    header('Location: main.php');
                } else {
                    $_SESSION['error_message'] = 'Không tìm thấy thông tin sinh viên.';
                    header('Location: index.php');
                }
            }
            exit();
        } else {
            $_SESSION['error_message'] = 'Mật khẩu không đúng!';
            header('Location: index.php'); // Chuyển hướng về trang login và hiển thị thông báo
            exit();
        }
    } else {
        $_SESSION['error_message'] = 'Tên đăng nhập không tồn tại!';
        header('Location: index.php'); // Chuyển hướng về trang login và hiển thị thông báo
        exit();
    }
}

$db->closeConnection();

?>
