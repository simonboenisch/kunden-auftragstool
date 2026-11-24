<?php
session_start();
$password = $_POST['password'];

if(sha1($password) == "ce81e9fd4e07b2b70c750eab2c853f56f83d2163"){
    $_SESSION['loggedIn'] = true;
    header("Location: intern/home.php");
    exit;
}else{
    echo "Passwort falsch!";
    exit;
}
?>