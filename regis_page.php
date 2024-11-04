<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "personnel";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$conn->set_charset('utf8mb4');
$message = ""; // Initializing $message variable

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $stu_id = $_POST['stu_id'];
    $sid = $_POST['sid'];
    $sgrade = $_POST['sgrade'];

    // Prepared statement to prevent SQL Injection
    $stmt = $conn->prepare("INSERT INTO register (stu_id, sid, sgrade) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $stu_id, $sid, $sgrade);

    if ($stmt->execute()) {
        // Set success message
        $message = "ลงทะเบียนเรียนสำเร็จ";
    } else {
        $message = "Error: " . $stmt->error;
    }

    $stmt->close();

    // Store the message in session to display after redirect
    session_start();
    $_SESSION['message'] = $message;

    // Redirect to the same page with a GET request to prevent resubmission
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Display success message if available
session_start();
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>ลงทะเบียนเรียน</title>
    <style>
    body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            margin: 0;
            height: 100vh;
            padding: 0;
            overflow: hidden; /* Prevent scrolling */
        }
        .container {
            width: 100%;
            height: 100%;
            max-width: 1200px;
            background-color: #ffffff;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
            border-radius: 12px;
            padding: 40px;
            overflow-y: auto; /* Allow vertical scrolling if content overflows */
        }
      /* New styles for menu */
      nav {
            background-color: #6200ea; /* Similar to the color in the image */
            border-radius: 8px;
            margin-bottom: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Adds a subtle shadow */
            position: absolute;
            top: 0;
            width: 100%;
            z-index: 1000; /* ให้อยู่ด้านบนสุด */
        }

        nav ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            justify-content: space-around;
            align-items: center;
        }

        nav ul li {
            margin: 0;
        }

        nav ul li a {
            display: block;
            padding: 15px 30px;
            color: #ffffff;
            text-decoration: none;
            font-size: 18px;
            font-weight: bold;
            transition: background-color 0.3s ease, transform 0.3s ease, box-shadow 0.3s ease;
            border-radius: 8px;
        }

        nav ul li a:hover {
            background-color: #3700b3; /* Darker color on hover */
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Hover effect similar to the image */
        }
    h2 {
        text-align: center;
        color: #333;
    }
    .form-group {
        margin-bottom: 15px;
    }
    label {
        display: block;
        margin-bottom: 5px;
        color: #555;
    }
    input[type="text"], input[type="submit"], input[type="reset"] {
        width: 100%;
        padding: 10px;
        margin-top: 5px;
        margin-bottom: 15px;
        border-radius: 5px;
        border: 1px solid #ccc;
        box-sizing: border-box;
    }
    input[type="submit"], input[type="reset"] {
        background-color: #4CAF50;
        width: 10%;
        color: white;
        cursor: pointer;
        margin-bottom: 0;
    }
    input[type="reset"] {
        background-color: #f44336;
    }
    input[type="submit"]:hover, input[type="reset"]:hover {
        background-color: #45a049;
    }
    .message {
        text-align: center;
        color: #4CAF50;
        font-weight: bold;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }
    table, th, td {
        border: 1px solid #ddd;
    }
    th, td {
        padding: 12px;
        text-align: left;
    }
    th {
        background-color: #000080;
        color: white;
    }
    tr:nth-child(even) {
        background-color: #f2f2f2; /* สีอ่อน */
    }
    tr:nth-child(odd) {
        background-color: #e9e9e9; /* สีเข้ม */
    }
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0,0,0,0.4);
    }
    .modal-content {
        background-color: #fefefe;
        margin: 15% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
        max-width: 500px;
        border-radius: 8px;
    }
    .modal-button {
        background-color: #4CAF50;
        border: none;
        color: white;
        padding: 10px 20px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        border-radius: 4px;
        cursor: pointer;
    }
       
        nav ul li a {
            font-size: 16px;
            padding: 12px 20px;
        }
    </style>
</head>
<body>
    <nav>
            <ul>
            <li><a href="show_all_data.php">Home</a></li>
            <li><a href="regis_page.php">regis</a></li>
                <li><a href="insert_form_data.php">Add+</a></li>
                <li><a href="show_all_graph.php">graph</a></li>
                <li><a href="show_logni_gpa.php">online</a></li>
            </ul>
        </nav>
      
    <div class="container">
    <center><img src="360_F_256100731_qNLp6MQ3FjYtA3Freu9epjhsAj2cwU9c.jpg" width="100%" height="50%"/></center>
        <h2>ลงทะเบียนเรียน</h2>
        <?php if (!empty($message)) { echo '<p class="message">' . $message . '</p>'; } ?>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="form-group">
                <label>รหัสนักศึกษา:</label>
                <input type="text" name="stu_id" required>
            </div>
            <div class="form-group">
                <label>รหัสวิชา:</label>
                <input type="text" name="sid" required>
            </div>
            <div class="form-group">
                <label>เกรด:</label>
                <input type="text" name="sgrade" required>
            </div>
            <center>
            <input type="submit" value="บันทึก">
            <input type="reset" value="เคลียร์">
            </center>
        </form>

        <?php
        $sql = "SELECT * FROM register 
                INNER JOIN subject ON register.sid = subject.sid 
                INNER JOIN student ON register.stu_id = student.stu_id 
                ORDER BY regid DESC LIMIT 10";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<table>";
            echo "<tr><th>ลำดับที่</th><th>รหัสนักศึกษา</th><th>ชื่อนักศึกษา</th><th>รหัสวิชา</th><th>ชื่อวิชา</th><th>เกรด</th></tr>";
            
            $counter = 1; // Counter for numbering
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["regid"]  . "</td>";
                echo "<td>" . $row["stu_id"] . "</td>";
                echo "<td>" . $row["stu_fname"] . " " . $row["stu_lname"] . "</td>";
                echo "<td>" . $row["sid"] . "</td>";
                echo "<td>" . $row["sname"] . "</td>";
                echo "<td>" . $row["sgrade"] . "</td>";
                echo "</tr>";
                $counter++; // Increment counter after displaying
            }
            echo "</table>";
        } else {
            echo "<p class='message'>ยังไม่มีข้อมูลการลงทะเบียน</p>";
        }
        $conn->close();
        ?>

        <?php if ($message == "ลงทะเบียนเรียนสำเร็จ"): ?>
        <div id="myModal" class="modal">
            <div class="modal-content">
                <p><?php echo $message; ?></p>
                <button class="modal-button" onclick="closeModal()">OK</button>
            </div>
        </div>
        <script>
            // Function to close the modal and redirect back to the main page
            function closeModal() {
                document.getElementById("myModal").style.display = "none";
                window.location.href = "<?php echo $_SERVER['PHP_SELF']; ?>";
            }

            // Show the modal
            document.getElementById("myModal").style.display = "block";
        </script>
        <?php endif; ?>

    </div>
</body>
</html>
