
# MongoDB Vulnerability Demo in Laravel

This project demonstrates a NoSQL injection vulnerability and its corresponding mitigation using MongoDB with Laravel. It shows how vulnerable code can be exploited and how to prevent NoSQL injection using MongoDB best practices and parameterized queries.

## Table of Contents

- [Introduction](#introduction)
- [Requirements](#requirements)
- [Installation](#installation)
- [Usage](#usage)
- [Demonstration](#demonstration)
  - [Vulnerable Login](#vulnerable-login)
  - [Secure Login](#secure-login)

## Introduction

NoSQL Injection is a type of web application vulnerability that allows an attacker to manipulate database queries in non-relational databases, such as MongoDB. In this demo, a Laravel-based application is intentionally made vulnerable to NoSQL injection in one form and mitigated in another.

This repository contains two implementations of a simple login feature:
1. **Vulnerable to NoSQL Injection**: Uses direct MongoDB queries with user input, making it susceptible to injection attacks.
2. **Secure from NoSQL Injection**: Uses MongoDB best practices and parameterized queries to prevent such vulnerabilities.

## Requirements

Before you begin, ensure you have met the following requirements:

- [XAMPP](https://www.apachefriends.org/) (or any PHP development environment)
- [Composer](https://getcomposer.org/)
- PHP >= 8.2.x
- Laravel 10.x
- MongoDB 8.0.0 (2008R2plus SSL)

## Installation

Follow these steps to set up the project in your local environment:

1. Clone the repository:
   ```bash
   git clone https://github.com/your-username/nosql_injection_demo.git
   ```

2. Navigate to the project directory:
   ```bash
   cd ccsepAssignment
   ```

3. Install Laravel dependencies via Composer, including MongoDB support:
   ```bash
   composer install
   composer require mongodb/laravel-mongodb
   composer require laravel/ui
   php artisan ui bootstrap --auth
   npm install
   npm run dev
   ```

4. Set up the `.env` file:
   - Copy the `.env.example` file and rename it to `.env`.
   - Configure your database settings for MongoDB:
     ```env
      DB_CONNECTION=mongodb
      DB_HOST=127.0.0.1
      DB_PORT=27017
      DB_DATABASE=ccsep
      DB_USERNAME=
      DB_PASSWORD=
     ```

5. **Optional**: If MongoDB authentication is enabled, ensure you provide the correct username and password in the `.env` file.

6. Start the Laravel development server:
   ```bash
   php artisan serve
   ```

7. Open the application in your browser at `http://localhost:8000/login`.

## Usage

Once the application is set up and running, you can test the NoSQL injection vulnerability and the secure implementation using the following steps:

### Vulnerable Login

1. Navigate to the `/vulnerable-login` route.
2. Use a **vulnerable form** that directly concatenates user input into the MongoDB query.
3. Try injecting a malicious query like:
   ```
   {"$gt": ""}
   ```
   This should allow unauthorized access.

### Secure Login

1. Use the **secure form**, you can do that by navigating to `/login` route that implements MongoDB best practices and parameterized queries.
2. The same injection attempt will be thwarted, as it correctly validates and filters input.
