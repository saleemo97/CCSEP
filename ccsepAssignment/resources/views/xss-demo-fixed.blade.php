<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fixed DOM-based XSS Demo</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dompurify/2.3.3/purify.min.js"></script>
</head>
<body>
    <h1>Welcome to the Fixed XSS Demo</h1>

    <form>
        <label for="name">Enter your name:</label>
        <input type="text" id="name" name="name">
        <button type="button" onclick="greetUser()">Submit</button>
    </form>

    <p id="greeting"></p>
    <p id="debug"></p>

    <script>
        function escapeHTML(str) {
            return str.replace(/[&<>'"]/g, 
                tag => ({
                    '&': '&amp;',
                    '<': '&lt;',
                    '>': '&gt;',
                    "'": '&#39;',
                    '"': '&quot;'
                }[tag] || tag)
            );
        }

        function greetUser() {
            var userInput = document.getElementById('name').value;
            console.log("User input:", userInput); // Log input
            
            // Use DOMPurify (allows safe HTML if needed)
            document.getElementById('greeting').innerHTML = DOMPurify.sanitize(userInput);
            
            // Debug output
            document.getElementById('debug').textContent = "Sanitized input: " + DOMPurify.sanitize(userInput);
        }
    </script>
</body>
</html>
