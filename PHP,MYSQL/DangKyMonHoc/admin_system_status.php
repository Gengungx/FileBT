<?php
session_start();
include 'db_connect.php';

$message = ""; // Biến để lưu thông báo

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $is_open = $_POST['is_open'] === '1' ? 1 : 0; // Sử dụng 1 và 0 để cập nhật

    $update_sql = "UPDATE system_status SET is_open = $is_open WHERE id = 1";
    
    if ($conn->query($update_sql) === TRUE) {
        $message = "<div class='alert alert-success'>Trạng thái hệ thống đã được cập nhật thành công!</div>";
    } else {
        $message = "<div class='alert alert-danger'>Lỗi: " . $conn->error . "</div>";
    }
}

// Lấy trạng thái hiện tại
$status_sql = "SELECT is_open FROM system_status WHERE id = 1";
$status_result = $conn->query($status_sql);

$current_status = '0'; // Giá trị mặc định nếu không tìm thấy

if ($status_result && $status_result->num_rows > 0) {
    $status_row = $status_result->fetch_assoc();
    $current_status = $status_row['is_open'] ? '1' : '0';
} else {
    // Nếu không có bản ghi nào, có thể tạo một bản ghi mới
    $conn->query("INSERT INTO system_status (is_open) VALUES (0)");
    $current_status = '0'; // Cập nhật lại trạng thái
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản Lý Trạng Thái Hệ Thống</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar {
            background-color: #0066cc;
        }
        .navbar-brand, .nav-link {
            color: white !important;
        }
        .navbar-brand:hover, .nav-link:hover {
            color: #ffcc00 !important;
        }
        .form-container {
            max-width: 400px;
            margin: auto;
            margin-top: 40px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            background-color: #f9f9f9;
        }
        .btn-primary {
            background-color: #0066cc;
            border-color: #0066cc;
        }
        .btn-primary:hover {
            background-color: #005bb5;
            border-color: #005bb5;
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

<div class="container form-container">
    <h2 class="text-center">Quản Lý Trạng Thái Hệ Thống</h2>
    
    <?php
    if (!empty($message)) {
        echo $message;
    }
    ?>
    
    <form method="post" action="">
        <div class="form-group">
            <label for="is_open">Trạng Thái Hệ Thống:</label>
            <select id="is_open" name="is_open" class="form-control">
                <option value="1" <?php if ($current_status == '1') echo 'selected'; ?>>Mở</option>
                <option value="0" <?php if ($current_status == '0') echo 'selected'; ?>>Đóng</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Cập Nhật</button>
    </form>
    
    <a href="admin.php" class="btn btn-secondary btn-block mt-3">Quay lại</a>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>

<?php
$conn->close();
?>
