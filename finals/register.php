<?php
session_start();
require 'db.php';

$username = $password = $confirm_password = "";
$errors = [];
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    if (empty($username)) {
        $errors[] = "Username is required";
    }

    if (empty($password)) {
        $errors[] = "Password is required";
    }

    if ($password !== $confirm_password) {
        $errors[] = "Passwords do not match";
    }

    if (empty($errors)) {
        $username = mysqli_real_escape_string($conn, $username);
        $password = mysqli_real_escape_string($conn, $password);

        $check_query = "SELECT * FROM users WHERE username = '$username'";
        $check_result = mysqli_query($conn, $check_query);

        if (mysqli_num_rows($check_result) > 0) {
            $errors[] = "Username is already taken";
        } else {
            $hashed_password = hash('sha256', $password);
            $insert_query = "INSERT INTO users (username, password) VALUES ('$username', '$hashed_password')";
            if (mysqli_query($conn, $insert_query)) {
                $success = "You have successfully registered. You can now log in to your account.";
                $username = $password = $confirm_password = "";
            } else {
                $errors[] = "Error while registering. Please try again.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Account</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f2f2f2;
        }
        .container-custom {
            display: flex;
            width: 900px;
            height: 500px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            border-radius: 15px;
            overflow: hidden;
        }
        .left-section {
            background: linear-gradient(135deg, #333333, #555555);
            color: white;
            width: 45%;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .left-section h2 {
            font-size: 28px;
            font-weight: bold;
        }
        .left-section img {
            width: 100%;
            max-width: 300px;
            margin-top: 20px;
        }
        .right-section {
            background: white;
            padding: 40px;
            width: 55%;
        }
        .form-control {
            height: 45px;
            border-radius: 8px;
        }
        .btn-custom {
            background-color: #FFC107;
            color: white;
            width: 100%;
            height: 45px;
            border-radius: 8px;
            border: none;
        }
        .btn-custom:hover {
            background-color: #e0a800;
        }
    </style>
    <script>
        function showAlertAndRedirect() {
            alert("You have successfully registered. You can now log in to your account.");
            setTimeout(function () {
                window.location.href = 'login.php';
            }, 2000);
        }
    </script>
</head>
<body>

<div class="container-custom">
    <div class="left-section">
        <img src="dog.jpeg" alt="dog">
    </div>
    <div class="right-section">
        <h3 class="mb-4 text-center fw-bold">CREATE ACCOUNT</h3>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach ($errors as $e): ?>
                        <li><?php echo htmlspecialchars($e); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php elseif ($success): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
            <script>showAlertAndRedirect();</script>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="row mb-3">
                <div class="col">
                    <input type="text" name="username" placeholder="Username" class="form-control" value="<?php echo htmlspecialchars($username); ?>" required>
                </div>
            </div>
            <div class="mb-3">
                <input type="password" name="password" placeholder="Password" class="form-control" required>
            </div>
            <div class="mb-3">
                <input type="password" name="confirm_password" placeholder="Confirm Password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-custom mb-3">CREATE ACCOUNT</button>
            <div class="text-center">
                Already have an account? <a href="login.php" class="text-decoration-none">Login</a>
            </div>
        </form>
    </div>
</div>

</body>
</html>
