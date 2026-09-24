# DriveHub

DriveHub is a PHP-based used car marketplace and booking application. The project allows users to browse car listings, view car details, create accounts, book vehicles, and manage profile information.

## Features

- Browse available car listings
- Search and filter vehicle inventory
- View detailed information for each vehicle
- User registration and login system
- Booking and transaction flow
- Admin management for cars and user-related operations
- Responsive Bootstrap-based UI

## Tech Stack

- PHP
- MySQL/MariaDB
- Apache / XAMPP / local PHP server
- Bootstrap 5

## Project Structure

```text
DriveHub/
├── about.php
├── add_car.php
├── admin_dashboard.php
├── book.php
├── booking_history.php
├── buy.php
├── category.php
├── config.php
├── contact.php
├── css/
├── images/
├── includes/
├── index.php
├── js/
├── login.php
├── login_process.php
├── logout.php
├── manage_cars.php
├── profile.php
├── register.php
├── register_process.php
├── search.php
├── users.php
├── README.md
├── .gitignore
├── .gitattributes
└── LICENSE
```

## Prerequisites

- PHP 7.4+ or newer
- MySQL 5.7+ or MariaDB
- Apache or XAMPP/WAMP/MAMP

## Setup Instructions

1. Clone this repository.
2. Place the project folder in your local web server root, such as `htdocs` for XAMPP.
3. Create a MySQL database named `DriveHub`.
4. Update the database credentials in `config.php` if needed.
5. Start Apache and MySQL.
6. Open the project in your browser, for example:

```text
http://localhost/DriveHub/
```

## Database Configuration

The application expects a MySQL database connection configured in `config.php`:

```php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "DriveHub";
```

If your local environment uses different credentials, update them before running the app.

## Notes

This repo is intended as a local project for learning and portfolio use. If you deploy it to production, make sure to:

- use environment-based configuration
- secure database credentials
- validate and sanitize all user input
- avoid exposing direct database errors in the browser

## License

This project is licensed under the MIT License. See [LICENSE](LICENSE) for details.
