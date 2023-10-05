<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["otp"])) {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "logincred";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $otp = $_POST["otp"];

    if(isset($_SESSION["email"])){
        $email = $_SESSION["email"];

        $checkOtpQuery = "SELECT OTP FROM logindata WHERE email = '$email'";
        $result = $conn->query($checkOtpQuery);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $storedOtp = $row["OTP"];

            if ($otp == $storedOtp) {
                $updateVerifiedQuery = "UPDATE logindata SET Verified = 'Yes' WHERE email = '$email'";
                if ($conn->query($updateVerifiedQuery) === TRUE) {
                    echo "Email verified successfully!";
                } else {
                    echo "Error updating verification status: " . $conn->error;
                }
            } else {
                echo "Invalid OTP. Please try again.";
            }
        } else {
            echo "Invalid email or OTP.";
        }
    } else {
        echo "Email not found in session variables.";
    }

    $conn->close();
}
?>
