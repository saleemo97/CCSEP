<?php include 'header.php'; ?>

<h1 class="mb-4">Secure Register</h1>

<?php
require 'mongo_conn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = $_POST['password'];
    $collection = $db->users;

    // Check if username already exists
    $existing_user = $collection->findOne(['username' => $username]);
    if ($existing_user) {
        echo '<div class="alert alert-danger" role="alert">Username already exists!</div>';
    } else {
        // Secure registration (protected against NoSQL injection)
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $result = $collection->insertOne([
            'username' => $username,
            'password' => $hashed_password
        ]);

        if ($result->getInsertedCount() > 0) {
            echo '<div class="alert alert-success" role="alert">Registration successful! You can now <a href="nosql_injection_fixed.php">login</a>.</div>';
        } else {
            echo '<div class="alert alert-danger" role="alert">Registration failed!</div>';
        }
    }
}
?>

<div class="row">
    <div class="col-md-6">
        <form method="POST" class="mb-3">
            <div class="mb-3">
                <label for="username" class="form-label">Username:</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-success">Register</button>
            <a href="nosql_injection_fixed.php" class="btn btn-secondary ms-2">Back to Login</a>
        </form>
    </div>
</div>

<div class="alert alert-info mt-4" role="alert">
    <strong>Note:</strong> This form is protected against NoSQL injection attacks and uses secure password hashing.
</div>

<?php include 'footer.php'; ?>