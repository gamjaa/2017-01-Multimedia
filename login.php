<?php
session_start();

if(isset($_SESSION['user_id'])) {
  header("Location: index.php");
}

require_once __DIR__ . '/php-graph-sdk/src/Facebook/autoload.php';

$fb = new Facebook\Facebook([
  'app_id' => '1527793830624820', // Replace {app-id} with your app id
  'app_secret' => 'aaa26ae384cc761c133aef73426869f0',
  'default_graph_version' => 'v2.9',
  'persistent_data_handler' => 'session'
  ]);

$helper = $fb->getRedirectLoginHelper();

$permissions = ['email']; // Optional permissions
$loginUrl = $helper->getLoginUrl('https://multi.gamjabox.kr/fb-callback.php', $permissions);

//echo '<a href="' . htmlspecialchars($loginUrl) . '">Log in with Facebook!</a>';
header("Location: {$loginUrl}");
?>
