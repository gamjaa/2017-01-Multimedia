<?php
/*
진행 중인 게임이 있는지 확인(room_order != 0)
- 있을 경우
  - 진행 중인 게임 중에 room_order가 짝수인 게임 불러오기
    - 없으면 '없을 경우'로
  - room_play_id 통해서 play_data 불러오기(그림)
  - 단어 작성 후 저장(gamePlay 데이터 생성, room_order + 1, room_play_id 수정)
- 없을 경우
  - 그림 그리기로 참가해주세요!
*/

?>
