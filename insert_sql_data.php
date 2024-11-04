<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
         h1 {
    margin-top: 50px;
    text-align: center;
    color: #424242;
}

      table {
            width: 100%;
            border-collapse: collapse;
            margin: 25px 0;
            font-size: 18px;
            text-align: center;
            background-color:#CCCCFF;
            border-radius: 15px
        }
        .bhome{
            background-color: #48a0ee;
            padding: 10px 20px;
            border-radius: 15px
        }
        .bsert{
            background-color: #48ee98;
            padding: 10px 20px;
            border-radius: 15px
        }

    </style>
</head>
<body bgcolor="#faf2b5">
<div class="button-container">
            <button id="addButton" class="bhome" onclick="location.href='show_all_data.php'">Home</button>
            <button id="addButton" class="bsert" onclick="location.href='insert_form_data.php'">Insert</button>
        </div>
    <center>
    <table>
                <tr>
                <td>
                <h1>Welcome new members </h1>
</td>
        </tr>
        </table>
</center>


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
// รับข้อมูลจากฟอร์มผ่านตัวแปร $_POST
$name = $_POST['name'];
$lastname = $_POST['Lastname'];
$home = $_POST['Home'];
$pay = $_POST['pay'];

// คำสั่ง SQL เพื่อเพิ่มข้อมูลใหม่
$sql = "INSERT INTO student (stu_fname, stu_lname, stu_home, pay , gpa ,stu_dob) VALUES ('$name', '$lastname', '$home', '$pay','0.00' ,'22-22-2022')";

// ประมวลผลคำสั่ง SQL
if ($conn->query($sql) === TRUE) {
 
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// ปิดการเชื่อมต่อ
$conn->close();
?>
</body>
</html>