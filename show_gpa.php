<?php
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
$conn->set_charset('utf8mb4');
// รับ stu_id จาก URL
$stu_id = $_GET['stu_id'];

// Query ข้อมูลนักศึกษา
$sql_student = "SELECT stu_fname, stu_lname FROM student WHERE stu_id = ?";
$stmt_student = $conn->prepare($sql_student);
$stmt_student->bind_param("i", $stu_id);
$stmt_student->execute();
$result_student = $stmt_student->get_result();
$student = $result_student->fetch_assoc();

// Query เกรดนักศึกษาและคำนวณ GPA
$sql_grades = "SELECT subject.sid, subject.sname, register.sgrade, subject.scredit
               FROM register
               INNER JOIN subject ON register.sid = subject.sid
               WHERE register.stu_id = ?";
$stmt_grades = $conn->prepare($sql_grades);
$stmt_grades->bind_param("i", $stu_id);
$stmt_grades->execute();
$result_grades = $stmt_grades->get_result();

$total_credits = 0;
$total_points = 0;

while ($row = $result_grades->fetch_assoc()) {
    $grade = $row['sgrade'];
    $credits = $row['scredit'];

    // แปลงเกรดเป็นคะแนน
    $points = 0;
    switch($grade) {
        case 'A': $points = 4.0; break;
        case 'B+': $points = 3.5; break;
        case 'B': $points = 3.0; break;
        case 'C+': $points = 2.5; break;
        case 'C': $points = 2.0; break;
        case 'D+': $points = 1.5; break;
        case 'D': $points = 1.0; break;
        case 'F': $points = 0.0; break;
    }

    $total_credits += $credits;
    $total_points += ($points * $credits);
}

// คำนวณ GPA
$gpa = $total_credits ? $total_points / $total_credits : 0;

// อัปเดต GPA ในตาราง student
$update_gpa_sql = "UPDATE student SET gpa = ? WHERE stu_id = ?";
$stmt_update_gpa = $conn->prepare($update_gpa_sql);
$stmt_update_gpa->bind_param("di", $gpa, $stu_id);
$stmt_update_gpa->execute();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student GPA Report</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #b388ff, #7c4dff);
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            margin: 0;
            height: 100vh;
        }

        .container {
            width: 70%;
            background-color: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 700px;
        }

        h2 {
            color: #7c4dff;
            font-size: 26px;
            margin-bottom: 20px;
            font-weight: 600;
        }

        p {
            font-size: 18px;
            margin-bottom: 15px;
            color: #555;
        }

        table {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }

        table, th, td {
            border: none;
        }

        th {
            background-color: #7c4dff;
            color: white;
            padding: 10px;
            font-weight: 600;
            text-transform: uppercase;
        }

        td {
            padding: 10px;
            font-size: 16px;
            color: #333;
            background-color: #f9f9f9;
            border-bottom: 1px solid #ddd;
        }

        tr:hover td {
            background-color: #ede7f6;
        }

        .gpa {
            font-weight: 600;
            font-size: 22px;
            margin-top: 20px;
            color: #7c4dff;
        }

        .total-credits {
            font-size: 18px;
            color: #333;
            margin-top: 15px;
        }

        .bhome {
            background-color: #7c4dff;
            color: white;
            border: none;
            padding: 12px 20px;
            font-size: 16px;
            font-weight: 600;
            border-radius: 8px;
            cursor: pointer;
            margin: 10px 5px;
            transition: background-color 0.3s ease;
        }

        .bhome:hover {
            background-color: #b388ff;
        }

        @media (max-width: 768px) {
            .container {
                width: 90%;
                padding: 20px;
            }

            h2 {
                font-size: 24px;
            }

            p {
                font-size: 16px;
            }

            table, th, td {
                font-size: 14px;
            }

            .gpa {
                font-size: 20px;
            }

            .total-credits {
                font-size: 16px;
            }

            .bhome {
                padding: 10px 15px;
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Student GPA Report</h2>
        <p>Student ID: <?php echo $stu_id; ?></p>
        <p>Name: <?php echo $student['stu_fname'] . " " . $student['stu_lname']; ?></p>

        <table>
            <tr>
                <th>Subject ID</th>
                <th>Subject Name</th>
                <th>Credits</th>
                <th>Grade</th>
            </tr>
            <?php
            $result_grades->data_seek(0);  // Reset result set cursor

            while ($row = $result_grades->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['sid'] . "</td>";
                echo "<td>" . $row['sname'] . "</td>";
                echo "<td>" . $row['scredit'] . "</td>";
                echo "<td>" . $row['sgrade'] . "</td>";
                echo "</tr>";
            }
            ?>
        </table>


        <div class="gpa">
        Total Credits = <?php echo $total_credits; ?>
            GPA = <?php echo number_format($gpa, 2); ?>
        </div>
        <button id="addButton" class="bhome" onclick="location.href='show_all_data.php'">ย้อนกลับ</button>
        <button id="addButton" class="bhome" onclick="location.href='regis_page.php'">ลงทะเบียนเรียน</button>
    </div>

    <?php
    $stmt_student->close();
    $stmt_grades->close();
    $stmt_update_gpa->close();
    $conn->close();
    ?>
</body>
</html>
