<?php
@require('conn.php');
global $mysqli;
$uploadDir = './upload/';
$uploadFile = $uploadDir . basename($_FILES['userfile']['name']);

move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile);
$query = "update imagetest set image_data=".basename($_FILES['userfile']['name'])." where image_id=0;";
$mysqli->query($query);
?>
