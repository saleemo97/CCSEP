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
   Go to the following link to install the driver and install the Thread Safe version of the PHP Driver
   
   ```bash
   https://pecl.php.net/package/mongodb/1.17.1/windows
   ```

   -- **Linux**:
   ```bash
   pecl install mongodb
   ```

   - Add the extension to your `php.ini` file:
   ```ini
   extension=mongodb
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

## Mitigation Techniques

### Preventing NoSQL Injection

- **Sanitize Input**: Ensure user inputs are strictly validated and typed.
- **Use JSON Decoding Safely**: Allow JSON-like inputs only when necessary, and sanitize them before using them in queries.
- **Parameterized Queries**: Use parameterized queries or query-building libraries that enforce input types.

### Preventing DOM-Based XSS

- **Escape User Input**: Use functions like `textContent` instead of `innerHTML` to ensure input is not interpreted as HTML.
- **Content Security Policy (CSP)**: Implement CSP headers to restrict the execution of JavaScript code.

## Additional Notes

- **MongoDB Version**: The project demonstrates NoSQL injection more effectively with older MongoDB versions (like 4.x) due to fewer built-in protections.
