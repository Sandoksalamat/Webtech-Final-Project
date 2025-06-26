<?php
// Include the database connection file
require_once("db.php"); // Changed from dbConnection.php

// Get student_id parameter value from URL
$student_id = $_GET['student_id']; // Changed 'id' to 'student_id'

// Delete row from the database table
$result = mysqli_query($conn, "DELETE FROM students WHERE student_id = '$student_id'"); // Changed table from 'users' to 'students' and column from 'id' to 'student_id'

// Redirect to the main display page (index.php in our case)
echo "<script>alert('Data deleted successfully!');</script>"; // Changed alert to be displayed before header redirect
header("Location:index.php");
exit(); // Added exit to prevent further script execution after redirect
?>
