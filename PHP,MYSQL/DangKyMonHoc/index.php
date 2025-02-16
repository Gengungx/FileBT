<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit();
}

$student_id = $_SESSION['student_id'];
$student_name = $_SESSION['student_name'];

// Lấy thông tin môn học
$courses_sql = "SELECT * FROM courses";
$courses_result = $conn->query($courses_sql);

// Kiểm tra trạng thái hệ thống
$status_sql = "SELECT is_open FROM system_status WHERE id = 1";
$status_result = $conn->query($status_sql);
$is_system_open = false;

if ($status_result && $status_result->num_rows > 0) {
    $status_row = $status_result->fetch_assoc();
    $is_system_open = $status_row['is_open'] == 1;
}

// Lưu đăng ký môn học
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $course_id = $_POST['course_id'];

    // Khởi tạo biến lỗi
    $prerequisite_error = '';
    $already_registered = false;
    $course_completed = false;

    // Kiểm tra nếu đã đăng ký môn học
    $check_registered_sql = "SELECT * FROM class1 WHERE student_id = $student_id AND course_id = $course_id
                              UNION
                              SELECT * FROM class2 WHERE student_id = $student_id AND course_id = $course_id
                              UNION
                              SELECT * FROM class3 WHERE student_id = $student_id AND course_id = $course_id";
    $check_result = $conn->query($check_registered_sql);

    if ($check_result->num_rows > 0) {
        $already_registered = true;
    }

    // Kiểm tra xem môn học đã hoàn thành chưa
    $check_completed_sql = "SELECT * FROM completed_courses WHERE student_id = $student_id AND course_id = $course_id";
    $completed_result = $conn->query($check_completed_sql);

    if ($completed_result->num_rows > 0) {
        $course_completed = true;
    }

    // Kiểm tra điều kiện tiên quyết
    if ($course_id == 3) {
        $prereq_sql = "SELECT * FROM completed_courses WHERE student_id = $student_id AND course_id = 2";
        $prereq_result = $conn->query($prereq_sql);

        if ($prereq_result->num_rows == 0) {
            $prerequisite_error = "Bạn chưa học Cơ sở Dữ liệu.";
        }
    } elseif ($course_id == 10) {
        $prereq_sql = "SELECT * FROM completed_courses WHERE student_id = $student_id AND course_id = 3";
        $prereq_result = $conn->query($prereq_sql);

        if ($prereq_result->num_rows == 0) {
            $prerequisite_error = "Bạn chưa học Trí tuệ Nhân tạo.";
        }
    } else {
        $prereq_sql = "SELECT prerequisite_course_id FROM prerequisites WHERE course_id = $course_id";
        $prereq_result = $conn->query($prereq_sql);

        while ($row = $prereq_result->fetch_assoc()) {
            $prereq_course_id = $row['prerequisite_course_id'];
            $completed_sql = "SELECT * FROM completed_courses WHERE student_id = $student_id AND course_id = $prereq_course_id";
            $completed_result = $conn->query($completed_sql);

            if ($completed_result->num_rows == 0) {
                $prerequisite_error = "Bạn chưa học môn tiên quyết.";
                break;
            }
        }
    }

    if ($already_registered) {
        $alert_type = 'warning';
        $alert_message = 'Bạn đã đăng ký môn học này rồi!';
    } elseif ($course_completed) {
        $alert_type = 'info';
        $alert_message = 'Bạn đã hoàn thành môn học này!';
    } elseif ($prerequisite_error) {
        $alert_type = 'danger';
        $alert_message = $prerequisite_error;
    } else {
        $class_table = '';
        if ($course_id % 3 == 1) {
            $class_table = 'class1';
        } elseif ($course_id % 3 == 2) {
            $class_table = 'class2';
        } else {
            $class_table = 'class3';
        }

        $sql = "INSERT INTO $class_table (student_id, course_id) VALUES ($student_id, $course_id)";

        if ($conn->query($sql) === TRUE) {
            $alert_type = 'success';
            $alert_message = 'Đăng ký thành công!';
        } else {
            $alert_type = 'danger';
            $alert_message = 'Lỗi: ' . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Ký Môn Học</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa; /* Màu nền sáng */
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
            max-width: 900px;
            margin-left: 270px; /* Đẩy nội dung chính sang bên phải để không bị đè lên sidebar */
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            margin-top: 50px;
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
        .btn-primary {
            background-color: #007bff;
            border: none;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .header-image {
            max-height: 50px;
            margin-right: 10px;
        }
        .heading-title {
            color: #007bff;
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

<!-- Main Content -->
<div class="container-sm">
    <h2 class="text-center heading-title">Đăng Ký Môn Học</h2>
    <p class="text-center">Chào mừng, <?php echo $student_name; ?>!</p>
    
    <?php if (isset($alert_message)): ?>
        <div class="alert alert-<?php echo $alert_type; ?> mt-3" role="alert">
            <?php echo $alert_message; ?>
        </div>
    <?php endif; ?>

    <form method="post" action="">
        <div class="form-group">
            <label for="course">Chọn Môn Học:</label>
            <select id="course" name="course_id" class="form-control" required>
                <?php while ($row = $courses_result->fetch_assoc()): ?>
                    <option value="<?php echo $row['course_id']; ?>"><?php echo $row['course_name']; ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Đăng Ký</button>
    </form>
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
