<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Manual require - no Composer needed
require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

if ((isset($_POST['inquiry'])) || (isset($_POST['quote']))) {
    $data = (isset($_POST['inquiry'])) ? $_POST['inquiry'] : $_POST['quote'];
    $to = "owenhartman468@gmail.com";
    $subject = (isset($_POST['inquiry'])) ? "Inquiry - Form Alert" : "Inquiry - Form";

    $inputs = '';
    foreach ($data as $key => $value) {
        if ($key == 'lead_url') {
            $key = 'Website';
            $value = str_replace('"', '', $value);
        }
        $inputs .= "<tr>
            <td style='padding: 8px; border: 1px solid #ddd; font-weight: bold; background-color: #f9f9f9;'>" . htmlspecialchars($key) . "</td>
            <td style='padding: 8px; border: 1px solid #ddd;'>" . htmlspecialchars($value) . "</td>
        </tr>";
    }

    $message = "
    <html><head><title>Form Submission</title></head>
    <body>
    <div style='font-family: Arial, sans-serif; font-size: 14px; color: #333; margin: 20px;'>
        <table style='width: 100%; border-collapse: collapse;'>
            " . $inputs . "
        </table>
    </div>
    </body></html>";

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'owenhartman468@gmail.com';
        $mail->Password   = 'vrsz tzni cafo dkbq';     // App Password daalo
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->setFrom('owenhartman468@gmail.com', 'Palm Beach Executive Limo');
        $mail->addAddress('owenhartman468@gmail.com');     
        // $mail->addAddress('html.demo400@gmail.com');       

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $message;

        $mail->send();

        echo json_encode(['status' => 1, 'message' => 'Email sent successfully']);
    } catch (Exception $e) {
        echo json_encode(['status' => 0, 'message' => 'Failed to send email: ' . $mail->ErrorInfo]);
    }
}
?>