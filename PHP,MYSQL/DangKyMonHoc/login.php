<?php
session_start();
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Truy vấn để lấy thông tin người dùng
    $sql = "SELECT * FROM students WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        
        // Kiểm tra mật khẩu
        if (password_verify($password, $row['password'])) {
            $_SESSION['student_id'] = $row['student_id'];
            $_SESSION['student_name'] = $row['student_name'];

            // Kiểm tra xem có phải là admin không
            if ($username === 'admin') {
                header("Location: admin.php"); // Chuyển đến trang admin
            } else {
                header("Location: index.php"); // Chuyển đến trang sinh viên
            }
            exit();
        } else {
            $error = "Mật khẩu không đúng.";
        }
    } else {
        $error = "Tài khoản không tồn tại.";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng Nhập</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa; /* Màu nền sáng hơn */
            font-family: Arial, sans-serif;
        }
        .container-sm {
            max-width: 400px; /* Giới hạn chiều rộng */
            margin: 0 auto; /* Canh giữa */
            background-color: #ffffff; /* Màu nền trắng */
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
            margin-top: 20px; /* Cách lề trên */
        }
        .navbar {
            background-color: #007bff; /* Màu xanh sáng hơn */
            color: white;
        }
        .navbar-brand, .nav-link {
            color: white !important;
        }
        .nav-link:hover {
            color: #ffc107 !important;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .alert {
            border-radius: 5px;
        }
        footer {
            background-color: #007bff;
            color: white;
            padding: 20px 0;
            text-align: center;
            position: fixed;
            width: 100%;
            bottom: 0;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light">
    <a class="navbar-brand" href="#">Hệ Thống Đăng Ký Học</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">

        </ul>
    </div>
</nav>

<div class="container-sm mt-4">
    <h2 class="text-center">Đăng Nhập</h2>
    <form method="post" action="">
        <div class="form-group">
            <label for="username">Tài khoản:</label>
            <input type="text" id="username" name="username" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="password">Mật khẩu:</label>
            <input type="password" id="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Đăng Nhập</button>
    </form>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger mt-3" role="alert">
            <?php echo $error; ?>
        </div>
    <?php endif; ?>
</div>

<!-- Footer -->
<footer>
    <p class="footer-text">© 2024 Hệ Thống Đăng Ký Học. All Rights Reserved.</p>
</footer>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>

<?php
$conn->close();
?>
