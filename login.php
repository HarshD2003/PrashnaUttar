<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $servername = "localhost"; 
    $username = "root";
    $dbpassword = "";
    $database = "logincred";

    $conn = new mysqli($servername, $username, $dbpassword, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM logindata WHERE email = '$email' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($row["Verified"] == "Yes") {
            $conn->close();
            header("Location: home.html");
            exit();
        } else {
            $conn->close();
            header("Location: verification.html");
            exit();
        }
    } else {
        $conn->close();
        header("Location: login.html");
        exit();
    }
}
?>
