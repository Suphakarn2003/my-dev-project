<?php
session_start();
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
$stu_id = isset($_GET['stu_id']) ? $_GET['stu_id'] : '';
$dob = isset($_GET['stu_dob']) ? $_GET['stu_dob'] : '';

$student = null;
$status_message = '';
$status_message_class = '';

if (!empty($stu_id)) {
    // Query student data
    $sql_student = "SELECT stu_fname, stu_lname, stu_dob FROM student WHERE stu_id = ?";
    $stmt_student = $conn->prepare($sql_student);
    $stmt_student->bind_param("i", $stu_id);
    $stmt_student->execute();
    $result_student = $stmt_student->get_result();
    $student = $result_student->fetch_assoc();

    if ($student) {
        // Validate date of birth
        if (!empty($dob)) {
            if ($dob === $student['stu_dob']) {
                $status_message = "Date of birth corresponds to the record.";
                $status_message_class = 'success'; // Set class to success

                // Query grades and calculate GPA
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

                    // Convert grade to points
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

                // Calculate GPA
                $gpa = $total_credits ? $total_points / $total_credits : 0;

                // Update GPA in the student table
                $update_gpa_sql = "UPDATE student SET gpa = ? WHERE stu_id = ?";
                $stmt_update_gpa = $conn->prepare($update_gpa_sql);
                $stmt_update_gpa->bind_param("di", $gpa, $stu_id);
                $stmt_update_gpa->execute();
            } else {
                $status_message = "Date of birth does not match the record.";
                $status_message_class = 'error'; // Set class to error
                $student = null;  // Prevent displaying student data
            }
        }
    }
} else {
    // Reset status message if no student ID is present
    $status_message = '';
}

// Clear session message after it's displayed
if (isset($_SESSION['status_message']) && !empty($_SESSION['status_message'])) {
    $status_message = $_SESSION['status_message'];
    $status_message_class = $status_message === "Date of birth corresponds to the record." ? 'success' : 'error';
    $_SESSION['status_message'] = ''; // Clear message
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student GPA Report</title>
    <script>
        function resetForm() {
            document.getElementById('stu_id').value = '';
            document.getElementById('stu_dob').value = '';
        }

        window.onload = function() {
            const params = new URLSearchParams(window.location.search);
            if (!params.has('stu_id')) {
                resetForm();
            }

            // Check if the page is being reloaded
            if (performance.navigation.type === performance.navigation.TYPE_RELOAD) {
                window.location.href = 'http://localhost/khoaw/show_logni_gpa.php?';
            }
        }
    </script>
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
        
        nav {
            background-color: #6200ea;
            border-radius: 8px;
            margin-bottom: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            position: absolute;
            top: 0;
            width: 100%;
            z-index: 1000;
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
            background-color: #3700b3;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
       
        h2 {
            color: #4a4a4a;
            text-align: center;
            margin-bottom: 20px;
            font-size: 26px;
            font-weight: 600;
        }
        p {
            color: #444;
            font-size: 16px;
            margin: 10px 0;
        }
        .status-message {
            font-size: 18px;
            margin-bottom: 20px;
            text-align: center;
            padding: 10px;
            border-radius: 8px;
        }
        .status-message.error {
            background-color: #ffdddd;
            color: #d9534f;
            border: 1px solid #d9534f;
        }
        .status-message.success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
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
            background-color: #007bff;
            color: white;
            font-weight: 600;
        }
        td {
            background-color: #f9f9f9;
        }
        .gpa {
            font-size: 22px;
            font-weight: bold;
            color: #0073e6;
            text-align: right;
            margin-top: 15px;
        }
        .credits {
            font-size: 18px;
            font-weight: bold;
            color: #0073e6;
            text-align: right;
            margin-top: 5px;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        label {
            font-size: 16px;
            color: #333;
        }
        input[type="text"], input[type="date"] {
            padding: 12px;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 16px;
            width: calc(100% - 24px);
        }
        button.bhome,
        input[type="reset"].bhome {
            padding: 20px;
            border: none;
            border-radius: 10px;
            background-color: #007bff;
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-top: 20px;
            text-align: center;
        }
        button.bhome:hover,
        input[type="reset"].bhome:hover {
            background-color: #0056b3;
        }
        button.bhome-secondary {
            background-color: #66CCFF;
            color: black;
        }
        button.bhome-secondary:hover {
            background-color: #5a6268;
        }
        
        nav ul li a {
            font-size: 16px;
            padding: 12px 20px;
        }
        
        /* Add styles to ensure the image fits well */
        .container img {
            width: 100%;
            height: auto;
            margin-bottom: 20px;
            border-radius: 10px;
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
    <h2>Student GPA Report</h2>

    <?php if (!empty($status_message)): ?>
        <p class="status-message <?php echo htmlspecialchars($status_message_class); ?>"><?php echo htmlspecialchars($status_message); ?></p>
    <?php endif; ?>

    <?php if ($stu_id && $student && $status_message === "Date of birth corresponds to the record."): ?>
        <p>Student ID: <?php echo htmlspecialchars($stu_id); ?></p>
        <p>Name: <?php echo htmlspecialchars($student['stu_fname'] . " " . $student['stu_lname']); ?></p>
        <p>Date of Birth: <?php echo htmlspecialchars($student['stu_dob']); ?></p>

        <table>
            <tr>
                <th>Subject ID</th>
                <th>Subject Name</th>
                <th>Credits</th>
                <th>Grade</th>
            </tr>
            <?php
            if (isset($result_grades)) {
                $result_grades->data_seek(0);  // Reset result set cursor
                while ($row = $result_grades->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['sid']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['sname']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['scredit']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['sgrade']) . "</td>";
                    echo "</tr>";
                }
            }
            ?>
        </table>

        <?php if (isset($total_credits) && isset($gpa)): ?>
            <div class="gpa">
                Credits = <?php echo htmlspecialchars($total_credits); ?><br>
                GPA = <?php echo number_format($gpa, 2); ?>
            </div>
        <?php endif; ?>
     
    <?php else: ?>
        <form method="get" action="">
            <label for="stu_id">Student ID:</label>
            <input type="text" name="stu_id" id="stu_id" value="<?php echo isset($_GET['stu_id']) ? htmlspecialchars($_GET['stu_id']) : ''; ?>" required>

            <label for="stu_dob">Date of Birth:</label>
            <input type="date" name="stu_dob" id="stu_dob" value="<?php echo isset($_GET['stu_dob']) ? htmlspecialchars($_GET['stu_dob']) : ''; ?>" required>

            <button class="bhome" type="submit">Submit</button>
            <input class="bhome bhome-secondary" type="reset" value="Reset" onclick="resetForm()">
        </form>
    <?php endif; ?>
</div>
</body>
</html>
