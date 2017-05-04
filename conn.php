<?php
$mysqli = new mysqli("127.0.0.1", "root", "123", "telestration");

/*
소스 작성시 참고용
다른 파일에서 불러올 때는 @require('conn.php'); 명령어 사용

function writePost($marketNumber, $id, $password, $post, $tag, $image_name){
	global $mysqli;
	$query = "insert into mp3_board (marketNumber,id,password,post,tag,image_name) values('$marketNumber', '$id', '".md5($password)."', '$post', '$tag', '$image_name')";
	$mysqli->query($query);
}

function readPost($marketNumber){
	global $mysqli;
	$i=0;
	$query = "select * from mp3_board where marketNumber =".$marketNumber;
	$result = $mysqli->query($query);
	$arr = array();
	while($data = mysqli_fetch_array($result)){
		$arr[$i]['postNumber'] = $data['postNumber'];
		$arr[$i]['id'] = $data['id'];
		$arr[$i]['password'] = $data['password'];
		$arr[$i]['post'] = $data['post'];
		$arr[$i]['tag'] = $data['tag'];
		$arr[$i]['image_name'] = $data['image_name'];
		$arr[$i]['date'] = $data['date'];
		$i++;
	}
	return $arr;
}

function updatePost($postNumber, $post, $password){
	global $mysqli;
	$passwordCheck = "select * from mp3_board where password = '$password' ";
	if(!mysqli_fetch_array($mysqli->query($passwordCheck))){
		echo("<script language='javascript'>alert('Password가 잘못됨!');</script>");
		exit(0);
	}
	$query = "update mp3_board set post='$post' where postNumber = $postNumber";
	$mysqli->query($query);
}

function deletePost($postNumber, $password){
	global $mysqli;
	$passwordCheck = "select * from mp3_board where password = '$password' ";
	if(!mysqli_fetch_array($mysqli->query($passwordCheck))){
		echo("<script language='javascript'>alert('Password가 잘못됨!');</script>");
		exit(0);
	}
	$query = "delete from mp3_board where postNumber = $postNumber";
	$mysqli->query($query);
}
*/
?>
