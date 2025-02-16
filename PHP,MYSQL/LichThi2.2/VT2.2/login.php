<?php
session_start();
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Truy vấn để tìm người dùng
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // Kiểm tra mật khẩu
        if (password_verify($password, $user['password'])) {
            // Xử lý đăng nhập thành công
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
    
            // Nếu là sinh viên, chuyển hướng đến trang dashboard của sinh viên
            if ($user['role'] == 'student') {
                header("Location: student_dashboard.php");
                exit;
            }
            // Nếu là admin, chuyển hướng đến trang admin
            else if ($user['role'] == 'admin') {
                header("Location: index.php");
                exit;
            }
        } else {
            $error = "Sai tên đăng nhập hoặc mật khẩu!";
        }
    } else {
        $error = "Tài khoản không tồn tại!";
    }
}    

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: white;
            color: black;
        }
        .navbar {
            background-color: #dc3545;
        }
        .navbar-brand, .nav-link {
            color: #ffffff !important;
        }
        .container {
            margin-top: 30px;
        }
        .card {
            background-color: #343a40;
            border: 1px solid #dc3545;
            border-radius: 10px;
        }
        .card-header {
            background-color: #dc3545;
            border-bottom: 1px solid #dc3545;
            color: #ffffff;
            border-radius: 10px 10px 0 0;
        }
        .card-body {
            background-color: #343a40;
            border-top: 1px solid #dc3545;
            color: #ffffff;
        }
        .list-group-item {
            background-color: #dc3545;
            border-color: #dc3545;
            color: #ffffff;
        }
        .list-group-item:hover {
            background-color: #c82333;
            border-color: #bd2130;
            color: #ffffff;
        }
        .list-group-item.active {
            background-color: #bd2130;
            border-color: #bd2130;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
    <a class="navbar-brand" href="#">Quản lý lịch thi</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="upload_exam_file.php">Upload Đề Thi</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="schedule_exam.php">Xếp Lịch Thi</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="assign_proctor.php">Phân Công Giám Thị</a>
            </li>
        </ul>
    </div>
</nav>
    <div class="container">
        <h2 class="mt-5">Đăng nhập</h2>

        <?php if (isset($error)) { ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php } ?>

        <form action="" method="post">
            <div class="form-group">
                <label for="username">Tên đăng nhập:</label>
                <input type="text" name="username" class="form-control" id="username" required>
            </div>
            <div class="form-group">
                <label for="password">Mật khẩu:</label>
                <input type="password" name="password" class="form-control" id="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Đăng nhập</button>
        </form>
    </div>
</body>
</html>
