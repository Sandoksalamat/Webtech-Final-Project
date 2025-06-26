<?php
// Include the database connection file
require_once("db.php");

$feedback = "";
$feedback_type = "";

if (isset($_POST['update'])) {
    // Escape special characters for SQL
    $student_id = mysqli_real_escape_string($conn, $_POST['student_id']);
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $age = mysqli_real_escape_string($conn, $_POST['age']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    // Check for empty fields
    if (empty($full_name) || empty($age) || empty($email)) {
        $feedback = "All fields are required. Please fill in the missing information.";
        $feedback_type = "danger";
    } else {
        // Update the database
        $result = mysqli_query($conn, "UPDATE students SET `full_name` = '$full_name', `age` = '$age', `email` = '$email' WHERE `student_id` = '$student_id'");

        if ($result) {
            $feedback = "Student data updated successfully!";
            $feedback_type = "success";
        } else {
            $feedback = "Error updating data. Please try again.";
            $feedback_type = "danger";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Confirmation</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
    <style>
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f2f2f2;
        }
        .card {
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            width: 500px;
            text-align: center;
        }
        .btn-custom {
            background-color: #FFC107;
            color: white;
            width: 100%;
        }
        .btn-custom:hover {
            background-color: #e0a800;
        }
    </style>
    <script>
        function redirectToHome() {
            setTimeout(function() {
                window.location.href = 'index.php';
            }, 2000); // 2-second delay
        }
    </script>
</head>
<body <?php if ($feedback_type === 'success') echo 'onload="redirectToHome()"'; ?>>

<div class="card">
    <?php if ($feedback): ?>
        <div class="alert alert-<?php echo $feedback_type; ?>">
            <?php echo $feedback; ?>
        </div>
        <?php if ($feedback_type === 'success'): ?>
            <p>Redirecting to homepage...</p>
        <?php else: ?>
            <a href="javascript:self.history.back();" class="btn btn-custom mt-3">Go Back</a>
        <?php endif; ?>
    <?php else: ?>
        <p>No update data received.</p>
        <a href="index.php" class="btn btn-custom mt-3">Go Home</a>
    <?php endif; ?>
</div>

</body>
</html>
