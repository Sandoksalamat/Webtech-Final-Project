<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

require_once("db.php");


$records_per_page = isset($_GET['limit']) && is_numeric($_GET['limit']) ? (int)$_GET['limit'] : 10;

$current_page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($current_page - 1) * $records_per_page;


$sort_by = isset($_GET['sort_by']) ? $_GET['sort_by'] : 'student_id'; 
$sort_order = isset($_GET['sort_order']) ? $_GET['sort_order'] : 'DESC'; 


$allowed_sort_by = ['student_id', 'full_name', 'age'];
if (!in_array($sort_by, $allowed_sort_by)) {
    $sort_by = 'student_id';
}

$allowed_sort_order = ['ASC', 'DESC'];
if (!in_array(strtoupper($sort_order), $allowed_sort_order)) {
    $sort_order = 'DESC';
}


if ($sort_by === 'full_name') {
    $order_clause = "full_name ASC";
} elseif ($sort_by === 'age') {
    $order_clause = "age DESC";
} else {
    $order_clause = "$sort_by $sort_order";
}


$total_records_query = mysqli_query($conn, "SELECT COUNT(*) AS total FROM students");
$total_records_result = mysqli_fetch_assoc($total_records_query);
$total_records = $total_records_result['total'];
$total_pages = ceil($total_records / $records_per_page);


$query = "SELECT * FROM students ORDER BY $order_clause LIMIT $records_per_page OFFSET $offset";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Error fetching data: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Homepage</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
    <style>
        body { background-color: #f8f9fa; padding: 20px; }
        .header-container { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .table-container { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); }
        .logout-btn-container { text-align: right; }
        .sortable-header { cursor: pointer; }
        .sortable-header:hover { text-decoration: underline; }
    </style>
</head>

<body>
<div class="container">
    <div class="header-container">
        <h2>Students List</h2>
        <div class="logout-btn-container">
            <a href="#" class="btn btn-warning" onclick="confirmLogout()">Logout</a>
        </div>
    </div>

    <div class="table-container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="d-flex gap-2 align-items-center">
                <input type="text" class="form-control" placeholder="Search by name or roll" aria-label="Search" style="max-width: 200px;">
                <form method="GET" class="d-flex align-items-center">
                    <label for="limit" class="me-2">Show:</label>
                    <select name="limit" id="limit" class="form-select" onchange="this.form.submit()">
                        <option value="5" <?php if ($records_per_page == 5) echo 'selected'; ?>>5</option>
                        <option value="10" <?php if ($records_per_page == 10) echo 'selected'; ?>>10</option>
                        <option value="20" <?php if ($records_per_page == 20) echo 'selected'; ?>>20</option>
                        <option value="50" <?php if ($records_per_page == 50) echo 'selected'; ?>>50</option>
                    </select>
                    <input type="hidden" name="page" value="1"> <!-- Always reset to page 1 on limit change -->
                    <input type="hidden" name="sort_by" value="<?php echo htmlspecialchars($sort_by); ?>">
                    <input type="hidden" name="sort_order" value="<?php echo htmlspecialchars($sort_order); ?>">
                </form>
            </div>
            <div>
                <a href="add.php" class="btn btn-primary">+ Add Students</a>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped table-dark-mode">
                <thead class="table-light table-dark-mode">
                    <tr>
                        <th class="sortable-header" onclick="window.location.href='?page=<?php echo $current_page; ?>&limit=<?php echo $records_per_page; ?>&sort_by=student_id&sort_order=<?php echo ($sort_by == 'student_id' && $sort_order == 'ASC') ? 'DESC' : 'ASC'; ?>'">
                            Student ID
                            <?php if ($sort_by == 'student_id') { echo ($sort_order == 'ASC') ? ' &#9650;' : ' &#9660;'; } ?>
                        </th>
                        <th class="sortable-header" onclick="window.location.href='?page=<?php echo $current_page; ?>&limit=<?php echo $records_per_page; ?>&sort_by=full_name&sort_order=ASC'">
                            Name
                            <?php if ($sort_by == 'full_name') { echo ' &#9650;'; } ?>
                        </th>
                        <th class="sortable-header" onclick="window.location.href='?page=<?php echo $current_page; ?>&limit=<?php echo $records_per_page; ?>&sort_by=age&sort_order=DESC'">
                            Age
                            <?php if ($sort_by == 'age') { echo ' &#9660;'; } ?>
                        </th>
                        <th>Email</th>
                        <th>Action</th> 
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['student_id']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['full_name']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['age']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                            echo "<td>
                                    <a href=\"viewAccount.php?student_id=" . htmlspecialchars($row['student_id']) . "\" class=\"btn btn-info btn-sm\">View</a>
                                    <a href=\"edit.php?student_id=" . htmlspecialchars($row['student_id']) . "\" class=\"btn btn-warning btn-sm\">Edit</a>
                                    <a href=\"delete.php?student_id=" . htmlspecialchars($row['student_id']) . "\" class=\"btn btn-danger btn-sm\" onClick=\"return confirm('Are you sure you want to delete this record?')\">Delete</a>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5' class='text-center'>No records found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center mt-4">
                <li class="page-item <?php if($current_page <= 1){ echo 'disabled'; } ?>">
                    <a class="page-link" href="<?php if($current_page <= 1) { echo '#'; } else { echo "?page=".($current_page - 1)."&limit=".$records_per_page."&sort_by=".htmlspecialchars($sort_by)."&sort_order=".htmlspecialchars($sort_order); } ?>">Previous</a>
                </li>
                <?php for($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="page-item <?php if($i == $current_page){ echo 'active'; } ?>">
                        <a class="page-link" href="?page=<?php echo $i; ?>&limit=<?php echo $records_per_page; ?>&sort_by=<?php echo htmlspecialchars($sort_by); ?>&sort_order=<?php echo htmlspecialchars($sort_order); ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>
                <li class="page-item <?php if($current_page >= $total_pages){ echo 'disabled'; } ?>">
                    <a class="page-link" href="<?php if($current_page >= $total_pages){ echo '#'; } else { echo "?page=".($current_page + 1)."&limit=".$records_per_page."&sort_by=".htmlspecialchars($sort_by)."&sort_order=".htmlspecialchars($sort_order); } ?>">Next</a>
                </li>
            </ul>
        </nav>
    </div>
</div>

<script>
function confirmLogout() {
    if (confirm("You will now be logged out.")) {
        window.location.href = "logout.php";
    }
}
</script>
</body>
</html>
