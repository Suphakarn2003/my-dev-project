<?php
// การเชื่อมต่อกับฐานข้อมูล
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "personnel";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$conn->set_charset('utf8mb4');
$success_message = "";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = $conn->prepare("SELECT stu_fname, stu_lname, stu_home, pay FROM student WHERE stu_id=?");
    $sql->bind_param("s", $id);
    $sql->execute();
    $result = $sql->get_result();

    if ($result === false) {
        echo "Error: " . $conn->error;
        exit;
    }

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc(); // ดึงข้อมูลแถวแรกออกมา
        $name = $row['stu_fname'];
        $lastname = $row['stu_lname'];
        $home = $row['stu_home'];
        $pay = $row['pay'];
    } else {
        echo "Record not found";
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $lastname = $_POST['lastname'];
    $home = $_POST['home'];
    $pay = $_POST['pay'];
    $id = $_POST['id'];

    $sql = $conn->prepare("UPDATE student SET stu_fname=?, stu_lname=?, stu_home=?, pay=? WHERE stu_id=?");
    $sql->bind_param("sssss", $name, $lastname, $home, $pay, $id);

    if ($sql->execute() === TRUE) {
        $success_message = "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #7c4dff;
        }

        .button-container {
            text-align: center;
            margin-bottom: 20px;
           /* text-align: left;*/
        }

        .bhome {
            font-size: 16px;
            padding: 10px 200px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 15px;
            cursor: pointer;
        }

        .bhome:hover {
            background-color: #45a049;
        }

        .form-container {
            display: inline-block;
            border: 4px solid #ccc;
            padding: 20px;
            border-radius: 10px;
            background-color: #FFFFFF;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 400px;
            text-align: left;
        }

        .form-container p {
            margin: 15px 0;
        }

        .form-container b {
            display: inline-block;
            width: 100px;
            margin-right: 10px;
        }

        .form-container input[type="text"], .form-container input[type="hidden"] {
            width: calc(100% - 33px);
            height: 50px;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .update-button, .cancel-button, .reset-button {
            font-size: 20px;
            padding: 10px 20px;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-right: 10px;
        }

        .update-button {
            background-color: #008CBA;
        }

        .update-button:hover {
            background-color: #007bb5;
        }

        .cancel-button {
            background-color: #f44336;
        }

        .cancel-button:hover {
            background-color: #da190b;
        }

        .reset-button {
            background-color: #ffa500;
        }

        .reset-button:hover {
            background-color: #ff8c00;
        }

        h1 {
            font-size: 50px;
            color: #333;
            margin-bottom: 20px;
        }

        .modal {
            display: <?php echo $success_message ? 'block' : 'none'; ?>;
            position: fixed;
            z-index: 1;
            padding-top: 100px;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0,0,0);
            background-color: rgba(0,0,0,0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 300px;
            text-align: center;
        }

        .modal-button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
            margin-top: 20px;
        }

        .modal-button:hover {
            background-color: #45a049;
        }
        h1 {
            font-size: 45px;
            color: #333;
            margin-bottom: 20px;
            border: 2px solid #333;
            padding: 10px;
            border-radius: 10px;
            display: inline-block;
        }
    </style>
</head>
<body>
    <center>
       
        <div class="form-container">
            <form method="post" action="edit_data.php">
           <center> <p><h1>Edit member information</h1></p></center>
                <p><b>ID</b><input type="text" name="id_display" value="<?php echo isset($id) ? $id : ''; ?>" disabled></p>
                <input type="hidden" name="id" value="<?php echo isset($id) ? $id : ''; ?>">
                <p><b>Name</b><input type="text" name="name" value="<?php echo isset($name) ? $name : ''; ?>"></p>
                <p><b>Lastname</b><input type="text" name="lastname" value="<?php echo isset($lastname) ? $lastname : ''; ?>"></p>
                <p><b>Home</b><input type="text" name="home" value="<?php echo isset($home) ? $home : ''; ?>"></p>
                <p><b>Pay</b><input type="text" name="pay" value="<?php echo isset($pay) ? $pay : ''; ?>"></p>
                <input type="submit" value="Update" class="update-button">
                <input type="reset" value="Cancel" class="cancel-button">
                <input type="button" value="Reset" class="reset-button" onclick="resetForm()">
            </form>
        </div>
        <script>
            function resetForm() {
                document.querySelector('input[name="name"]').value = '';
                document.querySelector('input[name="lastname"]').value = '';
                document.querySelector('input[name="home"]').value = '';
                document.querySelector('input[name="pay"]').value = '';
            }
        </script>
    </center>

    <?php if ($success_message) : ?>
        <div id="myModal" class="modal">
            <div class="modal-content">
                <p><?php echo $success_message; ?></p>
                <button class="modal-button" onclick="location.href='show_all_data.php'">OK</button>
            </div>
        </div>
    <?php endif; ?>
    <p><div class="button-container">
        <button id="addButton" class="bhome" onclick="location.href='show_all_data.php'">Home</button>
    </div></p>
</body>
</html>
