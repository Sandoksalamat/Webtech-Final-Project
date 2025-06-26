<?php 
session_start();
    if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
    }

    require_once("db.php");

    $conn = mysqli_connect("localhost", "root", "", "bs_business_admin");

    if (isset($_GET['student_id'])) {
        $student_id = mysqli_real_escape_string($conn, $_GET['student_id']);

        $query = "SELECT * FROM students WHERE student_id = '$student_id'";
        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);

            $student_id = $row['student_id'];
            $full_name = $row['full_name'];
            $age = $row['age'];
            $gender = $row['gender'];
            $course = $row['course'];
            $email = $row['email'];
        } else {
            echo "Not Found.";
            exit;
        } 
    } else {
        echo "No Student ID Provided.";
        exit;
    }
?>

<html>
    <head>
        <title>Homepage</title>
            <link rel="stylesheet" href="style.css">
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
            <style>
                body {
                    background-color: #f0f2f5;
                    font-family: Arial, sans-serif;
                    margin: 0;
                    padding: 0;
                }

                #profile {
                    display: block;
                    margin: 50px auto 20px;
                    width: 250px;
                    height: 250px;
                    object-fit: cover;
                    border-radius: 50%;
                    border: 4px solid white;
                    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
                }

                .profile-container {
                    background-color: #343a40;
                    color: white;
                    max-width: 600px;
                    margin: 0 auto;
                    padding: 30px 20px;
                    border-radius: 15px;
                    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
                    text-align: center;
                }

                .profile-container h3 {
                    margin: 10px 0;
                    font-size: 24px;
                }

                .profile-container h5 {
                    margin: 6px 0;
                    font-weight: normal;
                    color: #ccc;
                }

                #Return {
                    position: fixed;       
                    top: 20px;           
                    left: 20px;              
                    padding: 10px 20px;
                    color: white;
                    border: none;
                    border-radius: 5px;
                    cursor: pointer;
                    font-weight: bold;
                    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
                    transition: background-color 0.3s ease;
                }

                #Return:hover {
                    background-color: #0056b3;
                }

                a {
                    text-decoration: none;
                }
</style>

    </head>

    <body>
        <a href="index.php"><button class="btn btn-secondary" id="Return">Return</button></a>
        <img src="dog.jpeg" alt="Profile Picture" id="profile">

            <div class="profile-container">
                <?php
                echo "<h5>" . htmlspecialchars($student_id) . "</h5>";
                echo "<h3>" . htmlspecialchars($full_name) . "</h3>";
                echo "<h5>" . htmlspecialchars($age) . "</h5>";
                echo "<h5>" . htmlspecialchars($gender) . "</h5>";
                echo "<h5>" . htmlspecialchars($course) . "</h5>";
                echo "<h5>" . htmlspecialchars($email) . "</h5>";
                ?>
            </div>
    </body>
</html>