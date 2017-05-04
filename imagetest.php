<!-- 데이터 인코딩형 enctype은 꼭 아래처럼 설정해야 합니다 -->
<form enctype="multipart/form-data" action="imagetestupload.php" method="POST">
    <!-- MAX_FILE_SIZE는 file 입력 필드보다 먼저 나와야 합니다 -->
    <input type="hidden" name="MAX_FILE_SIZE" value="30000" />
    <!-- input의 name은 $_FILES 배열의 name을 결정합니다 -->
    이 파일을 전송합니다: <input name="userfile" type="file" />
    <input type="submit" value="파일 전송" />
</form>
<?php
@require('conn.php');
global $mysqli;
$query = "select * from imagetest where image_id=0";
$result = $mysqli->query($query);
$data = mysqli_fetch_array($result);
echo "<img src='./upload/".$data['image_data']."'>";
?>
