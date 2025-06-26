<?php
require_once("dbConnection.php");

$student_id = $_GET['student_id'];

$result = mysqli_query($mysqli, "SELECT * FROM students WHERE student_id = '$student_id'");
$resultData = mysqli_fetch_assoc($result);

$full_name = $resultData['full_name'];
$age = $resultData['age'];
$email = $resultData['email'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Student</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
    <style>
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f2f2f2;
        }
        .form-container {
            background-color: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            width: 500px;
        }
        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #333333;
            font-weight: bold;
        }
        .btn-custom {
            background-color: #FFC107;
            color: white;
            width: 100%;
        }
        .btn-custom:hover {
            background-color: #e0a800;
        }
        .back-link {
            display: block;
            text-align: center;
            margin-bottom: 20px;
            color: #333333;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Edit Student</h2>
    <a href="index.php" class="back-link">Back to Home</a>
    <form name="edit" method="post" action="editAction.php">
        <div class="mb-3">
            <label for="full_name" class="form-label">Full Name</label>
            <input type="text" class="form-control" name="full_name" value="<?php echo $full_name; ?>" required>
        </div>
        <div class="mb-3">
            <label for="age" class="form-label">Age</label>
            <input type="number" class="form-control" name="age" value="<?php echo $age; ?>" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" name="email" value="<?php echo $email; ?>" required>
        </div>
        <input type="hidden" name="student_id" value="<?php echo $student_id; ?>">
        <button type="submit" name="update" class="btn btn-custom">Update Student</button>
    </form>
</div>

</body>
</html>
