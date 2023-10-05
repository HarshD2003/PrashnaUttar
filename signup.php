<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $name = $_POST["name"];
    $email = $_POST["email"];
    $confirmemail = $_POST["confirmemail"];
    $password = $_POST["password"];
    $confirmpassword = $_POST["confirmpassword"];
    $dob = $_POST["dob"];

    if ($email !== $confirmemail) {
        echo '<script>alert("Emails do not match. Please try again.");</script>';
    } elseif ($password !== $confirmpassword) {
        echo '<script>alert("Passwords do not match. Please try again.");</script>';
    } else {
        $servername = "localhost";
        $username = "root";
        $dbpassword = "";
        $database = "logincred";

        $conn = new mysqli($servername, $username, $dbpassword, $database);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "INSERT INTO logindata (Username, Email, Password, DOB, Verified) VALUES ('$name', '$email', '$password', '$dob', 'No')";
        if ($conn->query($sql) === TRUE) {
            echo '<script>alert("Registration successful. You can now login.");</script>';
            header("Location: login.html");
        } else {
            echo '<script>alert("Error: ' . $conn->error . '");</script>';
        }

        $conn->close();
    }
}
?>
