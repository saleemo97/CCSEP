<?php include 'header.php'; ?>

<h1 class="mb-4">Register</h1>

<?php
require 'mongo_conn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $collection = $db->users;

    // Registration (vulnerable to NoSQL injection)
    $result = $collection->insertOne([
        'username' => $username,
        'password' => $password // Note: Storing password in plain text is not secure
    ]);

    if ($result->getInsertedCount() > 0) {
        echo '<div class="alert alert-success" role="alert">Registration successful! You can now <a href="nosql_injection.php">login</a>.</div>';
    } else {
        echo '<div class="alert alert-danger" role="alert">Registration failed!</div>';
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
            <a href="nosql_injection.php" class="btn btn-secondary ms-2">Back to Login</a>
        </form>
    </div>
</div>

<p class="mt-3">Already have an account? <a href="nosql_injection.php">Login here</a>.</p>

<?php include 'footer.php'; ?>