<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../includes/db-config.php';
require '../../../vendor/autoload.php';

session_start();

if (isset($_POST['email'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    $result = $conn->query("SELECT ID, Name FROM users WHERE Email = '$email'");

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $token = bin2hex(random_bytes(20));
        $conn->query("UPDATE users SET reset_token = '$token', reset_requested_at = NOW() WHERE ID = " . $user['ID']);
        //   echo "<pre>"; print_r($_SERVER);
        $resetLink = $_SERVER['HTTP_ORIGIN'] . "/admin/reset_passwordform.php?token=$token";


        $subject = "Password Reset Request";
        $message = "Hello {$user['Name']},<br><br>";
        $message .= "You recently requested to reset your password for your account. Click the link below to reset it.<br><br>";
        $message .= "<a href='$resetLink'>Reset Password</a><br><br>";
        // $message .= "<a href='$resetLink?response=yes'>Yes, I want to reset my password</a><br><br>";
        // $message .= "<a href='$resetLink?response=no'>No, I did not request this</a><br><br>";
        $message .= "If you did not request a password reset, please ignore this email or reply to let us know. This password reset link is valid for one use only.";

        $mail = new PHPMailer(true);

        try {

            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'safdarali.cse@gmail.com';
            $mail->Password   = 'ysgz keis ebza cgda';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            $mail->setFrom('noreply@yourdomain.com', 'No Reply');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $message;
            $mail->AltBody = strip_tags($message);

            $mail->send();
            echo json_encode(['status' => 200, 'message' => 'Password reset email sent.', 'url' => '/admin/login.php']);
            // echo json_encode(['status' => 200, 'message' => 'Password reset email sent.', 'url' => '/admin/reset_passwordform.php?token=' . $token]);
            // echo json_encode(['status' => 200, 'message' => 'Password reset email sent.', 'url' => '/admin/reset_passwordform.php']);
        } catch (Exception $e) {
            echo json_encode(['status' => 500, 'message' => 'Failed to send email. Mailer Error: ' . $mail->ErrorInfo]);
        }
    } else {
        echo json_encode(['status' => 404, 'message' => 'Email not found.']);
    }
} else {
    echo json_encode(['status' => 400, 'message' => 'Bad request.']);
}
