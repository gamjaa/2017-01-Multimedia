<?php
$php_filename = basename(__FILE__);
$title = "그림-그림 :: 단어 등록";
include_once("header.php");

require_once 'conn.php';
global $mysqli;
if(isset($_POST['word'])) {
  $query = "INSERT INTO word (word_data) VALUES ('".$_POST['word']."');";
  $result = $mysqli->query($query);
  echo "<script language='javascript'>
          alert('등록 완료!');
          location.replace('{$php_filename}');
        </script>";
}
?>
<div class="jumbotron">
    <h2>단어 등록</h2>
</div>
<div style="text-align: center;">
<form class="form-inline" method='POST'>
  <div class="form-group">
    <label>추천 단어</label>
    <input type="text" class="form-control" name="word">
  </div>
  <button type="submit" class="btn btn-save">제출</button>
</form>
</div>
<?php include_once("footer.php"); ?>
