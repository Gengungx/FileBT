<?php
include 'config.php';

$alert_message = "";

// Lấy danh sách giám thị
function getProctors($conn) {
    $sql = "SELECT id, name FROM proctors";
    $result = $conn->query($sql);

    $proctors = [];
    while ($row = $result->fetch_assoc()) {
        $proctors[] = $row;
    }

    return $proctors;
}

// Cập nhật phân công giám thị cho kỳ thi
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['assign_proctors'])) {
    $exam_id = $_POST['exam_schedule_id']; // Đã thay đổi từ 'exam_id' sang 'exam_schedule_id'
    $proctor_ids = isset($_POST['proctor_ids']) ? $_POST['proctor_ids'] : [];

    // Kiểm tra nếu người dùng không chọn bài thi hoặc không chọn giám thị
    if (empty($exam_id)) {
        $alert_message = "<div class='alert alert-danger mt-3'>Vui lòng chọn bài thi</div>";
    } elseif (empty($proctor_ids)) {
        $alert_message = "<div class='alert alert-danger mt-3'>Vui lòng chọn ít nhất 1 giám thị</div>";
    } else {
        // Xóa các phân công cũ
        $conn->query("DELETE FROM proctor_assignment WHERE exam_id = $exam_id");

        // Thêm phân công mới
        foreach ($proctor_ids as $proctor_id) {
            $conn->query("INSERT INTO proctor_assignment (proctor_id, exam_id, assigned) VALUES ($proctor_id, $exam_id, 1)");
        }

        // Thay đổi màu sắc thông báo thành công
        $alert_message = "<div class='alert alert-success mt-3'>Phân công giám thị thành công</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phân Công Giám Thị</title>
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
        .form-label {
            color: #343a40; /* Đổi màu chữ thành màu tối */
        }
        .form-control {
            background-color: #ffffff; /* Đổi màu nền thành trắng */
            border: 1px solid #dc3545;
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
        <h2>Phân Công Giám Thị</h2>
        <form method="post">
            <input type="hidden" name="assign_proctors" value="1">
            <?php echo $alert_message; ?>
            <div class="mb-3">
                <label for="exam_id" class="form-label">Chọn bài thi:</label>
                <select name="exam_schedule_id" class="form-control">
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

            <div class="mb-3">
                <label for="proctor_ids" class="form-label">Chọn giám thị:</label>
                <div class="form-check">
                    <?php
                    $proctors = getProctors($conn);
                    foreach ($proctors as $proctor) {
                        echo "<div class='form-check'>";
                        echo "<input class='form-check-input' type='checkbox' name='proctor_ids[]' value='".$proctor['id']."' id='proctor_".$proctor['id']."'>";
                        echo "<label class='form-check-label' for='proctor_".$proctor['id']."'>".$proctor['name']."</label>";
                        echo "</div>";
                    }
                    ?>
                </div>
            </div>

            <div class="btn-container">
                <button type="submit" class="btn btn-primary">Phân Công</button>
                <!-- Nút quay lại -->
                <button type="button" class="btn btn-back" onclick="window.location.href='index.php';">Quay lại</button>
            </div>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
