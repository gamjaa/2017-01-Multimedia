<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>
<body>

<?php
@require('conn.php');
global $mysqli;

mysql_query("set session character_set_connection=utf8;");

mysql_query("set session character_set_results=utf8;");

mysql_query("set session character_set_client=utf8;");


$query = "INSERT INTO word (word_data)
          VALUES ('".$_POST['word']."');";

echo "word:";
echo $_POST['word'];
echo "<br>query:";
echo $query;
echo "<br>result:";
$result = $mysqli->query($query);
echo $result;
echo "<br>num_rows:";
echo $result->num_rows;
?>

</body>
</html>
