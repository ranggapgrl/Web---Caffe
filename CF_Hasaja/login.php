<?php
require 'function.php';
session_start();

// if(isset($_COOKIE['login'])){
//     if($_COOKIE['login'] == 'true'){
//         $_SESSION['login'] = true;
//     }
// }

if(isset($_COOKIE['id']) && isset($_COOKIE['us'])){
    $id = $_COOKIE['id'];
    $username = $_COOKIE['us'];

    $result = mysqli_query($conn, "SELECT username FROM registrasi WHERE id = '$id'");
    $row = mysqli_fetch_assoc($result);

    if($username === hash('sha256', $row['username'])){
        $_SESSION['login'] = true;
    }
}

if(isset($_SESSION["login"])){
    header("Location: index1.2.php");
    exit;
}
if(isset($_POST["login"])){
    $username = $_POST["username"];
    $password = $_POST["password"];

    $result = mysqli_query($conn, "SELECT * FROM registrasi WHERE username= '$username'");

    if(mysqli_num_rows($result) === 1){
        $row = mysqli_fetch_assoc($result);

        if(password_verify($password, $row["password"])){

            $_SESSION["login"] = true;

            if(isset($_POST['remember'])){
                setcookie('id', $row['id'], time()+60);
                setcookie('us', hash('sha256', $row['username']), time()+60);
            }

             header("Location: index1.2.php");
             exit;
        } 
    }
        $error = true;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Dosen</title>
    <link rel="stylesheet" href="style/login.css">
</head>
<body>
    <div class="login-box">
    <h1>Halaman Login</h1>
    <?php if(isset($error)) : ?>
        <p style="color: red; font-style: italic;">Username/password salah</p> 
    <?php endif; ?>
    <form action="" method="post">
        
                <label for="username"> Username: </label>
                <input type="text" name="username" id="username">
            
                <label for="password"> Password: </label>
                <input type="password" name="password" id="password">
          
                <input type="checkbox" name="remember" id="remember">
                <label for="remember"> Remember Me: </label>
          
                <button type="submit" name="login">Login</button>
          
        <p>Belum punya akun? <a href="registrasi.php"><b>Daftar di sini</b></a></p> </form>
        </div>
</body>
</html>