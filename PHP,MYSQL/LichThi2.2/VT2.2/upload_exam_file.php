<?php
include 'config.php';

$upload_message = ''; // Khởi tạo biến để lưu thông báo upload

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Kiểm tra xem tệp đã được chọn hay chưa
    if ($_FILES['exam_file']['error'] == UPLOAD_ERR_NO_FILE) {
        $upload_message = "<div class='alert alert-danger'>Vui lòng chọn tệp đề thi.</div>";
    } else {
        $exam_schedule_id = $_POST['exam_schedule_id'];
        $file_name = $_FILES['exam_file']['name'];
        $file_tmp = $_FILES['exam_file']['tmp_name'];
        $file_path = "uploads/" . basename($file_name);

        // Di chuyển tệp tạm vào thư mục uploads
        if (move_uploaded_file($file_tmp, $file_path)) {
            $sql = "INSERT INTO exam_files (exam_schedule_id, file_path) VALUES ($exam_schedule_id, '$file_path')";
            if ($conn->query($sql) === TRUE) {
                $upload_message = "<div class='alert alert-success'>Upload thành công</div>";
            } else {
                $upload_message = "<div class='alert alert-danger'>Lỗi khi lưu vào CSDL: " . $conn->error . "</div>";
                unlink($file_path); // Xóa file đã upload nếu có lỗi xảy ra trong CSDL
            }
        } else {
            $upload_message = "<div class='alert alert-danger'>Lỗi khi upload file.</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Đề Thi</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            background-color: #ffffff; /* Đổi màu nền thành trắng */
            color: #343a40; /* Đổi màu chữ thành màu tối */
        }
        .navbar {
            background-color: #dc3545;
        }
        .navbar-brand, .nav-link {
            color: #ffffff !important;
        }
        .container {
            max-width: 600px;
            margin-top: 100px;
        }
        .card {
            background-color: #ffffff; /* Đổi màu nền thành trắng */
            border: 1px solid #dc3545;
        }
        .card-header {
            background-color: #dc3545;
            border-bottom: 1px solid #dc3545;
            color: #ffffff;
        }
        .card-body {
            background-color: #ffffff; /* Đổi màu nền thành trắng */
            border-top: 1px solid #dc3545;
        }
        .form-group label {
            color: #343a40; /* Đổi màu chữ thành màu tối */
        }
        .form-control {
            background-color: #ffffff; /* Đổi màu nền thành trắng */
            border: 1px solid #dc3545;
            color: #343a40; /* Đổi màu chữ thành màu tối */
        }
        .form-control-file {
            color: #343a40; /* Đổi màu chữ thành màu tối */
        }
        .btn-primary {
            background-color: #dc3545;
            border-color: #dc3545;
        }
        .btn-primary:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }
        .btn-back {
            background-color: #6c757d;
            border-color: #6c757d;
        }
        .btn-back:hover {
            background-color: #5a6268;
            border-color: #545b62;
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
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col">
                                <h2 class="mb-0">Upload Đề Thi</h2>
                            </div>
                            <div class="col-auto">
                                <a href="index.php" class="btn btn-back">Quay lại</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php echo $upload_message; ?> <!-- Hiển thị thông báo upload -->

                        <form method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="exam_schedule_id">Chọn lịch thi:</label>
                                <select name="exam_schedule_id" id="exam_schedule_id" class="form-control">
                                    <option value="">Chọn lịch thi</option>
                                    <?php
                                    $result = $conn->query("SELECT es.id, e.exam_name, es.exam_date 
                                                            FROM exam_schedule es 
                                                            JOIN exams e ON es.exam_id = e.id");
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<option value='".$row['id']."'>".$row['exam_name']." - ".$row['exam_date']."</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exam_file">Chọn đề thi:</label>
                                <input type="file" name="exam_file" id="exam_file" class="form-control-file">
                            </div>
                            <button type="submit" class="btn btn-primary">Upload</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
