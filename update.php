<?php
$host = "localhost";
$dbuser = "root";
$dbpassword = "";
$dbname = "datadase";

$con = new mysqli($host, $dbuser, $dbpassword, $dbname);

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $result = $con->query("SELECT * FROM student WHERE id = $id");

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $full_name = $row['full_name'];
        $registration_number = $row['registration_number'];
        $email = $row['email'];
    }
}

if (isset($_POST['update'])) {
    $id = intval($_POST['id']);
    $full_name = htmlspecialchars($_POST['full_name']);
    $registration_number = htmlspecialchars($_POST['registration_number']);
    $email = htmlspecialchars($_POST['email']);

    $stmt = $con->prepare("UPDATE student SET full_name = ?, registration_number = ?, email = ? WHERE id = ?");
    $stmt->bind_param("sssi", $full_name, $registration_number, $email, $id);

    if ($stmt->execute()) {
        echo 'Data updated successfully. <a href="read.php">View Users</a>';
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
    <title>Update Account</title>
    <style>
        body { background-color: blueviolet; color: red; font-family: Arial, sans-serif; }
        center { font-size: 18px; }
        input[type=text], input[type=email] {
            width: 100%; padding: 12px; margin: 8px 0; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px;
        }
        input[type=submit] {
            width: 100%; background-color: #4CAF50; color: white; padding: 14px 20px; margin: 8px 0; border: none; border-radius: 4px; cursor: pointer;
        }
        input[type=submit]:hover { background-color: green; }
    </style>
</head>
<body>
    <center>
        <h1>Update Application</h1>
        <h2>Update the form to continue</h2>
        <form action="" method="post">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <label for="full_name">Full Name:</label>
            <input type="text" name="full_name" value="<?php echo $full_name; ?>" placeholder="Enter your full name" required><br><br>
            <label for="registration_number">Registration Number:</label>
            <input type="text" name="registration_number" value="<?php echo $registration_number; ?>" placeholder="Enter your registration number" required pattern="\d{10}"><br><br>
            <label for="email">Email:</label>
            <input type="email" name="email" value="<?php echo $email; ?>" placeholder="Enter your email" required><br><br>
            <input type="submit" name="update" value="Update">
        </form>
    </center>
</body>
</html>
