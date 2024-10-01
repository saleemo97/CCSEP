<?php include 'header.php'; ?>

<h1 class="mb-4">Secure DOM XSS Example</h1>
<div class="mb-3">
    <label for="userInput" class="form-label">Enter a Message:</label>
    <input id="userInput" type="text" class="form-control" onkeyup="showMessage()">
</div>
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Output:</h5>
        <p id="output" class="card-text"></p>
    </div>
</div>

<script>
    function showMessage() {
        var userInput = document.getElementById('userInput').value;
        // Sanitize the input to prevent XSS
        var sanitizedInput = DOMPurify.sanitize(userInput);
        document.getElementById('output').textContent = sanitizedInput;
    }
</script>

<div class="alert alert-info mt-4" role="alert">
    <strong>Note:</strong> This version is protected against DOM-based XSS attacks using DOMPurify for input sanitization.
</div>

<?php include 'footer.php'; ?>