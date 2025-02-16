<?php
include 'config.php';

// Hàm để lấy danh sách sinh viên của một lớp
function getStudentsByClass($class_id, $conn) {
    $sql = "SELECT id, name FROM students WHERE class_id = $class_id LIMIT 7"; // Sửa tên cột là 'name' thay vì 'student_name'
    $result = $conn->query($sql);

    $students = [];
    while ($row = $result->fetch_assoc()) {
        $students[] = $row;
    }

    return $students;
}

$alert_message = ''; // Khởi tạo biến để lưu thông báo lỗi hoặc thành công

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['schedule_exam'])) {
    // Kiểm tra xem các trường đã được điền đầy đủ hay chưa
    if (isset($_POST['class_id']) && !empty($_POST['class_id']) &&
        isset($_POST['exam_id']) && !empty($_POST['exam_id']) &&
        isset($_POST['exam_date']) && !empty($_POST['exam_date']) &&
        isset($_POST['start_time']) && !empty($_POST['start_time']) &&
        isset($_POST['end_time']) && !empty($_POST['end_time'])) {

        $class_id = $_POST['class_id'];
        $exam_id = $_POST['exam_id'];
        $exam_date = $_POST['exam_date'];
        $start_time = $_POST['start_time'];
        $end_time = $_POST['end_time'];

        $sql = "INSERT INTO exam_schedule (exam_id, exam_date, start_time, end_time, status) 
                VALUES ($exam_id, '$exam_date', '$start_time', '$end_time', 'chua_thi')";
        
        if ($conn->query($sql) === TRUE) {
            $alert_message = "<div class='alert alert-success mt-3'>Xếp lịch thi thành công</div>";
        } else {
            $alert_message = "<div class='alert alert-danger mt-3'>Lỗi: " . $sql . "<br>" . $conn->error . "</div>";
        }
    } else {
        // Nếu các trường thiếu thông tin, thông báo lỗi
        $alert_message = "<div class='alert alert-danger mt-3'>Vui lòng điền đầy đủ thông tin lịch thi</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xếp Lịch Thi</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            background-color: #ffffff;
            color: #000000;
        }
        .container {
            max-width: 600px;
            margin-top: 100px;
        }
        .form-label {
            color: #000000;
        }
        .form-control {
            background-color: #ffffff;
            border: 1px solid #343a40;
            color: #000000;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }
        .btn-back {
            background-color: #6c757d;
            border-color: #6c757d;
        }
        .btn-back:hover {
            background-color: #5a6268;
            border-color: #545b62;
        }
        .list-group-item {
            background-color: #ffffff;
            color: #000000;
            border-color: #343a40;
        }
        .list-group-item:hover {
            background-color: #007bff;
            color: #ffffff;
        }
        .navbar {
            background-color: #dc3545;
        }
        .navbar-brand, .nav-link {
            color: #ffffff !important;
        }
        .navbar a {
            color: #ffffff;
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


    <div class="container mt-5">
        <div class="row justify-content-between mb-3">
            <div class="col-auto">
                <h2>Xếp Lịch Thi</h2>
            </div>
            <div class="col-auto">
                <a href="index.php" class="btn btn-back">Trang chủ</a>
            </div>
        </div>

        <?php echo $alert_message; ?> <!-- Hiển thị thông báo lỗi hoặc thành công -->

        <form method="post">
            <input type="hidden" name="schedule_exam" value="1">

            <div class="mb-3">
                <label for="class_id" class="form-label">Chọn lớp thi:</label>
                <select name="class_id" id="class_id" class="form-control">
                    <option value="">Chọn lớp</option>
                    <?php
                    $result = $conn->query("SELECT id, class_name FROM classes");
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='".$row['id']."'>".$row['class_name']."</option>";
                    }
                    ?>
                </select>
            </div>

            <?php
            if (isset($_POST['class_id']) && !empty($_POST['class_id'])) {
                $class_id = $_POST['class_id'];
                $students = getStudentsByClass($class_id, $conn);

                if (!empty($students)) {
                    echo "<div class='mb-3'>";
                    echo "<label for='students' class='form-label'>Danh sách sinh viên:</label>";
                    echo "<ul class='list-group'>";
                    foreach ($students as $student) {
                        echo "<li class='list-group-item'>" . $student['name'] . "</li>";
                    }
                    echo "</ul>";
                    echo "</div>";
                }
            }
            ?>

            <div class="mb-3">
                <label for="exam_id" class="form-label">Chọn bài thi:</label>
                <select name="exam_id" class="form-control">
                    <?php
                    $result = $conn->query("SELECT id, exam_name FROM exams");
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='".$row['id']."'>".$row['exam_name']."</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="exam_date" class="form-label">Ngày thi:</label>
                <input type="date" name="exam_date" class="form-control">
            </div>
            <div class="mb-3">
                <label for="start_time" class="form-label">Thời gian bắt đầu:</label>
                <input type="time" name="start_time" class="form-control">
            </div>
            <div class="mb-3">
                <label for="end_time" class="form-label">Thời gian kết thúc:</label>
                <input type="time" name="end_time" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary" style="background-color: red">Xếp lịch thi</button>
        </form>
    </div>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
