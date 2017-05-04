<?php
@require('conn.php');
global $mysqli;

$query = "INSERT INTO word (word_data)
          VALUES ('".$_POST['word']."');";

echo $_POST['word'];
echo "<br>";
echo $query;
echo "<br>";
$result = mysqli->query("INSERT INTO word (word_data) VALUES ('다이소');"
);
echo result;
?>
