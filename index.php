<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("location:login.php");
    exit();
}

$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h2>Welcome, <?php echo htmlspecialchars($username); ?>!</h2>
        <a href="logout.php" class="btn btn-danger mt-3">Logout</a>
        <a href="admin_dashboard.php" class="btn btn-primary mt-3">Admin Dashboard</a>
        <a href="user_dashboard.php" class="btn btn-primary mt-3">User Dashboard</a>
    
    </div>
</body>
</html>
