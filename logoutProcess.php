<?php
  ini_set("session.save_path", "sessionData");
  session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Log out</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="">
  </head>
  <body>
  <div id="bigdamnwrapper">

    <div id="topbar">
      <img src="img\banner.png"/>
    </div>
    <div class="divider"></div>
    <div class="blogpost">
      <?php
        unset($_SESSION['uName']);
        unset($_SESSION['user-logged-in']);
        unset($_SESSION['staff-logged-in']);
        unset($_SESSION['admin-logged-in']);
        session_destroy();
        echo"<p>Successfully logged out. <a href=\"home.php\">Go home</a></p>";
      ?>
    </div>

  </body>

</html>
