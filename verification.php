<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';
require 'vendor/autoload.php'; // Include PHPMailer autoloader

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["email"])) {
    try {
        $email = $_POST["email"];

        $_SESSION["email"] = $email;

        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "logincred";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            throw new Exception("Database connection failed: " . $conn->connect_error);
        }

        $otp = mt_rand(100000, 999999);

        $storeOtpQuery = "UPDATE logindata SET OTP = '$otp' WHERE Email = '$email'";
        if (!$conn->query($storeOtpQuery)) {
            throw new Exception("Error updating OTP: " . $conn->error);
        }

        // Send email using PHPMailer
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'hdewangan322@gmail.com'; // Your Gmail address
        $mail->Password = 'fnju gbvj yfba chgk'; // Your Gmail password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;
        $mail->setFrom('hdewangan322@gmail.com', 'Harsh'); // Sender's name and email
        $mail->addAddress($email); // Recipient's email
        $mail->isHTML(true);
        $mail->Subject = 'Verification OTP';
        $mail->Body = "Your OTP for verification is: $otp";
        $mail->send();

        echo "OTP sent to " . htmlspecialchars($_POST['email']);
        header("location:verification.html");
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: " . $e->getMessage();
    } finally {
        if ($conn) {
            $conn->close();
        }
    }
} else {
    echo "Invalid request";
}
?>
