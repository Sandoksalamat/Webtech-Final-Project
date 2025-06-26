<?php
$host = 'localhost';
$db   = 'bs_business_admin';
$user = 'root';
$pass = ''; // Replace with your MySQL password

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die('Connection failed in db.php: ' . $conn->connect_error); // Added "in db.php"
}
?>
