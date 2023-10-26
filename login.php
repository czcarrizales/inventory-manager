<?php
require_once 'session.class.php';
$session = new Session();
echo $_SESSION['user_email'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php include('navbar.php') ?>
    <form action="loginUser.php" method="post">
        <h1>Login Form</h1>
        <label for="">email</label>
        <input type="text" name="email">
        <label for="">password</label>
        <input type="password" name="password">
        <button>login</button>
    </form>
</body>
</html>