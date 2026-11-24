<?php 
$title = $_POST['title'];
$discri = $_POST['discri'];
$client = $_POST['client'];
$email = $_POST['email'];
$telephone = $_POST['telephone'];
$adress = $_POST['adress'];

$db = new SQLite3('auftraege.db');
$db->exec("INSERT INTO auftraege (title, beschreibung, client, email, telephone, adress) VALUES ('$title', '$discri', '$client', '$email', '$telephone', '$adress')");

header("Location: home.php");
exit;
?>