
# SQL Injection Vulnerability Demo in Laravel

This project demonstrates an SQL injection vulnerability and its corresponding mitigation using Laravel. It shows how vulnerable code can be exploited and how to prevent SQL injection using parameterized queries.

## Table of Contents

- [Introduction](#introduction)
- [Requirements](#requirements)
- [Installation](#installation)
- [Usage](#usage)
- [Demonstration](#demonstration)
  - [Vulnerable Login](#vulnerable-login)
  - [Secure Login](#secure-login)
- [SQL Injection Exploit](#sql-injection-exploit)
- [Fixing the Vulnerability](#fixing-the-vulnerability)
- [Contributing](#contributing)
- [License](#license)

## Introduction

SQL Injection is a type of web application vulnerability that allows an attacker to interfere with the queries made to the database. In this demo, a Laravel-based application is intentionally made vulnerable to SQL injection in one form and mitigated in another.

This repository contains two implementations of a simple login feature:
1. **Vulnerable to SQL Injection**: Uses raw SQL queries directly with user input, making it susceptible to attacks.
2. **Secure from SQL Injection**: Uses parameterized queries (prepared statements) to prevent such vulnerabilities.

## Requirements

Before you begin, ensure you have met the following requirements:

- [XAMPP](https://www.apachefriends.org/) (or any PHP development environment)
- [Composer](https://getcomposer.org/)
- PHP >= 8.1
- MySQL (included in XAMPP)
- Laravel 10.x

## Installation

Follow these steps to set up the project in your local environment:

1. Clone the repository:
   ```bash
   git clone https://github.com/your-username/sql_injection_demo.git
   ```

2. Navigate to the project directory:
   ```bash
   cd sql_injection_demo
   ```

3. Install Laravel dependencies via Composer:
   ```bash
   composer install
   ```

4. Set up the `.env` file:
   - Copy the `.env.example` file and rename it to `.env`.
   - Configure your database settings:
     ```env
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=laravel_demo
     DB_USERNAME=root
     DB_PASSWORD=  // leave blank for default XAMPP setup
     ```

5. Run the database migrations to create the necessary tables:
   ```bash
   php artisan migrate
   ```

6. Start the Laravel development server:
   ```bash
   php artisan serve
   ```

7. Open the application in your browser at `http://localhost:8000/login`.

## Usage

Once the application is set up and running, you can test the SQL injection vulnerability and the secure implementation using the following steps:

### Vulnerable Login

1. Navigate to the `/login` route.
2. Use a **vulnerable form** that directly concatenates user input into the SQL query.
3. Try injecting a malicious query like:
   ```
   admin' OR '1'='1
   ```
   This should allow unauthorized access.

### Secure Login

1. Use the **secure form** that implements parameterized queries (prepared statements).
2. The same injection attempt will be thwarted as it correctly binds parameters and prevents SQL injection.

## SQL Injection Exploit

To demonstrate SQL injection:
- Enter the following in the **vulnerable login** form:
  ```
  admin' OR '1'='1
  ```
- The SQL query formed will bypass authentication and return a valid result, demonstrating the vulnerability.

## Fixing the Vulnerability

To prevent SQL injection, the project uses **prepared statements** in the secure login implementation. Prepared statements automatically escape special characters and safely bind user input to the query, mitigating the risk of SQL injection.

The secure query implementation:
```php
$user = DB::select("SELECT * FROM users WHERE username = ?", [$username]);
```

## Contributing

Contributions are welcome! Please fork this repository and submit a pull request with any improvements.

### Steps to Contribute

1. Fork the repository.
2. Create your feature branch (`git checkout -b feature/your-feature-name`).
3. Commit your changes (`git commit -m 'Add your message'`).
4. Push to the branch (`git push origin feature/your-feature-name`).
5. Open a pull request.

