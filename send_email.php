<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PhpOffice\PhpSpreadsheet\IOFactory;

require 'vendor/autoload.php';

set_time_limit(0); // Remove the time limit for script execution

function readContactsFromExcel($filePath) {
    $spreadsheet = IOFactory::load($filePath);
    $sheet = $spreadsheet->getActiveSheet();
    $contacts = [];

    foreach ($sheet->getRowIterator() as $rowIndex => $row) {
        if ($rowIndex === 1) {
            continue; // Skip header row
        }

        $cellIterator = $row->getCellIterator();
        $cellIterator->setIterateOnlyExistingCells(false);
        $cells = [];
        foreach ($cellIterator as $cell) {
            $cells[] = $cell->getValue();
        }

        $contacts[] = [
            'date' => $cells[0],
            'email' => $cells[1],
            'name' => $cells[2],
            'gender' => $cells[3],
            'mobile' => $cells[4],
            'internship_track' => $cells[5],
            'qualification' => $cells[6],
            'college' => $cells[7],
            'passing_year' => $cells[8],
            'country' => $cells[9],
            'social_links' => $cells[10],
            'questions' => $cells[11],
            'condition' => $cells[12],
            'cin' => $cells[13],
            'doc_id' => $cells[14],
            'doc_url' => $cells[15],
            'merged_doc_url' => $cells[16],
            'merge_status' => $cells[17],
        ];
    }

    return $contacts;
}

function sendEmail($contact, $smtpConfig) {
    $mail = new PHPMailer(true);

    try {
        $template = file_get_contents('./sendMail/template/Completion_Form.html');

        $placeholders = [
            '{{name}}' => $contact['name'],
            '{{internship_track}}' => $contact['internship_track'],
            '{{qualification}}' => $contact['qualification'],
            '{{college}}' => $contact['college'],
            '{{passing_year}}' => $contact['passing_year'],
            '{{country}}' => $contact['country'],
            '{{social_links}}' => $contact['social_links'],
            '{{questions}}' => $contact['questions'],
        ];

        foreach ($placeholders as $placeholder => $value) {
            $template = str_replace($placeholder, $value, $template);
        }

        $mail->isSMTP();
        $mail->Host       = $smtpConfig['host'];
        $mail->SMTPAuth   = true;
        $mail->Username   = $smtpConfig['username'];
        $mail->Password   = $smtpConfig['password'];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = $smtpConfig['port'];

        $mail->setFrom('help@byteuprise.com', 'ByteUprise');
        $mail->addAddress($contact['email'], $contact['name']);

        $mail->isHTML(true);
        $mail->Subject = '⚠️⚠️ Reminder: Internship Completion Form is Open ByteUprise';
        $mail->Body    = $template;

        $mail->send();
        return "Message sent to {$contact['name']} ({$contact['email']})";
    } catch (Exception $e) {
        return "Message could not be sent to {$contact['name']} ({$contact['email']}). Mailer Error: {$mail->ErrorInfo}";
    }
}

function saveToLog($logFilePath, $contact, $sent = true) {
    $logDirectory = dirname($logFilePath);
    if (!file_exists($logDirectory)) {
        mkdir($logDirectory, 0755, true);
    }
    $logFile = ($sent ? 'sent_' : 'unsent_') . date('Ymd') . '.xlsx';

    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Set header
    $sheet->setCellValue('A1', 'Date');
    $sheet->setCellValue('B1', 'Email');
    $sheet->setCellValue('C1', 'Name');
    $sheet->setCellValue('D1', 'Gender');
    $sheet->setCellValue('E1', 'Mobile');
    $sheet->setCellValue('F1', 'Internship Track');
    $sheet->setCellValue('G1', 'Qualification');
    $sheet->setCellValue('H1', 'College');
    $sheet->setCellValue('I1', 'Passing Year');
    $sheet->setCellValue('J1', 'Country');
    $sheet->setCellValue('K1', 'Social Links');
    $sheet->setCellValue('L1', 'Questions');
    $sheet->setCellValue('M1', 'Condition');
    $sheet->setCellValue('N1', 'CIN');
    $sheet->setCellValue('O1', 'Doc ID');
    $sheet->setCellValue('P1', 'Doc URL');
    $sheet->setCellValue('Q1', 'Merged Doc URL');
    $sheet->setCellValue('R1', 'Merge Status');

    // Add data
    $rowData = [
        $contact['date'],
        $contact['email'],
        $contact['name'],
        $contact['gender'],
        $contact['mobile'],
        $contact['internship_track'],
        $contact['qualification'],
        $contact['college'],
        $contact['passing_year'],
        $contact['country'],
        $contact['social_links'],
        $contact['questions'],
        $contact['condition'],
        $contact['cin'],
        $contact['doc_id'],
        $contact['doc_url'],
        $contact['merged_doc_url'],
        $contact['merge_status'],
    ];

    $sheet->fromArray([$rowData], NULL, 'A2');

    $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
    $writer->save($logDirectory . '/' . $logFile);
}

