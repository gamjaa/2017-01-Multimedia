<?php
@require('conn.php');
global $mysql;

$query = "INSERT INTO WORD (word_data)
          VALUES ($_POST['word'])";
$mysqli->query($query);
?>
