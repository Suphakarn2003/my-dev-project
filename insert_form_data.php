<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เพิ่มรายชื่อสมาชิก</title>
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

/* New styles for menu */
nav {
    background-color: #6200ea; /* Similar to the color in the image */
    border-radius: 8px;
    margin-bottom: 30px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Adds a subtle shadow */
    position: absolute;
    top: 0;
    width: 100%;
    z-index: 1000; /* To ensure it stays on top */
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

.form-container {
    width: 100%;
            height: 100%;
            max-width: 1200px;
            background-color: #ffffff;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
            border-radius: 12px;
            padding: 40px;
            overflow-y: auto; /* Allow vertical scrolling if content overflows */
}

.form-container p {
    margin: 20px 0; /* Increased margin for more spacing between elements */
}

.form-container b {
    display: inline-block;
    width: 120px; /* Increased width for labels */
    margin-right: 15px; /* Increased margin for better spacing */
}

.form-container input[type="text"] {
    width: calc(100% - 135px); /* Adjusted width calculation for larger labels */
    padding: 12px; /* Increased padding for a more comfortable input field */
    border: 1px solid #ccc;
    border-radius: 5px;
}

.submit, .bcancle {
    font-size: 18px; /* Increased font size for better readability */
    padding: 15px 30px; /* Increased padding for larger buttons */
    border: none;
    border-radius: 5px;
    cursor: pointer;
    margin-top: 10px;
    display: inline-block;
}

.submit {
    background-color: #008CBA;
    color: white;
}

.submit:hover {
    background-color: #007bb5;
}

.bcancle {
    background-color: #f44336;
    color: white;
    margin-left: 10px;
}

.bcancle:hover {
    background-color: #e53935;
}

h1 {
    font-size: 36px; /* Reduced font size to fit the container */
    color: #333;
    margin-bottom: 20px;
    text-align: center;
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

    <div class="form-container">
    <center><img src="360_F_256100731_qNLp6MQ3FjYtA3Freu9epjhsAj2cwU9c.jpg" width="100%" height="50%"/></center>
        <h1>เพิ่มรายชื่อสมาชิก</h1>
        <form action="insert_sql_data.php" method="POST">
            <p><b>Name:</b> <input type="text" name="name"></p>
            <p><b>Lastname:</b> <input type="text" name="Lastname"></p>
            <p><b>Home:</b> <input type="text" name="Home"></p>
            <p><b>Pay:</b> <input type="text" name="pay"></p>
            <button type="submit" class="submit">Submit</button>
            <button type="button" class="bcancle" onclick="resetForm()">Cancel</button>
        </form>
    </div>

    <script>
        function resetForm() {
            document.querySelector('form').reset();
        }
    </script>
</body>
</html>
