<?php
// ตั้งค่าการเชื่อมต่อฐานข้อมูล
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "personnel";

// สร้างการเชื่อมต่อ
$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// รับค่า ID จาก URL
$id = $_GET['id'];

// สร้างคำสั่ง SQL เพื่อลบข้อมูล
$sql = "DELETE FROM student WHERE stu_id=$id";

if ($conn->query($sql) === TRUE) {
    echo "Record deleted successfully";
} else {
    echo "Error deleting record: " . $conn->error;
}

// ปิดการเชื่อมต่อ
$conn->close();

// ย้อนกลับไปยังหน้าแรกหรือหน้าแสดงข้อมูล
header("Location: show_all_data.php");
exit();
?>