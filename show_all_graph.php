<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ข้อมูลลูกค้า</title>
    <style>
        * {
            box-sizing: border-box;
        }
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
        .button-container {
            margin-bottom: 30px;
            display: flex;
            justify-content: space-around;
            gap: 20px;
        }

        button {
            padding: 15px 30px;
            border: none;
            border-radius: 8px;
            font-size: 18px;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease, box-shadow 0.3s ease;
        }

        button:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
        }

        #addButton1 {
            background-color: #4CAF50;
        }

        #addButton2 {
            background-color: #3498db;
        }

        #addButton3 {
            background-color: #f39c12;
        }

        .htitle {
            color: #333;
            font-size: 48px;
            margin-bottom: 40px;
            font-weight: 700;
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        table {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
            background-color: #fafafa;
            border-radius: 8px;
            overflow: hidden;
        }

        th {
            background-color: #7c4dff;
            color: white;
            padding: 12px;
            font-weight: 600;
            text-transform: uppercase;
            text-align: left;
        }

        td {
            padding: 12px;
            font-size: 16px;
            color: #555;
            border-bottom: 1px solid #eaeaea;
        }

        tr:last-child td {
            border-bottom: none;
        }

        tr:nth-child(odd) td {
            background-color: #f9f9f9;
        }

        tr:nth-child(even) td {
            background-color: #e0e0ff;
        }

        .centered-cell {
            text-align: center;
        }

        .edit-link, .delete-link, .gpq-link {
            color: #ffffff;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 16px;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }

        .edit-link {
            background-color: #f1c40f;
        }

        .edit-link:hover {
            background-color: #e2b007;
            box-shadow: 0 4px 10px rgba(241, 196, 15, 0.3);
        }

        .delete-link {
            background-color: #e74c3c;
        }

        .delete-link:hover {
            background-color: #c0392b;
            box-shadow: 0 4px 10px rgba(231, 76, 60, 0.3);
        }

        .gpq-link {
            background-color: #3498db;
        }

        .gpq-link:hover {
            background-color: #2980b9;
            box-shadow: 0 4px 10px rgba(52, 152, 219, 0.3);
        }

        /* New styles for GPA bar graph */
        .gpa-bar-container {
            position: relative;
            background-color: #e0e0e0;
            height: 24px;
            width: 100%;
            border-radius: 12px;
            overflow: hidden;
            margin: 8px 0;
        }

        .gpa-bar {
            height: 100%;
            background-color: #3498db;
            text-align: right;
            padding-right: 5px;
            color: white;
            font-weight: bold;
            line-height: 24px;
            border-radius: 12px 0 0 12px;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .htitle {
                font-size: 36px;
            }

            button {
                font-size: 16px;
                padding: 12px 20px;
            }

            th, td {
                font-size: 14px;
                padding: 10px;
            }
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
        <h1 class="htitle">Student Information</h1>
        <?php
     $servername = "localhost";
     $username = "root";
     $password = "";
     $dbname = "personnel";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $conn->set_charset('utf8mb4');
        $sql = "SELECT * FROM `student`";
        $result = $conn->query($sql);

        if ($result === false) {
            die("Query failed: " . $conn->error);
        }

        echo "<table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Lastname</th>
            <th>Home</th>
            <th>Pay</th>
            <th>GPA</th>
            <th>Graph GPA</th>
        </tr>";

        if (mysqli_num_rows($result) > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td class='centered-cell'>" . $row["stu_id"] . "</td>";
                echo "<td class='centered-cell'>" . $row["stu_fname"] . "</td>";
                echo "<td class='centered-cell'>" . $row["stu_lname"] . "</td>";
                echo "<td class='centered-cell'>" . $row["stu_home"] . "</td>";
                echo "<td class='centered-cell'>" . $row["pay"] . "</td>";
                echo "<td class='centered-cell'><a href='show_gpa.php?stu_id=" . $row["stu_id"] . "' class='gpq-link'>GPA</a> " . $row["gpa"] . "</td>";

                // Calculate bar width as a percentage (assuming GPA is out of 4.0)
                $maxGPA = 4.0; // or 5.0 depending on your grading scale
                $gpa = $row["gpa"];
                $barWidth = ($gpa / $maxGPA) * 100; // Calculate the width percentage

                // Display the GPA graph bar
                echo "<td class='centered-cell'>
                        <div class='gpa-bar-container'>
                            <div class='gpa-bar' style='width: " . $barWidth . "%;'>" . $gpa . "</div>
                        </div>
                      </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='7' class='centered-cell'>0 results</td></tr>";
        }

        echo "</table>";

        $conn->close();
        ?>
    </div>
</body>
</html>
