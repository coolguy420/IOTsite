<?php
  ini_set("session.save_path", "sessionData");
  session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Log in</title>
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
        $username = filter_has_var(INPUT_POST, 'username') ? $_POST['username']: null;
        $password  = filter_has_var(INPUT_POST, 'password') ? $_POST['password']: null;

        if(empty($username)){
          die("<p>You have not entered your username. <a href=\"loginForm.html\">Go back</a></p>");
        }
        if(empty($password)){
          die("<p>You have not entered your password. <a href=\"loginForm.html\">Go back</a></p>");
        }

        $conn = mysqli_connect('127.0.0.1', 'test', '123456789', 'test');
          if (mysqli_connect_errno()) {
          echo "<p>Connection failed:".mysqli_connect_error()."</p>\n";
          }

        $sql = "SELECT user_usertype, user_hashpass FROM iot_users WHERE user_username = '$username'";

      	$queryresult = mysqli_query($conn, $sql) or die(mysqli_error($conn));

        while($row = mysqli_fetch_assoc($queryresult)){
          $passwordhash = $row['user_hashpass'];
          $comparison = $row['user_usertype'];
        }

          if(password_verify($password, $passwordhash)){
            echo "<p>Password is valid!</p>";
            echo "<p>Logged in as: $comparison</p>";
          }else{
            echo "<p>Invalid password.</p>";
            echo "<p><a href=\"home.php\">Click here to go back home</a></p>";
          }

          mysqli_close($conn);

          if($comparison === 'user'){
            $_SESSION['user-logged-in'] = true;
            $_SESSION['uName'] = $username;
            echo '<script type="text/javascript">
                  window.location = "devices.php"
                  </script>';
          }else if($comparison === 'admin'){
            $_SESSION['admin-logged-in'] = true;
            $_SESSION['uName'] = $username;
            echo '<script type="text/javascript">
                  window.location = "admin.php"
                  </script>';
          }

      ?>
    </div>

  </body>

</html>
