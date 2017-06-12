<?php
/*error_reporting(E_ALL);
ini_set("display_errors", 1);

- 그냥 접속하면 완료된 게임 중에 하나 랜덤 출력
- $_GET['room'] 있으면 해당 게임 출력
*/

require_once 'conn.php';
global $mysqli;

if(isset($_GET['room'])) {
  $query = "SELECT * FROM gameRoom WHERE room_id = {$_GET['room']} and room_order=0";
  $result = $mysqli->query($query);
  if ($result->num_rows > 0) {
    $gameRoom = $result->fetch_assoc();

    $query = "select * from word where word_id='".$gameRoom['room_word_id']."'";
    $result = $mysqli->query($query);
    $data = $result->fetch_assoc();
    $word = $data['word_data'];
    echo $word."<br>";

    $query = "SELECT * FROM gamePlay WHERE play_room_id = ".$gameRoom['room_id']." ORDER BY gamePlay.play_room_order ASC";
    $result = $mysqli->query($query);
    $i = 0;
    $gamePlay = array();
    while($data = mysqli_fetch_assoc($result)){
      $gamePlay[$i]['play_room_order'] = $data['play_room_order'];
      $gamePlay[$i]['play_data'] = $data['play_data'];
      $i++;
    }

    for($i=0; $i<$result->num_rows; $i++) {
      echo $gamePlay[$i]['play_room_order']."<br>";
      if($i % 2 == 0) {
        echo "<img src='/upload/".$gamePlay[$i]['play_data']."'><br>";
      } else {
        echo $gamePlay[$i]['play_data']."<br>";
      }
    }
  } else {
    echo "<script language='javascript'>
            alert('아직 진행 중인 게임입니다.');
            location.replace('index.php');
          </script>";
  }
} else {
  $query = "SELECT * FROM gameRoom WHERE room_order = 0";
  $result = $mysqli->query($query);
  $random = mt_rand(0, $result->num_rows-1);
  $result->data_seek($random);
  $gameRoom = $result->fetch_assoc();

  $query = "select * from word where word_id='".$gameRoom['room_word_id']."'";
  $result = $mysqli->query($query);
  $data = $result->fetch_assoc();
  $word = $data['word_data'];
  echo $word."<br>";

  $query = "SELECT * FROM gamePlay WHERE play_room_id = ".$gameRoom['room_id']." ORDER BY gamePlay.play_room_order ASC";
  $result = $mysqli->query($query);
  $i = 0;
  $gamePlay = array();
  while($data = mysqli_fetch_assoc($result)){
    $gamePlay[$i]['play_room_order'] = $data['play_room_order'];
    $gamePlay[$i]['play_data'] = $data['play_data'];
    $i++;
  }

  for($i=0; $i<$result->num_rows; $i++) {
    echo $gamePlay[$i]['play_room_order']."<br>";
    if($i % 2 == 0) {
      echo "<img src='/upload/".$gamePlay[$i]['play_data']."'><br>";
    } else {
      echo $gamePlay[$i]['play_data']."<br>";
    }
  }
}

$result->close();
$mysqli->close();
?>
