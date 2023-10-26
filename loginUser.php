<?php
session_start();
require_once('database.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $loginEmail = $_POST['email'];
    $loginPassword = $_POST['password'];
    loginUser($loginEmail, $loginPassword);
}

function loginUser($email, $password)
{
    $conn = connectToDatabase();

    if (!$conn) {
        throw new Exception("Database connection failed");
    }

    $sql = "SELECT password FROM users WHERE email = ?";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        throw new Exception("SQL statement preparation failed");
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($storedPassword);
    $stmt->fetch();

    if (password_verify($password, $storedPassword)) {
        $stmt->close();
        $conn->close();
        $_SESSION['user_email'] = $email;
        header('Location: index.php');
    } else {
        header('Location: registration.php');
    }

}