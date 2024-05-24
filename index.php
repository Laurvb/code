<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$host = "localhost";
$dbuser = "root";
$dbpassword = "";
$dbname = "datadase";

$con = new mysqli($host, $dbuser, $dbpassword, $dbname);

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

if (isset($_POST['submit'])) {
    $full_name = htmlspecialchars($_POST['full_name']);
    $registration_number = htmlspecialchars($_POST['registration_number']);
    $email = htmlspecialchars($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $stmt = $con->prepare("INSERT INTO student (full_name, registration_number, email, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $full_name, $registration_number, $email, $password);

    if ($stmt->execute()) {
        echo 'Data inserted successfully. <a href="read.php">View Users</a>';
    } else {
        die("Error: " . $stmt->error);
    }

    $stmt->close();
    $con->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account</title>
    <style>
        body { background-color: blueviolet; color: white; font-family: Arial, sans-serif; }
        center { font-size: 18px; }
        input[type=text], input[type=email], input[type=password] {
            width: 100%; padding: 12px; margin: 8px 0; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px;
        }
        input[type=submit] {
            width: 100%; background-color: #4CAF50; color: white; padding: 14px 20px; margin: 8px 0; border: none; border-radius: 4px; cursor: pointer;
        }
        input[type=submit]:hover { background-color: #45a049; }
    </style>
</head>
<body>
    <center>
        <h1>Online Application</h1>
        <h2>Fill out this form to continue</h2>
        <form action="" method="post">
            <label for="full_name">Full Name:</label>
            <input type="text" name="full_name" placeholder="Enter your full name" required><br><br>
            <label for="registration_number">Registration Number:</label>
            <input type="text" name="registration_number" placeholder="Enter your registration number" required pattern="\d{10}"><br><br>
            <label for="email">Email:</label>
            <input type="email" name="email" placeholder="Enter your email" required><br><br>
            <label for="password">Password:</label>
            <input type="password" name="password" placeholder="Enter your password" required><br><br>
            <input type="submit" name="submit" value="Submit">
        </form>
    </center>
</body>
</html>
