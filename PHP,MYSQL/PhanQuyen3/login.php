<?php
// Bắt đầu session
session_start();

// Kiểm tra nếu người dùng đã đăng nhập, chuyển hướng người dùng đến trang chính
if (isset($_SESSION['username'])) {
    header("Location: main.php");
    exit;
}

include 'model.php';
$model = new Model();

if (isset($_POST['login'])) {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Validation
    $errors = array();
    if (empty($username) || empty($password)) {
        $errors[] = 'Tên đăng nhập và mật khẩu không được để trống.';
    } else {
        // Kiểm tra tên đăng nhập và mật khẩu
        $user = $model->select('user', '*', 'username="' . $username . '" AND password="' . md5($password) . '"');
        if (!empty($user)) {
            // Đăng nhập thành công, lưu tên đăng nhập trong session và chuyển hướng đến trang chính hoặc admin
            $_SESSION['username'] = $user[0]['username'];
            if ($user[0]['username'] === 'admin') {
                header("Location: admin.php");
            } else {
                header("Location: main.php");
            }
            exit;
        } else {
            $errors[] = 'Tên đăng nhập hoặc mật khẩu không chính xác.';
        }
    }
}
?>