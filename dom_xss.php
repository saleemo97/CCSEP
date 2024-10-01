<?php include 'header.php'; ?>

<h1 class="mb-4">DOM XSS Example</h1>
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
        document.getElementById('output').innerHTML = userInput; // Vulnerable line
    }
</script>

<?php include 'footer.php'; ?>
