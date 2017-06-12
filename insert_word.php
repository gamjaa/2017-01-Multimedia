<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>
<body>

<?php
@require('conn.php');
global $mysqli;

$query = "SELECT * FROM word WHERE word_data = '".$_POST['word']."';";
$result=$mysqli->query($query);

if ($result->num_rows > 0) {
  $i = 0;
  $arr = array();
  while($data = mysqli_fetch_array($result)){
    $arr[$i]['word_id'] = $data['word_id'];
    $arr[$i]['word_data'] = $data['word_data'];
    $i++;
  }
  echo "word:";
  echo $_POST['word'];
  echo "<br>query:";
  echo $query;
  echo "<br>====result====";

  for ($i=0; $i < $result->num_rows; $i++) {
    echo "<br>[".$i."]:(".$arr[$i]['word_id'].") ".$arr[$i]['word_data'];
  }

  echo "<br>===============";
  echo "<br>num_rows:";
  echo $result->num_rows;
  echo "이미 등록된 단어입니다.";

} else {
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

  echo "단어가 추가되었습니다.";
}
?>
</body>
</html>
