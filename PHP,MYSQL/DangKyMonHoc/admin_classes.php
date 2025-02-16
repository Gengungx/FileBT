<?php
session_start();
include 'db_connect.php';

// Lấy dữ liệu từ các bảng lớp
$class1_sql = "SELECT students.student_name, courses.course_name FROM class1
               JOIN students ON class1.student_id = students.student_id
               JOIN courses ON class1.course_id = courses.course_id";
$class1_result = $conn->query($class1_sql);

$class2_sql = "SELECT students.student_name, courses.course_name FROM class2
               JOIN students ON class2.student_id = students.student_id
               JOIN courses ON class2.course_id = courses.course_id";
$class2_result = $conn->query($class2_sql);

$class3_sql = "SELECT students.student_name, courses.course_name FROM class3
               JOIN students ON class3.student_id = students.student_id
               JOIN courses ON class3.course_id = courses.course_id";
$class3_result = $conn->query($class3_sql);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản Lý Lớp Học</title>
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
    <h2>Danh Sách Đăng Ký Lớp Học</h2>

    <h3>Lớp 1</h3>
    <table class="table table-bordered">
        <thead class="thead-light">
            <tr>
                <th>Sinh Viên</th>
                <th>Môn Học</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($class1_result->num_rows > 0): ?>
                <?php while ($row = $class1_result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['student_name']; ?></td>
                        <td><?php echo $row['course_name']; ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="2" class="text-center">Không có sinh viên đăng ký.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

    <h3>Lớp 2</h3>
    <table class="table table-bordered">
        <thead class="thead-light">
            <tr>
                <th>Sinh Viên</th>
                <th>Môn Học</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($class2_result->num_rows > 0): ?>
                <?php while ($row = $class2_result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['student_name']; ?></td>
                        <td><?php echo $row['course_name']; ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="2" class="text-center">Không có sinh viên đăng ký.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

    <h3>Lớp 3</h3>
    <table class="table table-bordered">
        <thead class="thead-light">
            <tr>
                <th>Sinh Viên</th>
                <th>Môn Học</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($class3_result->num_rows > 0): ?>
                <?php while ($row = $class3_result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['student_name']; ?></td>
                        <td><?php echo $row['course_name']; ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="2" class="text-center">Không có sinh viên đăng ký.</td></tr>
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
