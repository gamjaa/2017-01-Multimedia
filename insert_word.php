<?php
@require('conn.php');
global $mysqli;

$query = "INSERT INTO word (word_data)
          VALUES (''".$_POST['word']."'')";
echo $query;
echo mysqli->query($query);
echo $_POST['word'];
?>
