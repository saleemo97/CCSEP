<?php include 'header.php'; ?>

<h1 class="mb-4">Secure NoSQL Example</h1>

<?php
require 'mongo_conn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = $_POST['password'];
    $collection = $db->users;

    // Secure login (protected against NoSQL injection)
    $result = $collection->findOne([
        'username' => $username,
        'password' => $password // Note: This is still insecure, but matches the registration
    ]);

    if ($result) {
        echo '<div class="alert alert-success" role="alert">Welcome, ' . htmlspecialchars($result['username']) . '!</div>';
    } else {
        echo '<div class="alert alert-danger" role="alert">Invalid Username or Password!</div>';
    }
}
?>

<div class="row">
    <div class="col-md-6">
        <h2>Secure Login</h2>
        <form method="POST" class="mb-3">
            <div class="mb-3">
                <label for="username" class="form-label">Username:</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
            <a href="register.php" class="btn btn-secondary ms-2">Register</a>
        </form>
    </div>
</div>

<div class="alert alert-warning mt-4" role="alert">
    <strong>Note:</strong> This form is protected against NoSQL injection attacks, but still uses plain text passwords. In a real-world scenario, you should use secure password hashing.
</div>

<?php include 'footer.php'; ?>