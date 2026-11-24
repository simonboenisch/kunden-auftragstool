<?php 
$id = $_POST['id'];

$db = new SQLite3('auftraege.db');
$db -> exec("DELETE FROM auftraege WHERE auftrags_id = '$id'");
header('Location: home.php');
exit;
?>