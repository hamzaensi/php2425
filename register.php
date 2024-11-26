<?php
require 'db.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $role = isset($_POST['role']) ? $_POST['role'] : 'user'; // Default role is 'user'

    // Check for duplicate email or username
    $sqlCheck = "SELECT * FROM users WHERE email = :email OR username = :username";
    $stmtCheck = $conn->prepare($sqlCheck);
    $stmtCheck->execute([':email' => $email, ':username' => $username]);

    if ($stmtCheck->rowCount() > 0) {
        $message = 'Email or Username already exists.';
    } else {
        // Insert new user into the database
        $sql = "INSERT INTO users (username, email, password, role) VALUES (:username, :email, :password, :role)";
        $stmt = $conn->prepare($sql);
        if ($stmt->execute([':username' => $username, ':email' => $email, ':password' => $password, ':role' => $role])) {
            $message = 'User successfully registered!';
        } else {
            $message = 'Failed to register user.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h2 class="mb-4">Register</h2>
        <?php if ($message): ?>
            <div class="alert <?php echo ($message === 'User successfully registered!') ? 'alert-success' : 'alert-danger'; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
        <form method="POST" action="register.php">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" name="username" id="username" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>
           
            <button type="submit" class="btn btn-primary">Register</button>
            <a href="login.php" class="btn btn-primary">Login</a>
        </form>
    </div>
</body>
</html>
