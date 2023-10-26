<?php
require_once('database.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $registerEmail = $_POST['email'];
    $registerPassword = $_POST['password'];
    $hashedPassword = password_hash($registerPassword, PASSWORD_BCRYPT);
    registerUser($registerEmail, $hashedPassword);
}

function registerUser($email, $password)
{
    $conn = connectToDatabase();

    if (!$conn) {
        throw new Exception("Database connection failed");
    }

    $sql = "INSERT INTO users (email, password) VALUES (?,?)";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        throw new Exception("SQL statement preparation failed");
    }

    $stmt->bind_param("ss", $email, $password);

    $result = $stmt->execute();

    if ($result) {
        $stmt->close();
        $conn->close();
        header('Location: login.php');
        exit;
    } else {
        throw new Exception("User register failed");
    }
}
