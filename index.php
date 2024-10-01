<?php include 'header.php'; ?>

<h1 class="mb-4">Welcome to the Vulnerability Demonstration App</h1>
<p class="lead">This application demonstrates common security vulnerabilities. Click on the links below to explore each vulnerability and see examples of how they can be exploited and mitigated.</p>

<h2 class="mt-4">Vulnerabilities</h2>
<ul class="list-group">
    <li class="list-group-item">
        <a href="nosql_injection.php">NoSQL Injection Vulnerability</a>
        <a href="nosql_injection_fixed.php" class="btn btn-sm btn-outline-success float-end">View Fixed Version</a>
    </li>
    <li class="list-group-item">
        <a href="dom_xss.php">DOM-based XSS Vulnerability</a>
        <a href="dom_xss_fixed.php" class="btn btn-sm btn-outline-success float-end">View Fixed Version</a>
    </li>
</ul>

<div class="alert alert-warning mt-4" role="alert">
    <strong>Please note:</strong> The vulnerable pages are intentionally insecure for demonstration purposes. Do not use them in a production environment. The fixed versions demonstrate proper security measures.
</div>

<?php include 'footer.php'; ?>
