<!DOCTYPE HTML>
<html lang="kr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?=$title?></title>
    <link href="/canvas/bootstrap.min.css" rel="stylesheet">
    <link href="/canvas/jumbotron-narrow.css" rel="stylesheet">
  </head>
  <body>
    <div id="fb-root"></div>
    <script>(function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = "//connect.facebook.net/ko_KR/sdk.js#xfbml=1&version=v2.9&appId=1527793830624820";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>

    <div class="container">
      <div class="header clearfix">
        <nav>
          <ul class="nav nav-pills pull-right">
            <li role="presentation" <?php if($php_filename == 'index.php') echo ' class=active'; ?>><a href="index.php">Home</a></li>
            <li role="presentation"<?php if($php_filename == 'draw.php') echo ' class=active'; ?>><a href="draw.php">Draw</a></li>
            <li role="presentation"<?php if($php_filename == 'write.php') echo ' class=active'; ?>><a href="write.php">Write</a></li>
            <li role="presentation"<?php if($php_filename == 'input_word.php') echo ' class=active'; ?>><a href="input_word.php">Word</a></li>
            <?php
            session_start();
            if(isset($_SESSION['user_id'])) {
              echo '<li role="presentation"><a href="logout.php">Logout</a></li>';
            } else {
              echo '<li role="presentation"><a href="login.php"><img src="login.png" height="20px"></a></li>';
            }
            ?>
          </ul>
        </nav>
        <h3 class="text-muted">GLIM-GLIM</h3>
      </div>
