<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý lịch thi</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
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
        <h1 class="mb-4">Quản lý lịch thi</h1>
        <div class="card">
            <div class="card-header">
                <h2 class="mb-0">Chọn một tùy chọn</h2>
            </div>
            <div class="card-body">
                <div class="list-group">
                    <a href="upload_exam_file.php" class="list-group-item list-group-item-action">Upload Đề Thi</a>
                    <a href="schedule_exam.php" class="list-group-item list-group-item-action">Xếp Lịch Thi</a>
                    <a href="assign_proctor.php" class="list-group-item list-group-item-action">Phân Công Giám Thị</a>
                    <a href="view_exam_schedule.php" class="list-group-item list-group-item-action active">Xem Lịch Thi</a>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
