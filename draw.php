<?php
/*error_reporting(E_ALL);
ini_set("display_errors", 1);

진행 중인 게임이 있는지 확인(room_order != 0)
- 있을 경우
  - 진행 중인 게임 중에 room_order가 홀수인 게임 불러오기
    - 없으면 '없을 경우'로
  - room_play_id 통해서 play_data 불러오기(단어)
  - 그림 그리기 후 제출(gamePlay 데이터 생성, room_order + 1, room_play_id 수정)
- 없을 경우
  - word 테이블에서 랜덤으로 단어 불러와서 출력
  - 그림 그리기 후 저장, room 생성(gamePlay 데이터 생성, room_order = 2, room_play_id 입력)
*/
@require('conn.php');
global $mysqli;

if(isset($_POST['submit'])) {
  // 게임 플레이 정보 입력
  $play_room_id = $_POST['play_room_id'];
  $play_order = $_POST['play_order'];

  // 게임방, 차례에 맞는지 확인
  $query = "select * from gameRoom where room_id={$play_room_id} and room_order={$play_order};";
  $result = $mysqli->query($query);
  $check = 0;
  while($data = mysqli_fetch_array($result)){
    $check++;
  }
  if($check != 0) {
    // 이미지 업로드
    $uploadDir = '/home/multi/html/upload/';
    $uploadFile = date("U").substr($_FILES['userfile']['tmp_name'], 8).".".pathinfo($_FILES['userfile']['name'])['extension'];
    $uploadPath = $uploadDir . $uploadFile;

    if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadPath)) {
      // 이미지명 DB 저장
      $query = "insert into gamePlayImage(image_data) values ('{$uploadFile}');";
      $mysqli->query($query);

      // 게임 플레이 정보 저장
      $query = "insert into gamePlay(play_room_id, play_room_order, play_data) values({$play_room_id}, {$play_order}, {$mysqli->insert_id})";
      $mysqli->query($query);

      // 게임방 정보 변경
      $query = "update gameRoom set room_order=".($play_order+1).", room_play_id=".$mysqli->insert_id." where room_id={$play_room_id};";
      $mysqli->query($query);

      echo "<script language='javascript'>
              alert('성공!');
              location.replace('index.php');
            </script>";
    }
    else {
      echo "<script language='javascript'>
              alert('이미지 업로드 실패!');
              location.replace('index.php');
            </script>";
    }
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
    $gameRoom[$gameRoomCount]['room_word_id'] = $data['room_word_id'];
    $gameRoom[$gameRoomCount]['room_play_id'] = $data['room_play_id'];
    $gameRoomCount++;
  }

  // room_order가 홀수인 게임 확인
  // TODO: 본인이 참여하지 않은 게임 확인
  if($gameRoomCount != 0) {
    for($i=0; $i<$gameRoomCount; $i++) {
      if($gameRoom[$i]['room_order'] % 2 == 1) {
        break;
      }
      else if($i == $gameRoomCount - 1) {
        $gameRoomCount = 0;
        break;
      }
    }
  }

  // *** 진행 중인 게임 있을 경우, 그림 그리기 ***
  if($gameRoomCount != 0) {
    if($gameRoom[$i]['room_order'] == 1) {
      $query = "select * from word where word_id='".$gameRoom[$i]['room_word_id']."'";
      $result = $mysqli->query($query);
      $data = mysqli_fetch_array($result);
      $word = $data['word_data'];
    }
    else {
      $query = "select * from gamePlay where play_id='".$gameRoom[$i]['room_play_id']."'";
      $result = $mysqli->query($query);
      $data = mysqli_fetch_array($result);
      $word = $data['play_data'];
    }

    echo "제시어: {$word}<br>";
    // TODO: POST 값 수정을 통한 공격을 막기 위해 서버로부터 계산된 검증 데이터 전송 필요
    echo "<form enctype='multipart/form-data' method='POST'>
        <input type='hidden' name='play_room_id' value='".$gameRoom[$i]['room_id']."' />
        <input type='hidden' name='play_order' value='".$gameRoom[$i]['room_order']."' />
        이 파일을 전송합니다: <input name='userfile' type='file' />
        <input type='submit' name='submit' value='파일 전송' />
        </form>";
  }
  // *** 진행 중인 게임 없을 경우, gameRoom 생성 후 새로고침 ***
  else {
    // word 테이블에서 단어 불러오기 후 랜덤으로 한 개 선정
    $query = "select * from word";
    $result = $mysqli->query($query);
    $i = 0;
    $wordset = array();
    while($data = mysqli_fetch_array($result)){
      $wordset[$i]['word_id'] = $data['word_id'];
      $wordset[$i]['word_data'] = $data['word_data'];
      $i++;
    }
    $answer = mt_rand(0, $i-1);

    // gameRoom 생성 후 새로고침
    $query = "insert into gameRoom (room_word_id) values ('".$wordset[$answer]['word_id']."')";
    $mysqli->query($query);
    echo "<script language='javascript'>
            document.location.reload();
          </script>";
  }
}
?>
