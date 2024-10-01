<?php include 'header.php'; ?>

<h1 class="mb-4">NoSQL Injection Example</h1>

<?php
require 'mongo_conn.php';

$collection = $db->users;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Taking user input directly from POST request
    $username = $_POST['username'];

    // Decode password input as JSON if possible; if not, keep it as a string
    $password = json_decode($_POST['password'], true);
    if (is_null($password)) {
        $password = $_POST['password']; // If JSON decode fails, use the original string
    }

    // Vulnerable query - directly using user input without sanitization or validation
    $query = [
        'username' => $username,
        'password' => $password
    ];

    // Debugging: Show what the query looks like
    echo '<pre>';
    echo "Username input: " . htmlspecialchars($username) . "\n";
    echo "Password input: " . htmlspecialchars(json_encode($password)) . "\n";
    echo "Query: " . json_encode($query, JSON_PRETTY_PRINT) . "\n";
    echo '</pre>';

    // Executing the vulnerable query
    $result = $collection->findOne($query);

    if ($result) {
        // Successful login message
        echo '<div class="alert alert-success" role="alert">Welcome, ' . htmlspecialchars($result['username']) . '!</div>';
    } else {
        // Failed login message
        echo '<div class="alert alert-danger" role="alert">Invalid Username or Password!</div>';
    }
}
?>

<div class="row">
    <div class="col-md-6">
        <h2>Login</h2>
        <form method="POST" class="mb-3">
            <div class="mb-3">
                <label for="username" class="form-label">Username:</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="text" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
            <a href="register.php" class="btn btn-secondary ms-2">Register</a>
        </form>
    </div>
</div>

<div class="alert alert-warning mt-4" role="alert">
    <strong>Warning:</strong> This form is intentionally vulnerable to NoSQL injection attacks. 
    You can try injection payloads to see the vulnerability in action, e.g.:
    <ul>
        <li>Username: <code>sam</code></li>
        <li>Password: <code>{"$ne": ""}</code></li>
    </ul>
    <p>This would allow bypassing the password check as the query will match any non-empty password. Do not use this in a production environment.</p>
</div>

<?php include 'footer.php'; ?>
