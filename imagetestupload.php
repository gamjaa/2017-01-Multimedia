<?php
@require('conn.php');
global $mysqli;
$uploadDir = '/var/www/html/upload/';
$uploadFile = $uploadDir . basename($_FILES['userfile']['name']);

echo '<pre>';
if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadFile)) {
    echo "파일이 유효하고, 성공적으로 업로드 되었습니다.\n";
    $query = "update imagetest set image_data=".basename($_FILES['userfile']['name'])." where image_id=0;";
    $mysqli->query($query);
} else {
    print "파일 업로드 공격의 가능성이 있습니다!\n";
}

echo '자세한 디버깅 정보입니다:';
print_r($_FILES);

print "</pre>";
?>
