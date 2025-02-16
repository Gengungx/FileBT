<?php
session_start();
include 'db_connect.php';
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Trang Admin - Trang Chủ</title>
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
        .card {
            border: 1px solid #0066cc; /* Viền màu xanh dương */
        }
        .card-body {
            background-color: #e6f2ff; /* Màu nền xanh nhạt */
        }
        .btn-primary {
            background-color: #0066cc;
            border-color: #0066cc;
        }
        .btn-primary:hover {
            background-color: #005bb5;
            border-color: #005bb5;
        }
        .card-title {
            color: #0066cc;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg">
    <a class="navbar-brand" href="#">Hệ Thống Quản Lý</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="logout.php">Đăng Xuất</a>
            </li>
        </ul>
    </div>
</nav>

<div class="container mt-4">
    <h2 class="text-center">Trang Chủ Quản Trị Viên</h2>
    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Quản Lý Lớp Học</h5>
                    <p class="card-text">Xem và quản lý các lớp học.</p>
                    <a href="admin_classes.php" class="btn btn-primary">Truy Cập</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Quản Lý Môn Học Đã Hoàn Thành</h5>
                    <p class="card-text">Xem và quản lý các môn học đã hoàn thành.</p>
                    <a href="admin_completed_courses.php" class="btn btn-primary">Truy Cập</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Quản Lý Trạng Thái Hệ Thống</h5>
                    <p class="card-text">Cập nhật trạng thái hệ thống.</p>
                    <a href="admin_system_status.php" class="btn btn-primary">Truy Cập</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
