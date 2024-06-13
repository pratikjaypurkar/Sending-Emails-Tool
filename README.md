# Bulk Email Sender

This project is a PHP-based bulk email sender that reads contacts from an Excel file, customizes an HTML email template, and sends emails using PHPMailer. The project also logs the results of sent and unsent emails.

## Features

- Upload an Excel file with contact details.
- Customize and send HTML emails to multiple recipients.
- Log results of sent and unsent emails.
- Supports multiple SMTP configurations.

## Requirements

- PHP 7.2 or higher
- Composer
- A web server (e.g., Apache, Nginx)
- An SMTP server for sending emails

## Installation

### Step 1: Clone the Repository

```sh
git clone https://github.com/yourusername/ -BulkEmailSender.git
cd  -BulkEmailSender
```

### Step 2: Install Dependencies

Install the required PHP packages using Composer:

```sh
composer install
```

### Step 3: Set Up Directory Structure

Make sure the following directories exist within your project:

```sh
mkdir -p sendMail/uploads sendMail/template sendMail/sentmail
```

### Step 4: Upload HTML Template

Place your HTML email template in the `sendMail/template/` directory. For example, `Completion_Form.html`.

### Step 5: Configure SMTP Settings

Edit the `send_email.php` file to configure your SMTP settings. Look for the `$smtpConfigs` array and update it with your SMTP server details.

## Usage

### Upload Contacts

1. Open your web browser and navigate to the project URL (e.g., `http://localhost/BulkEmailSender`).
2. Use the upload form to upload an Excel file containing your contact details.

### Send Emails

1. After uploading the file, select the file and configure any additional options (e.g., time delay between emails).
2. Click the "Send Emails" button to start sending emails.

### Logging

Check the `sendMail/sentmail/` directory for logs of sent and unsent emails.

## Example Excel File Format

Your Excel file should have the following columns:

- `date`
- `email`
- `name`
- `gender`
- `mobile`
- `internship_track`
- `qualification`
- `college`
- `passing_year`
- `country`
- `social_links`
- `questions`
- `condition`
- `cin`
- `doc_id`
- `doc_url`
- `merged_doc_url`
- `merge_status`

## Troubles

```markdown
#   Bulk Email Sender

This project is a PHP-based bulk email sender that reads contacts from an Excel file, customizes an HTML email template, and sends emails using PHPMailer. The project also logs the results of sent and unsent emails.

## Features

- Upload an Excel file with contact details.
- Customize and send HTML emails to multiple recipients.
- Log results of sent and unsent emails.
- Supports multiple SMTP configurations.

## Requirements

- PHP 7.2 or higher
- Composer
- A web server (e.g., Apache, Nginx)
- An SMTP server for sending emails

## Installation

### Step 1: Clone the Repository

```sh
git clone https://github.com/yourusername/ -BulkEmailSender.git
cd  -BulkEmailSender
```

### Step 2: Install Dependencies

Install the required PHP packages using Composer:

```sh
composer install
```

### Step 3: Set Up Directory Structure

Make sure the following directories exist within your project:

```sh
mkdir -p sendMail/uploads sendMail/template sendMail/sentmail
```

### Step 4: Upload HTML Template

Place your HTML email template in the `sendMail/template/` directory. For example, `Completion_Form.html`.

### Step 5: Configure SMTP Settings

Edit the `send_email.php` file to configure your SMTP settings. Look for the `$smtpConfigs` array and update it with your SMTP server details.

## Usage

### Upload Contacts

1. Open your web browser and navigate to the project URL (e.g., `http://localhost/ -BulkEmailSender`).
2. Use the upload form to upload an Excel file containing your contact details.

### Send Emails

1. After uploading the file, select the file and configure any additional options (e.g., time delay between emails).
2. Click the "Send Emails" button to start sending emails.

### Logging

Check the `sendMail/sentmail/` directory for logs of sent and unsent emails.

## Example Excel File Format

Your Excel file should have the following columns:

- `date`
- `email`
- `name`
- `gender`
- `mobile`
- `internship_track`
- `qualification`
- `college`
- `passing_year`
- `country`
- `social_links`
- `questions`
- `condition`
- `cin`
- `doc_id`
- `doc_url`
- `merged_doc_url`
- `merge_status`

## Troubleshooting

### Common Errors

1. **Class "ZipArchive" not found**:
   - Ensure that the PHP `zip` extension is installed and enabled in your `php.ini` file.

2. **SMTP connection errors**:
   - Verify your SMTP server details (host, username, password, port) are correct.
   - Ensure that your server's firewall allows outbound connections to the SMTP server.

3. **Emails not sending**:
   - Check the error logs for specific error messages.
   - Ensure that your SMTP credentials are correct.
   - Make sure that the email addresses in your Excel file are valid.

### Additional Help

For more detailed information, please refer to the [PHPMailer documentation](https://github.com/PHPMailer/PHPMailer) and the [PhpSpreadsheet documentation](https://phpspreadsheet.readthedocs.io/).

## License

This project is licensed under the MIT License.
```

### Steps to Upload the Project to GitHub

1. **Initialize a Local Git Repository**:
   - Open a terminal (or Git Bash) and navigate to your project directory.
   - Run `git init` to initialize a new git repository.

2. **Add Files to Git**:
   - Run `git add .` to add all files to the repository.
   - Run `git commit -m "Initial commit"` to commit the files.

3. **Create a New Repository on GitHub**:
   - Go to GitHub and create a new repository (e.g., ` -BulkEmailSender`).

4. **Push Your Local Repository to GitHub**:
   - Follow the instructions provided by GitHub to push your local repository. It usually looks something like this:
     ```sh
     git remote add origin https://github.com/yourusername/ -BulkEmailSender.git
     git branch -M main
     git push -u origin main
     ```

### Uploading Files to GitHub

If you're unfamiliar with using Git and GitHub via the command line, you can also use GitHub Desktop or upload files directly through the GitHub website by dragging and dropping the files into the repository.

By following these steps, you'll ensure that your project is well-documented and easy for others to understand and use.
