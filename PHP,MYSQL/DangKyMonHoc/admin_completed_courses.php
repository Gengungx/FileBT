<?php
session_start();
include 'db_connect.php';

// Lấy danh sách các môn học đã hoàn thành
$completed_courses_sql = "SELECT students.student_name, courses.course_name 
                          FROM completed_courses 
                          JOIN students ON completed_courses.student_id = students.student_id 
                          JOIN courses ON completed_courses.course_id = courses.course_id";
$completed_courses_result = $conn->query($completed_courses_sql);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản Lý Môn Học Đã Hoàn Thành</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar {
            background-color: #0066cc; /* Màu xanh dương */
        }
        .navbar-brand, .nav-link {
            color: white !important;
        }
        .navbar-brand:hover, .nav-link:hover {
            color: #ffcc00 !important; /* Màu vàng khi hover */
        }
        .table {
            margin-top: 20px;
        }
        .thead-light {
            background-color: #0066cc;
            color: white;
        }
        .btn-secondary {
            background-color: #0066cc;
            border-color: #0066cc;
        }
        .btn-secondary:hover {
            background-color: #005bb5;
            border-color: #005bb5;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg">
    <a class="navbar-brand" href="#">Hệ Thống Quản Lý</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="admin.php">Trang Chủ</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="logout.php">Đăng Xuất</a>
            </li>
        </ul>
    </div>
</nav>

<div class="container mt-4">
    <h2>Danh Sách Sinh Viên và Môn Học Đã Hoàn Thành</h2>
    <table class="table table-bordered">
        <thead class="thead-light">
            <tr>
                <th>Tên Sinh Viên</th>
                <th>Tên Môn Học</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($completed_courses_result->num_rows > 0): ?>
                <?php while($row = $completed_courses_result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['student_name']; ?></td>
                    <td><?php echo $row['course_name']; ?></td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="2" class="text-center">Không có môn học đã học.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
    
    <a href="admin.php" class="btn btn-secondary">Quay lại</a>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>

<?php
$conn->close();
?>
