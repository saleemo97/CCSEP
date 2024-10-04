<?php include 'header.php'; ?>

<h1 class="mb-4">DOM XSS Example</h1>
<div class="mb-3">
    <label for="userInput" class="form-label">Enter a Message (try: <strong>&lt;img src=x onerror="alert('XSS!')"&gt;</strong>):</label>
    <input id="userInput" type="text" class="form-control">
</div>
<button onclick="showMessage()" class="btn btn-primary">Submit</button>

<div class="card mt-3">
    <div class="card-body">
        <h5 class="card-title">Output:</h5>
        <div id="output" class="card-text"></div> <!-- This is where the user input is displayed -->
    </div>
</div>

<script>
    function showMessage() {
        var userInput = document.getElementById('userInput').value;
        document.getElementById('output').innerHTML = userInput; // Vulnerable line
    }
</script>

<?php include 'footer.php'; ?>
