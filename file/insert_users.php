<?php
require_once 'database.php';

$db = new Database();
$conn = $db->getConnection();

// Danh sách sinh viên
$students = [
    ['username' => 'student1', 'password' => 'password1', 'student_id' => 1],
    ['username' => 'student2', 'password' => 'password2', 'student_id' => 2],
    ['username' => 'student3', 'password' => 'password3', 'student_id' => 3],
    ['username' => 'student4', 'password' => 'password4', 'student_id' => 4],
    ['username' => 'student5', 'password' => 'password5', 'student_id' => 5],
    ['username' => 'student6', 'password' => 'password6', 'student_id' => 6],
    ['username' => 'student7', 'password' => 'password7', 'student_id' => 7],
    ['username' => 'student8', 'password' => 'password8', 'student_id' => 8],
    ['username' => 'student9', 'password' => 'password9', 'student_id' => 9],
    ['username' => 'student10', 'password' => 'password10', 'student_id' => 10],
    ['username' => 'student11', 'password' => 'password11', 'student_id' => 11],
    ['username' => 'student12', 'password' => 'password12', 'student_id' => 12],
    ['username' => 'student13', 'password' => 'password13', 'student_id' => 13],
    ['username' => 'student14', 'password' => 'password14', 'student_id' => 14],
    ['username' => 'student15', 'password' => 'password15', 'student_id' => 15],
    ['username' => 'student16', 'password' => 'password16', 'student_id' => 16],
    ['username' => 'student17', 'password' => 'password17', 'student_id' => 17],
    ['username' => 'student18', 'password' => 'password18', 'student_id' => 18],
    ['username' => 'student19', 'password' => 'password19', 'student_id' => 19],
    ['username' => 'student20', 'password' => 'password20', 'student_id' => 20],
];

foreach ($students as $student) {
    $username = $student['username'];
    $password = md5($student['password']);
    $student_id = $student['student_id'];

    $sql = "INSERT INTO users (username, password, student_id) VALUES ('$username', '$password', $student_id);";
    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully for $username\n";
    } else {
        echo "Error: " . $sql . "\n" . $conn->error;
    }
}

$db->closeConnection();
?>
