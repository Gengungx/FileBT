<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = $_POST["student_id"];
    $class_id = $_POST["class_id"];
    
    // Lấy thông tin course_id từ class_id
    $sql = "SELECT course_id FROM classes WHERE class_id = '$class_id'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $course_id = $row['course_id'];
    
    // Kiểm tra điều kiện tiên quyết
    $sql = "SELECT prerequisite_course_id FROM prerequisites WHERE course_id = '$course_id'";
    $result = $conn->query($sql);
    $prerequisite_met = true;
    $specific_message = "";  // Biến để lưu thông điệp cụ thể

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $prerequisite_course_id = $row['prerequisite_course_id'];
            $sql_check = "SELECT * FROM completed_courses WHERE student_id = '$student_id' AND course_id = '$prerequisite_course_id'";
            $result_check = $conn->query($sql_check);
            
            // Kiểm tra nếu môn học là "Hệ thống Cơ sở Dữ liệu"
            if ($course_id == 10 && $prerequisite_course_id == 3) {  // Giả sử ID của SQL là 11 và Cơ sở Dữ liệu là 3
                if ($result_check->num_rows == 0) {
                    $specific_message = "Bạn chưa học cơ sở dữ liệu! Không thể đăng ký môn SQL";
                    $prerequisite_met = false;
                    break;
                }
            } else {
                if ($result_check->num_rows == 0) {
                    $prerequisite_met = false;
                    break;
                }
            }
        }
    }
    
    if (!$prerequisite_met) {
        echo $specific_message ?: "Bạn chưa hoàn thành môn học điều kiện tiên quyết! Không thể đăng ký môn học này";
    } else {
        // Chọn bảng đăng ký dựa trên class_id
        if ($class_id >= 1 && $class_id <= 4) {
            $table_name = 'class1_registrations';
        } elseif ($class_id >= 5 && $class_id <= 7) {
            $table_name = 'class2_registrations';
        } elseif ($class_id >= 8 && $class_id <= 10) {
            $table_name = 'class3_registrations';
        }

        // Kiểm tra nếu sinh viên đã đăng ký lớp học này chưa
        $sql = "SELECT * FROM $table_name WHERE student_id = '$student_id' AND course_id = '$course_id'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "Sinh viên đã đăng ký lớp học này!";
        } else {
            // Đăng ký lớp học
            $sql = "INSERT INTO $table_name (student_id, course_id) VALUES ('$student_id', '$course_id')";
            if ($conn->query($sql) === TRUE) {
                echo "Đăng ký thành công!";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }
}

$conn->close();
?>

<!-- Nút Trở Lại -->
<a href="index.php">
    <button>Trở Lại</button>
</a>
