# Sending-Emails-Tool
send Emails using php mailer
# Bulk Email Sender with Certificates

This project allows you to send bulk emails with customized certificates using PHP and PHPMailer. It reads contact information from an Excel file, generates certificates, and sends them via email.

## Requirements

- PHP 7.2 or higher
- Composer
- XAMPP
- PHPMailer
- PhpSpreadsheet

## Setup

### Step 1: Install XAMPP

1. Download and install XAMPP from [Apache Friends](https://www.apachefriends.org/index.html).
2. Start Apache and MySQL from the XAMPP Control Panel.

### Step 2: Enable Zip Extension

1. Open `php.ini` file located in `C:\xampp\php\php.ini`.
2. Find the line `;extension=zip` and remove the `;` to uncomment it.
3. Save the file and restart Apache from the XAMPP Control Panel.

### Step 3: Install Composer

1. Download and install Composer from [getcomposer.org](https://getcomposer.org/download/).

### Step 4: Set Up the Project

1. Clone this repository or download the source code.
2. Open a terminal and navigate to the project directory.
3. Run `composer install` to install the required PHP packages.

### Step 5: Configure SMTP Settings

1. Open `send_email.php`.
2. Configure the SMTP settings with your email server details.

```php
$smtpConfigs = [
    'smtp1' => [
        'host' => 'mail.yourdomain.com',
        'username' => 'your_email@yourdomain.com',
        'password' => 'your_password',
        'port' => 587,
    ],
];
