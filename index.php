<?php
$php_filename = basename(__FILE__);
$title = "그림-그림";
include_once("header.php");
?>
<div class="jumbotron">
    <h2>그림-그림</h2>
</div>
<div style="text-align: center;">
<?php
require_once 'conn.php';
global $mysqli;

$query = "SELECT * FROM gameRoom WHERE room_order = 0";
$result = $mysqli->query($query);
$random = mt_rand(0, $result->num_rows-1);
$result->data_seek($random);
$gameRoom = $result->fetch_assoc();

$query = "select * from word where word_id='".$gameRoom['room_word_id']."'";
$result = $mysqli->query($query);
$data = $result->fetch_assoc();
$word = $data['word_data'];

$query = "SELECT * FROM gamePlay WHERE play_room_id = ".$gameRoom['room_id']." ORDER BY gamePlay.play_room_order ASC";
$result = $mysqli->query($query);
$i = 0;
$gamePlay = array();
while($data = mysqli_fetch_assoc($result)){
  $gamePlay[$i]['play_room_order'] = $data['play_room_order'];
  $gamePlay[$i]['play_data'] = $data['play_data'];
  $i++;
}

echo "<h2>".$word."</h2><br><br>";
for($i=0; $i<$result->num_rows; $i++) {
  //echo $gamePlay[$i]['play_room_order']."<br>";
  if($i % 2 == 0) {
    echo "<img src='/upload/".$gamePlay[$i]['play_data']."' width='auto' height='300px'><br><br>";
  } else {
    echo "<h2>".$gamePlay[$i]['play_data']."</h2><br><br>";
  }
}
?>
</div>
<?php include_once("footer.php"); ?>
