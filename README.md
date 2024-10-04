# NoSQL Injection and DOM-Based XSS Vulnerability Demo

This project demonstrates a **NoSQL injection** vulnerability using **MongoDB** and **PHP**, as well as **DOM-Based XSS** vulnerabilities and their mitigations. It illustrates how insecure code can be exploited by attackers and provides examples of how to secure against these types of vulnerabilities using proper input sanitization and best practices.

## Table of Contents

- [Introduction](#introduction)
- [Requirements](#requirements)
- [Setup and Installation](#setup-and-installation)
- [Usage](#usage)
- [Vulnerabilities Demonstrated](#vulnerabilities-demonstrated)
  - [NoSQL Injection](#nosql-injection)
  - [DOM-Based XSS](#dom-based-xss)
- [Mitigation Techniques](#mitigation-techniques)

## Introduction

NoSQL Injection is a type of vulnerability that allows attackers to manipulate queries in non-relational databases, like MongoDB, by injecting malicious inputs. DOM-Based XSS allows attackers to manipulate the client-side JavaScript to perform unintended actions.

This project includes:
1. **Vulnerable Implementation**: A simple login feature vulnerable to NoSQL Injection and a page vulnerable to DOM-Based XSS.
2. **Secure Implementation**: Examples showing on how you can secure such features using best practices.

## Requirements

Ensure you have the following installed in your environment:

- [Composer](https://getcomposer.org/)
- [PHP MongoDB Extension](https://pecl.php.net/package/mongodb)
- **PHP >= 8.2.x**
- **MongoDB >= 4.0** (Downgraded to demonstrate vulnerabilities)
- **MongoDB Compass** (Optional, for GUI access)

## Setup and Installation

Follow these steps to set up the project in your local environment:

1. **Clone the Repository**:
   ```bash
   git clone https://github.com/saleemo97/CCSEP.git
   ```

2. **Navigate to Project Directory**:
   ```bash
   cd CCSEP
   ```

3. **Install Dependencies via Composer**:
   - Ensure Composer is installed and run:
   ```bash
   composer install
   ```

4. **Install MongoDB PHP Extension**:
   - Install the MongoDB driver for PHP. You can do this via **PECL**:<br>


   -- **Windows**:
   Go to the following link to download the driver and make sure to download the Thread Safe (x64) version of the PHP Driver
   
   ```bash
   https://pecl.php.net/package/mongodb/1.17.1/windows
   ```

   -- **Linux**:
   ```bash
   pecl install mongodb
   ```

   - Add the extension to your `php.ini` file:
   ```ini
   extension=php_mongodb
   ```

5. **Set Up MongoDB**:
   - Start your MongoDB server. You can use **MongoDB Compass** to create a database named `vulnerable_app` with a collection `users`.

6. **Run the PHP Server**:
   - Start a PHP server from the project directory:
   ```bash
   php -S localhost:8000
   ```
   - Open the application in your browser at `http://localhost:8000/`.

## Usage

Once the application is set up and running, you can test the NoSQL injection vulnerability and the DOM-Based XSS using the following steps:

### Vulnerable Login (NoSQL Injection)

1. Navigate to `/nosql_injection.php` (the login page).
2. Enter the following credentials:
   - **Username**: `sam`
   - **Password**: `{"$ne": ""}`
3. If the vulnerability exists, this payload will bypass the password check, allowing unauthorized access.

### Vulnerable DOM-Based XSS

1. Navigate to `/dom_xss.php`.
2. In the input field, enter the following payload:
   ```html
   <img src=x onerror="alert('XSS!')">
   ```
3. If vulnerable, the script will execute an alert on the page, demonstrating a DOM-Based XSS attack.

## Vulnerabilities Demonstrated

### NoSQL Injection

- **Description**: User inputs are directly used in the MongoDB query, allowing attackers to inject query operators.
- **Example Attack**: Inputting `{"$ne": ""}` as a password allows bypassing authentication checks.
  
- **Crafting the Script**: 
  The script is designed to demonstrate the NoSQL injection vulnerability by directly incorporating user input into a MongoDB query without proper validation or sanitization. Here’s how it works:
  
  1. **User Input Handling**: The application accepts user input for authentication (e.g., username and password) and directly uses this input in the MongoDB query.
  
  2. **Query Construction**: The query is constructed as follows:
     ```javascript
     const user = await db.collection('users').findOne({ username: inputUsername, password: inputPassword });
     ```
  
  3. **Injection Point**: When an attacker inputs `{"$ne": ""}` as the password, the query effectively becomes:
     ```javascript
     const user = await db.collection('users').findOne({ username: 'attackerUsername', password: { "$ne": "" } });
     ```
  
  4. **Bypassing Authentication**: This query checks if the password is not equal to an empty string, which is always true for any existing user, thus allowing the attacker to bypass authentication checks.

  5. **Mitigation**: To prevent such vulnerabilities, always validate and sanitize user inputs before using them in database queries. Consider using parameterized queries or ORM libraries that handle input safely.

### DOM-Based XSS

- **Description**: User inputs are directly used to manipulate the DOM without sanitization, allowing script injection.
- **Example Attack**: Entering `<img src=x onerror="alert('XSS!')">` causes JavaScript code to execute in the victim's browser.

- **Crafting the Script**: 
  The script is designed to demonstrate the DOM-based XSS vulnerability by directly inserting user input into the DOM without proper validation or sanitization. Here’s how it works:
  
  1. **User Input Handling**: The application accepts user input through an input field and uses this input to update the content of the webpage dynamically.
  
  2. **DOM Manipulation**: The user input is inserted into the DOM using methods like `innerHTML`, which allows HTML and JavaScript code to be executed. For example:
     ```javascript
     document.getElementById('output').innerHTML = userInput;
     ```
  
  3. **Injection Point**: When an attacker inputs `<img src=x onerror="alert('XSS!')">`, the browser attempts to load the image. Since the source is invalid, the `onerror` event is triggered, executing the JavaScript code:
     ```javascript
     alert('XSS!');
     ```
  
  4. **Exploiting the Vulnerability**: This allows the attacker to execute arbitrary JavaScript in the context of the victim's browser, potentially leading to data theft, session hijacking, or other malicious actions.

  5. **Mitigation**: To prevent such vulnerabilities, always sanitize and validate user inputs before inserting them into the DOM. Use safer methods like `textContent` instead of `innerHTML` to avoid executing any embedded scripts.

## Mitigation Techniques

### Preventing NoSQL Injection

- **Sanitize Input**: Ensure user inputs are strictly validated and typed. In the provided example, the username is sanitized using `filter_input()` with `FILTER_SANITIZE_STRING` to remove any unwanted characters.

    ```php
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    ```

- **Use JSON Decoding Safely**: Allow JSON-like inputs only when necessary, and sanitize them before using them in queries. The example does not directly use JSON, but it emphasizes the importance of sanitizing inputs.

- **Parameterized Queries**: Use parameterized queries or query-building libraries that enforce input types. While the example uses a direct query, it is crucial to implement libraries that can help prevent injection attacks in a real-world scenario.

- **Password Handling**: Note that while the example matches the registration password directly, it is essential to use secure password hashing (e.g., bcrypt) in production applications to protect user credentials.

    ```php
    // Example of secure password hashing (not in the provided code)
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    ```

### Preventing DOM-Based XSS

- **Escape User Input**: Use functions like `textContent` instead of `innerHTML` to ensure input is not interpreted as HTML. In the provided example, `textContent` is used to safely display user input, preventing script execution.

    ```javascript
    document.getElementById('output').textContent = sanitizedInput;
    ```

- **Sanitize Input**: The example utilizes **DOMPurify** to sanitize user input before inserting it into the DOM. This ensures that any potentially harmful scripts are removed.

    ```javascript
    var sanitizedInput = DOMPurify.sanitize(userInput);
    ```

- **Content Security Policy (CSP)**: Implement CSP headers to restrict the execution of JavaScript code. While not shown in the example, adding CSP headers to your web application can significantly reduce the risk of XSS attacks by controlling which scripts can run.

    ```http
    Content-Security-Policy: default-src 'self'; script-src 'self';
    ```

- **User Input Handling**: Always validate and sanitize user inputs before using them in any DOM manipulation or database queries to prevent vulnerabilities.

## Additional Notes

- **MongoDB Version**: The project demonstrates NoSQL injection more effectively with older MongoDB versions (like 4.x) due to fewer built-in protections.
