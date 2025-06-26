<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Student</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
    <style>
        body {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f4f4f4;
        }
        .add-student-container {
            background-color: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            width: 500px;
        }
        h2 {
            text-align: center;
            color: #333333;
            margin-bottom: 30px;
            font-weight: bold;
        }
        .btn-custom {
            background-color: #FFC107;
            color: white;
            width: 100%;
            border: none;
            border-radius: 8px;
            height: 45px;
        }
        .btn-custom:hover {
            background-color: #e0a800;
        }
        label {
            font-weight: bold;
            color: #333333;
        }
        .form-control, select {
            border-radius: 8px;
            height: 45px;
        }
        .home-link {
            display: block;
            margin-bottom: 20px;
            text-align: center;
            text-decoration: none;
            color: #FFC107;
            font-weight: bold;
        }
        .home-link:hover {
            text-decoration: underline;
            color: #e0a800;
        }
    </style>
</head>
<body>

<div class="add-student-container">
    <h2>Add Student</h2>
    <a href="index.php" class="home-link">Go Back to Home</a>

    <form action="addAction.php" method="post" name="add">
        <div class="mb-3">
            <label for="student_id">Student ID</label>
            <input type="text" class="form-control" name="student_id" id="student_id" required>
        </div>

        <div class="mb-3">
            <label for="full_name">Name</label>
            <input type="text" class="form-control" name="full_name" id="full_name" required>
        </div>

        <div class="mb-3">
            <label for="age">Age</label>
            <input type="number" class="form-control" name="age" id="age" required>
        </div>

        <div class="mb-3">
            <label for="email">Email</label>
            <input type="email" class="form-control" name="email" id="email" required>
        </div>

        <div class="mb-3">
            <label for="gender">Gender</label>
            <select name="gender" class="form-select" id="gender" required>
                <option value="">Select Gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="course">Course</label>
            <input type="text" class="form-control" name="course" id="course" required>
        </div>

        <button type="submit" name="submit" class="btn btn-custom">Add Student</button>
    </form>
</div>

</body>
</html>
