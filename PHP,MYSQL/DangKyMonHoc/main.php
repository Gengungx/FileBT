<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit();
}

$student_id = $_SESSION['student_id'];
$student_name = $_SESSION['student_name'];

// Lấy danh sách các môn học đã đăng ký
$registered_courses_sql = "SELECT c.course_name FROM class1 c1
                            JOIN courses c ON c1.course_id = c.course_id
                            WHERE c1.student_id = $student_id
                            UNION
                            SELECT c.course_name FROM class2 c2
                            JOIN courses c ON c2.course_id = c.course_id
                            WHERE c2.student_id = $student_id
                            UNION
                            SELECT c.course_name FROM class3 c3
                            JOIN courses c ON c3.course_id = c.course_id
                            WHERE c3.student_id = $student_id";
$registered_courses_result = $conn->query($registered_courses_sql);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Trang Chủ</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa; /* Màu nền sáng hơn */
            font-family: Arial, sans-serif;
        }
        .sidebar {
            height: 100vh; /* Chiều cao toàn màn hình */
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #ffffff; /* Màu nền sidebar sáng */
            border-right: 1px solid #dee2e6; /* Đường viền phân chia */
            padding-top: 20px;
            box-shadow: 2px 0px 5px rgba(0, 0, 0, 0.1); /* Đổ bóng nhẹ */
        }
        .sidebar a {
            padding: 10px 15px;
            text-align: left;
            font-size: 18px;
            color: #333;
            display: block;
            text-decoration: none;
            border-bottom: 1px solid #e9ecef;
        }
        .sidebar a:hover {
            background-color: #e9ecef;
            color: #007bff;
        }
        .container-sm {
            max-width: 900px; /* Giới hạn chiều rộng */
            margin-left: 270px; /* Đẩy nội dung chính sang bên phải để không bị đè lên sidebar */
            background-color: #ffffff; /* Màu nền trắng */
            padding: 30px;
            border-radius: 10px;
            margin-top: 20px; /* Cách lề trên */
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
        }
        .navbar {
            background-color: #007bff; /* Màu xanh sáng hơn */
            color: white;
            margin-left: 250px; /* Căn chỉnh theo chiều rộng của sidebar */
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
        .list-group-item {
            background-color: #ffffff; /* Màu nền trắng */
        }
        footer {
            background-color: #007bff;
            color: white;
            padding: 20px 0;
            text-align: center;
            position: fixed;
            width: calc(100% - 250px); /* Trừ chiều rộng của sidebar */
            left: 250px; /* Bắt đầu từ bên phải của sidebar */
            bottom: 0;
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <a href="main.php">Trang Chủ</a>
    <a href="index.php">Đăng ký môn học</a>
    <a href="profile.php">Hồ Sơ</a>
    <a href="logout.php">Đăng Xuất</a>
</div>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light">
    <a class="navbar-brand" href="#">Hệ Thống Đăng Ký Học</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="main.php">Trang Chủ</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="index.php">Đăng ký môn học</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="profile.php">Hồ Sơ</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="logout.php">Đăng Xuất</a>
            </li>
        </ul>
    </div>
</nav>

<div class="container-sm mt-4">
    <h2 class="text-center">Chào mừng, <?php echo $student_name; ?>!</h2>
    <h4 class="mt-4">Các Môn Học Đã Đăng Ký:</h4>
    <ul class="list-group mt-3">
        <?php while ($row = $registered_courses_result->fetch_assoc()): ?>
            <li class="list-group-item"><?php echo $row['course_name']; ?></li>
        <?php endwhile; ?>
    </ul>
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
