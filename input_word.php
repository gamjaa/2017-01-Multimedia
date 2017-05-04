<?php
@require('conn.php');
global $mysqli;

echo "<form action='/insert_word.php' method='post'>
추천 단어<input type='text' name='word'><br>
등록<input type='submit' value='Submit'>
</form>";
?>
