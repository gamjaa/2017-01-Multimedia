<?php
@require('conn.php');
global $mysqli;

$query = "INSERT INTO word (word_data)
          VALUES (''".$_POST['word']."'')";
echo $query."<br>";
echo $_POST['word']."<br>";
echo mysqli->query($query);
?>
