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
   Go to the following link to download the driver and make sure to download the Thread Safe (x64) version of the PHP Driver. Then move the downloaded php_mongodb.dll file to the `ext` folder in the php installation directory. which can be found in `\php\ext` on your machine.
   
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

7. **Run the MongoDB Server**:
   - Start the MongoDB server from the command line:
   ```bash
   mongod
   ```

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

## Additional Notes

- **MongoDB Version**: The project demonstrates NoSQL injection more effectively with older MongoDB versions (like 4.x) due to fewer built-in protections.
