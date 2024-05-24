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
    $stmt = $con->prepare("DELETE FROM student WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo 'Data deleted successfully. <a href="read.php">View Users</a>';
    } else {
        die("Error: " . $stmt->error);
    }

    $stmt->close();
    $con->close();
}
?>
