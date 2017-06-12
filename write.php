<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

/*진행 중인 게임이 있는지 확인(room_order != 0)
- 있을 경우
  - 진행 중인 게임 중에 room_order가 짝수인 게임 불러오기
    - 없으면 '없을 경우'로
  - room_play_id 통해서 play_data 불러오기(그림)
  - 단어 작성 후 저장(gamePlay 데이터 생성, room_order + 1, room_play_id 수정)
- 없을 경우
  - 그림 그리기로 참가해주세요!
*/
session_start();

if(isset($_SESSION['user_id'])) {
  $user_id = $_SESSION['user_id'];
} else {
  header("Location: login.php");
}

require_once 'conn.php';
global $mysqli;

if(isset($_POST['submit'])) {
  // 게임 플레이 정보 입력
  $play_room_id = $_POST['play_room_id'];
  $play_order = $_POST['play_order'];
  $play_data = $_POST['play_data'];

  // 게임방, 차례에 맞는지 확인
  $query = "select * from gameRoom where room_id={$play_room_id} and room_order={$play_order};";
  $result = $mysqli->query($query);
  $check = 0;
  while($data = mysqli_fetch_array($result)){
    $check++;
  }
  if($check != 0) {
    // 게임 플레이 정보 저장
    $query = "insert into gamePlay(play_room_id, play_room_order, play_user_id, play_data) values({$play_room_id}, {$play_order}, {$user_id}, '{$play_data}')";
    $mysqli->query($query);

    if($play_order == 6) {
      // 게임 종료
      $query = "update gameRoom set room_order=0, room_play_id=".$mysqli->insert_id." where room_id={$play_room_id};";
      $mysqli->query($query);
    } else {
      // 게임방 정보 변경
      $query = "update gameRoom set room_order=".($play_order+1).", room_play_id=".$mysqli->insert_id." where room_id={$play_room_id};";
      $mysqli->query($query);
    }

    echo "<script language='javascript'>
            alert('성공!');
            location.replace('index.php');
          </script>";
  }
  else {
    echo "<script language='javascript'>
            alert('이미 진행된 순서입니다.');
            location.replace('index.php');
          </script>";
  }
}
else {
  // 진행 중인 게임 확인
  $query = "select * from gameRoom where room_order != 0";
  $result = $mysqli->query($query);
  $gameRoomCount = 0;
  $gameRoom = array();
  while($data = mysqli_fetch_array($result)){
    $gameRoom[$gameRoomCount]['room_id'] = $data['room_id'];
    $gameRoom[$gameRoomCount]['room_order'] = $data['room_order'];
    $gameRoom[$gameRoomCount]['room_play_id'] = $data['room_play_id'];
    $gameRoomCount++;
  }

  // room_order가 짝수인 게임 확인
  // TODO: 본인이 참여하지 않은 게임 확인
  if($gameRoomCount != 0) {
    for($i=0; $i<$gameRoomCount; $i++) {
      if($gameRoom[$i]['room_order'] % 2 == 0) {
        break;
      }
      else if($i == $gameRoomCount - 1) {
        $gameRoomCount = 0;
        break;
      }
    }
  }

  // *** 진행 중인 게임 있을 경우, 단어 맞추기 ***
  if($gameRoomCount != 0) {
    $query = "select * from gamePlay where play_id='".$gameRoom[$i]['room_play_id']."'";
    $result = $mysqli->query($query);
    $data = mysqli_fetch_array($result);

    $query = "select * from gamePlayImage where image_id='".$data['play_data']."'";
    $result = $mysqli->query($query);
    $data = mysqli_fetch_array($result);
    $image = "/upload/".$data['image_data'];

    echo "<img src='{$image}'><br>";
    // TODO: POST 값 수정을 통한 공격을 막기 위해 서버로부터 계산된 검증 데이터 전송 필요
    echo "<form method='POST'>
        <input type='hidden' name='play_room_id' value='".$gameRoom[$i]['room_id']."' />
        <input type='hidden' name='play_order' value='".$gameRoom[$i]['room_order']."' />
        <input name='play_data' type='text' />
        <input type='submit' name='submit' value='제출' />
        </form>";
  }
  // *** 진행 중인 게임 없을 경우, 경고창 ***
  // TODO: 기존 게임방 복제
  else {
    echo "<script language='javascript'>
            alert('게임방이 없습니다.');
            location.replace('index.php');
          </script>";
  }
}
?>
