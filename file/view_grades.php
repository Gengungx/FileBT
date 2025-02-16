<?php
session_start();
require_once 'database.php';

// Kiểm tra nếu người dùng chưa đăng nhập
if (!isset($_SESSION['student_id'])) {
    header('Location: login.php');
    exit();
}

// Kiểm tra quyền của người dùng
$is_admin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';

$search_id = isset($_POST['search_id']) ? $_POST['search_id'] : null;
$grades = [];
$students = [];

$db = new Database();
$conn = $db->getConnection();

// Nếu người dùng không phải admin, thực hiện tìm kiếm hoặc lấy tất cả bảng điểm
if (!$is_admin) {
    if ($search_id) {
        // Truy vấn để tìm kiếm bảng điểm của sinh viên cụ thể, loại trừ sinh viên có tên "admin"
        $query = "
            SELECT s.student_id, s.name AS student_name, 
                   MAX(CASE WHEN subj.name = 'C++' THEN g.grade END) AS cpp,
                   MAX(CASE WHEN subj.name = 'C#' THEN g.grade END) AS cs,
                   MAX(CASE WHEN subj.name = 'Cơ sở dữ liệu' THEN g.grade END) AS db_course,
                   MAX(CASE WHEN subj.name = 'PHP' THEN g.grade END) AS php,
                   MAX(CASE WHEN subj.name = 'Java' THEN g.grade END) AS java
            FROM grades g
            JOIN students s ON g.student_id = s.student_id
            JOIN subjects subj ON g.subject_id = subj.subject_id
            WHERE s.student_id = ? AND s.name != 'admin'
            GROUP BY s.student_id;
        ";

        $grades = $db->select($query, [$search_id]);
        if (count($grades) > 0) {
            $students = $grades[0];
        }
    } else {
        // Nếu không tìm kiếm, lấy tất cả bảng điểm, loại trừ sinh viên có tên "admin"
        $query = "
            SELECT s.student_id, s.name AS student_name, 
                   MAX(CASE WHEN subj.name = 'C++' THEN g.grade END) AS cpp,
                   MAX(CASE WHEN subj.name = 'C#' THEN g.grade END) AS cs,
                   MAX(CASE WHEN subj.name = 'Cơ sở dữ liệu' THEN g.grade END) AS db_course,
                   MAX(CASE WHEN subj.name = 'PHP' THEN g.grade END) AS php,
                   MAX(CASE WHEN subj.name = 'Java' THEN g.grade END) AS java
            FROM grades g
            JOIN students s ON g.student_id = s.student_id
            JOIN subjects subj ON g.subject_id = subj.subject_id
            WHERE s.name != 'admin'
            GROUP BY s.student_id
            ORDER BY s.student_id;
        ";

        $grades = $db->select($query);
    }
} else {
    // Nếu là admin, lấy tất cả bảng điểm, không loại trừ sinh viên nào
    if ($search_id) {
        // Tìm kiếm theo ID sinh viên cho admin
        $query = "
            SELECT s.student_id, s.name AS student_name, 
                   MAX(CASE WHEN subj.name = 'C++' THEN g.grade END) AS cpp,
                   MAX(CASE WHEN subj.name = 'C#' THEN g.grade END) AS cs,
                   MAX(CASE WHEN subj.name = 'Cơ sở dữ liệu' THEN g.grade END) AS db_course,
                   MAX(CASE WHEN subj.name = 'PHP' THEN g.grade END) AS php,
                   MAX(CASE WHEN subj.name = 'Java' THEN g.grade END) AS java
            FROM grades g
            JOIN students s ON g.student_id = s.student_id
            JOIN subjects subj ON g.subject_id = subj.subject_id
            WHERE s.student_id = ?
            GROUP BY s.student_id;
        ";

        $grades = $db->select($query, [$search_id]);
        if (count($grades) > 0) {
            $students = $grades[0];
        }
    } else {
        // Nếu không tìm kiếm, lấy tất cả bảng điểm
        $query = "
            SELECT s.student_id, s.name AS student_name, 
                   MAX(CASE WHEN subj.name = 'C++' THEN g.grade END) AS cpp,
                   MAX(CASE WHEN subj.name = 'C#' THEN g.grade END) AS cs,
                   MAX(CASE WHEN subj.name = 'Cơ sở dữ liệu' THEN g.grade END) AS db_course,
                   MAX(CASE WHEN subj.name = 'PHP' THEN g.grade END) AS php,
                   MAX(CASE WHEN subj.name = 'Java' THEN g.grade END) AS java
            FROM grades g
            JOIN students s ON g.student_id = s.student_id
            JOIN subjects subj ON g.subject_id = subj.subject_id
            GROUP BY s.student_id
            ORDER BY s.student_id;
        ";

        $grades = $db->select($query);
    }
}

$db->closeConnection();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bảng điểm sinh viên</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container">
            <a class="navbar-brand text-white" href="#">Bảng điểm sinh viên</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="admin.php">Duyệt yêu cầu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="logout.php">Đăng xuất</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container table-container">
        <h2 class="text-center">Bảng điểm sinh viên</h2>

        <!-- Form tìm kiếm sinh viên -->
        <form action="view_grades.php" method="POST" class="mb-4">
            <div class="form-group">
                <label for="search_id">Tìm kiếm theo ID sinh viên:</label>
                <input type="text" class="form-control" name="search_id" id="search_id" placeholder="Nhập ID sinh viên" value="<?php echo htmlspecialchars($search_id); ?>">
            </div>
            <button type="submit" class="btn btn-primary">Tìm kiếm</button>
        </form>

        <!-- Hiển thị bảng điểm -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID Sinh viên</th>
                    <th>Sinh viên</th>
                    <th>C++</th>
                    <th>C#</th>
                    <th>Cơ sở dữ liệu</th>
                    <th>PHP</th>
                    <th>Java</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($search_id && empty($grades)): ?>
                    <tr>
                        <td colspan="7" class="text-center">Không tìm thấy sinh viên với ID <?php echo htmlspecialchars($search_id); ?>.</td>
                    </tr>
                <?php
                else:
                    foreach ($grades as $row):
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['student_id']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['student_name']) . "</td>";

                        // Hàm inline kiểm tra điểm và gán class CSS tương ứng
                        $displayGrade = function ($grade) {
                            if ($grade === null) return "<td>-</td>";
                            $class = $grade < 5 ? 'grade-fail' : 'grade-pass';
                            return "<td class='$class'>" . htmlspecialchars($grade) . "</td>";
                        };

                        echo $displayGrade($row['cpp']);
                        echo $displayGrade($row['cs']);
                        echo $displayGrade($row['db_course']);
                        echo $displayGrade($row['php']);
                        echo $displayGrade($row['java']);

                        echo "</tr>";
                    endforeach;
                endif;
                ?>
            </tbody>
        </table>
    </div>

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
