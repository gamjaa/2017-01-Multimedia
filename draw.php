<?php
/*
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
if($gameRoomCount != 0) {
  for($i=0; $i++; $i<$gameRoomCount) {
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
  /*
  $gameRoom[$i]['room_id']
  $gameRoom[$i]['room_order']
  $gameRoom[$i]['room_word_id']
  $gameRoom[$i]['room_play_id']
  */
  echo $gameRoom[$i]['room_order'];
  if($gameRoom[$i]['room_order'] == 1) {
    $query = "select * from word where word_id='{$gameRoom[$i]['room_word_id']}'";
    echo $query;
    $result = $mysqli->query($query);
    $data = mysqli_fetch_array($result);
    $word = $data['word_data'];
  }
  else {
    $query = "select * from gamePlay where play_id='{$gameRoom[$i]['room_play_id']}'";
    echo $query;
    $result = $mysqli->query($query);
    $data = mysqli_fetch_array($result);
    $word = $data['play_data'];
  }

  echo "제시어: {$word}\n";
  echo "<form enctype='multipart/form-data' action='drawSubmit.php' method='POST'>
      <!-- MAX_FILE_SIZE는 file 입력 필드보다 먼저 나와야 합니다 -->
      <input type='hidden' name='MAX_FILE_SIZE' value='3000000' />
      <input type='hidden' name='play_room_id' value='{$gameRoom[$i]['room_id']}' />
      <!-- input의 name은 $_FILES 배열의 name을 결정합니다 -->
      이 파일을 전송합니다: <input name='userfile' type='file' />
      <input type='submit' value='파일 전송' />
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
  $query = "insert into gameRoom (room_word_id) values ('{$wordset[$answer]['word_id']}')";
  $mysqli->query($query);
  echo "<script language='javascript'>
          document.location.reload();
        </script>";
}

?>