// Define SMTP configurations
$smtpConfigs = [
    'smtp1' => [
        'host' => 'mail.byteuprise.com',
        'username' => 'info@byteuprise.com',
        'password' => 'Pratik@8080',
        'port' => 587,
    ],
    'smtp2' => [
        'host' => 'mail.byteuprise.com',
        'username' => 'help@byteuprise.com',
        'password' => 'Pratik@8080',
        'port' => 587,
    ],
];

$contacts = [];
$results = [];
$selectedSmtp = 'smtp1'; // Default SMTP

$uploadFileDir = './sendMail/uploads/';
$logFileDir = './sendMail/sentmail/';
if (!file_exists($uploadFileDir)) {
    mkdir($uploadFileDir, 0755, true);
}
if (!file_exists($logFileDir)) {
    mkdir($logFileDir, 0755, true);
}

$uploadedFiles = glob($uploadFileDir . '*.xlsx'); // Get list of previously uploaded files

if (isset($_POST['upload'])) {
    $fileTmpPath = $_FILES['file']['tmp_name'];
    $fileName = $_FILES['file']['name'];
    $destPath = $uploadFileDir . $fileName;

    if (move_uploaded_file($fileTmpPath, $destPath)) {
        $contacts = readContactsFromExcel($destPath);
    } else {
        echo "There was an error uploading the file, please try again!";
    }
}

if (isset($_POST['use_file'])) {
    $selectedFile = $_POST['selected_file'];
    $contacts = readContactsFromExcel($selectedFile);
}

if (isset($_POST['send'])) {
    // Decode contacts as associative arrays
    $contacts = array_map(function($contact) {
        return json_decode($contact, true);
    }, $_POST['contacts']);
    
    $delay = isset($_POST['delay']) ? intval($_POST['delay']) : 2;

    foreach ($contacts as $contact) {
        $result = sendEmail($contact, $smtpConfigs[$selectedSmtp]);
        $results[] = ['name' => $contact['name'], 'email' => $contact['email'], 'result' => $result];

        if (strpos($result, 'Message sent') !== false) {
            saveToLog($logFileDir, $contact, true);
        } else {
            saveToLog($logFileDir, $contact, false);
        }

        sleep($delay);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Upload and Send Emails</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .error {
            color: red;
        }
        .success {
            color: green;
        }
        .button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            margin: 10px 2px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h1>Upload Contact List</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="file" name="file" accept=".xlsx" required>
        <button type="submit" name="upload" class="button">Upload</button>
    </form>

    <h2>Or Select Previously Uploaded File</h2>
    <form action="" method="post">
        <select name="selected_file">
            <?php foreach ($uploadedFiles as $uploadedFile): ?>
                <option value="<?php echo $uploadedFile; ?>"><?php echo basename($uploadedFile); ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit" name="use_file" class="button">Use Selected File</button>
    </form>

    <?php
    if (isset($_POST['use_file'])) {
        $selectedFile = $_POST['selected_file'];
        $contacts = readContactsFromExcel($selectedFile);
    }
    ?>

    <?php if (!empty($contacts)): ?>
        <h2>Contact List</h2>
        <form action="" method="post">
            <label for="delay">Time Delay (in seconds):</label>
            <select name="delay" id="delay">
                <option value="2">2 seconds</option>
                <option value="5">5 seconds</option>
                <option value="10">10 seconds</option>
                <option value="15">15 seconds</option>
            </select>
            <button type="submit" name="send" class="button">Send Emails</button>

            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($contacts as $contact): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($contact['name']); ?></td>
                            <td><?php echo htmlspecialchars($contact['email']); ?></td>
                        </tr>
                        <input type="hidden" name="contacts[]" value='<?php echo json_encode($contact); ?>'>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </form>
    <?php endif; ?>

    <?php if (!empty($results)): ?>
        <h2>Send Results</h2>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($results as $result): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($result['name']); ?></td>
                        <td><?php echo htmlspecialchars($result['email']); ?></td>
                        <td class="<?php echo strpos($result['result'], 'Message sent') !== false ? 'success' : 'error'; ?>">
                            <?php echo htmlspecialchars($result['result']); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>
</html>
