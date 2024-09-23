<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DOM-based XSS Demo</title>
</head>
<body>
    <h1>Welcome</h1>

    <form>
        <label for="name">Enter your name:</label>
        <input type="text" id="name" name="name">
        <button type="button" onclick="greetUser()">Submit</button>
    </form>

    <p id="greeting"></p>

    <script>
        function greetUser() {
            var userInput = document.getElementById('name').value;
            console.log("User input:", userInput); // Log input
            // Injecting directly into the DOM without escaping
            document.getElementById('greeting').innerHTML = userInput; // Vulnerable point
        }
    </script>
</body>
</html>
