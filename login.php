<?php
include_once("config.php");

if (isLoggedIn()) { 
    header('Location: index.php'); 
    exit();
}

if (isset($_POST['login'])){
    $password = $_POST['password'];
    $query = "SELECT * FROM users WHERE username = '$username' OR email = '$username'";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['full_name'] = $user['full_name'];
            header('Location: index.php');
            exit();
        } else {
            $error = "Username atau password salah!";
        }
    } else {
        $error = "Username atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    
</body>
</html>