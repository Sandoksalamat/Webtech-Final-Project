<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* nilagyan ko lang pang pa angas*/
        body {
            background-color: #f4f9fc; /* Light blue background for a welcoming feel */
        }
        .welcome-card {
            background-color: #ffffff; /* White card background */
            border-radius: 15px; /* Rounded corners */
            box-shadow: 0 4px 8px rgba(0,0,0,0.1); /* Subtle shadow for depth */
        }
        .btn-custom {
            background-color: #6f42c1; /* Custom button color */
            color: white;
        }
        .btn-custom:hover {
            background-color: #5a32a1; /* Darker shade on hover */
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <div class="card welcome-card">
        <div class="card-body text-center">
            <h2 class="mb-4">Welcome Engineer, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
            <a href="index.php" class="btn btn-custom mt-3">Get Started</a>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
