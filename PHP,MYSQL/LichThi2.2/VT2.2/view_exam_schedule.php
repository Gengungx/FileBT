<?php
include 'config.php';

// Xử lý xóa lịch thi nếu có dữ liệu POST gửi đi
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_exam_schedule'])) {
    $delete_id = $_POST['delete_exam_schedule'];
    $sql_delete = "DELETE FROM exam_schedule WHERE id = $delete_id";

    // Execute the delete query
    if ($conn->query($sql_delete) === TRUE) {
        echo "<div class='alert alert-success mt-3'>Đã xoá lịch thi thành công</div>";
    } else {
        echo "<div class='alert alert-danger mt-3'>Không thể xoá lịch thi. Lỗi: " . $conn->error . "</div>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xem Lịch Thi</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            background-color: #f0f0f0;
        }
        .card {
            margin-top: 50px;
        }
        .table-responsive {
            overflow-x: auto;
        }
        .table {
            background-color: #ffffff;
        }
        .table thead th {
            background-color: #007bff;
            color: #ffffff;
            border-color: #007bff;
        }
        .table tbody tr:nth-of-type(even) {
            background-color: #f2f2f2;
        }
        .btn-back {
            background-color: #007bff;
            border-color: #007bff;
            color: #ffffff;
        }
        .btn-back:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
        .navbar {
            background-color: #007bff;
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


    <div class="container">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h2 class="mb-0">Xem Lịch Thi</h2>
            </div>
            <div class="card-body">
                <?php
                // Hiển thị thông báo sau khi xoá lịch thi (nếu có)
                if (isset($_POST['delete_exam_schedule'])) {
                    if ($conn->affected_rows > 0) {
                        echo "<div class='alert alert-success mt-3'>Đã xoá lịch thi thành công</div>";
                    } else {
                        echo "<div class='alert alert-danger mt-3'>Không thể xoá lịch thi. Lỗi: " . $conn->error . "</div>";
                    }
                }
                ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Bài thi</th>
                                <th scope="col">Lớp</th>
                                <th scope="col">Ngày thi</th>
                                <th scope="col">Thời gian bắt đầu</th>
                                <th scope="col">Thời gian kết thúc</th>
                                <th scope="col">Giám thị</th>
                                <th scope="col">Trạng thái</th>
                                <th scope="col">Tên tệp đã upload</th>
                                <th scope="col">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $result = $conn->query("SELECT es.id, e.exam_name, c.class_name, es.exam_date, es.start_time, es.end_time, es.status, ef.file_path 
                                                    FROM exam_schedule es
                                                    JOIN exams e ON es.exam_id = e.id
                                                    JOIN classes c ON e.class_id = c.id
                                                    LEFT JOIN exam_files ef ON es.id = ef.exam_schedule_id");

                            while ($row = $result->fetch_assoc()) {
                                // Lấy thông tin giám thị từ bảng proctor_assignment
                                $proctor_info = '';
                                $proctor_result = $conn->query("SELECT p.name FROM proctors p
                                                               JOIN proctor_assignment pa ON p.id = pa.proctor_id
                                                               WHERE pa.exam_id = ".$row['id']." AND pa.assigned = 1");
                                if ($proctor_result->num_rows > 0) {
                                    while ($proctor_row = $proctor_result->fetch_assoc()) {
                                        $proctor_info .= $proctor_row['name'] . '<br>';
                                    }
                                } else {
                                    $proctor_info = "Chưa phân công";
                                }

                                // Hiển thị tên file
                                $file_name = basename($row['file_path']);
                                $file_name_display = $row['file_path'] ? $file_name : "Chưa có tệp";

                                echo "<tr>
                                        <td>".$row['exam_name']."</td>
                                        <td>".$row['class_name']."</td>
                                        <td>".$row['exam_date']."</td>
                                        <td>".$row['start_time']."</td>
                                        <td>".$row['end_time']."</td>
                                        <td>".$proctor_info."</td>
                                        <td>".$row['status']."</td>
                                        <td>".$file_name_display."</td>
                                        <td>
                                         <form method='post'>
    <input type='hidden' name='delete_exam_schedule' value='".$row['id']."'>
    <button type='submit' class='btn btn-danger'>Xoá</button>
</form>

                                        </td>
                                      </tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    <a href="index.php" class="btn btn-back">Quay lại</a>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
