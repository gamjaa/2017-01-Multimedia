<?php session_start(); ?>
<a href="draw.php">그림 그리기</a><br>
<a href="write.php">단어 맞추기</a><br>
<a href="#">단어 추가</a><br>
<?php if(isset($_SESSION['user_id']) {
  echo "<a href='logout.php'>로그아웃</a>";
} else {
  echo "<a href='login.php'>로그인</a>";
}
?>
