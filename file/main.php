<?php
session_start();
require_once 'database.php';

// Kiểm tra nếu người dùng chưa đăng nhập
if (!isset($_SESSION['student_id'])) {
    header('Location: login.php');
    exit();
}

$db = new Database();
$conn = $db->getConnection();

$student_id = $_SESSION['student_id'];
$student_name = $_SESSION['student_name']; // Lấy tên sinh viên từ session

// Lấy thông tin sinh viên
$student_query = "SELECT * FROM students WHERE student_id = ?";
$student_result = $db->select($student_query, [$student_id]);

$db->closeConnection();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Trang chính</title>
    <!-- Link to Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        html, body {
            height: 100%; /* Đặt chiều cao cho body và html */
            margin: 0; /* Bỏ margin */
        }

        .container-custom {
            min-height: calc(100vh - 100px); /* Chiều cao tối thiểu cho vùng nội dung */
        }

        footer {
            background-color: #f8f9fa;
            padding: 10px 0;
            text-align: center;
            position: relative;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container">
            <a class="navbar-brand" href="#">Hệ thống đăng ký học lại</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Đăng xuất</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container container-custom">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 sidebar">
                <h4 class="text-center">Menu</h4>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="main.php">Trang chính</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="view_grades_student.php">Xem điểm</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="profile.php">Thông tin cá nhân</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="register.php">Đăng ký học lại</a>
                    </li>
                </ul>
            </div>

            <!-- Nội dung chính -->
            <div class="col-md-9">
                <div class="profile-container">
                    <h2 class="text-center">Thông tin cá nhân</h2>
                    <div class="alert alert-primary text-center" role="alert">
                        Xin chào, <?php echo htmlspecialchars($student_name); ?>!
                    </div>
                </div>
            </div>
        </div>
    </div>

   <!-- Footer -->
<footer class="footer mt-auto py-3 bg-dark text-white">
    <div class="container text-center">
        <span>&copy; 2024 Hệ thống đăng ký học lại. All Rights Reserved.</span>
        <ul class="list-inline">
            <li class="list-inline-item"><a href="privacy.php" class="text-white">Chính sách bảo mật</a></li>
            <li class="list-inline-item"><a href="terms.php" class="text-white">Điều khoản sử dụng</a></li>
            <li class="list-inline-item"><a href="contact.php" class="text-white">Liên hệ</a></li>
        </ul>
    </div>
</footer>

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
