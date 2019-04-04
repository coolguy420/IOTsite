<?php
  ini_set("session.save_path", "sessionData");
  session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Devices</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="">
  </head>
  <body>
  <div id="bigdamnwrapper">

    <div id="topbar">
      <img src="img\banner.png"/>
        <nav>
          <ul>
            <li>
              <a href="home.php">Home</a>
            </li>
            <?php
              if(isset($_SESSION['admin-logged-in'])){
                echo "<li><a href=\"admin.php\">Admin</a></li>";
              }else if(isset($_SESSION['user-logged-in'])){
                echo "<li><a href=\"devices.php\">Devices</a></li>";
              }
            ?>
          </ul>
          <?php
            if (isset($_SESSION['uName'])) {
              $username = $_SESSION['uName'];
              echo "<div><p>Logged in as: $username</p>
              <form method=\"post\" action=\"logoutProcess.php\">
              <input type=\"submit\" value=\"Logout\"></div>
              </form>";
            }else{
              echo "<div><form method=\"post\" action=\"loginProcess.php\">
                    <div>Username <input type=\"text\" name=\"username\">
                    Password <input type=\"password\" name=\"password\">
                    <input type=\"submit\" value=\"Login\"></div></form></div>
                    </form>";
            }
          ?>
        </nav>
    </div>

    <div class="blogpost">
        <?php
      if (null !== $_SESSION['uName']){
        echo "<h1>Your devices</h1>
              <p>Here you'll find all the devices you have added. Click on a device to view its readings.</p>
              <div class=\"divider\"></div>";
        $conn = mysqli_connect('localhost', 'test', '123456789', 'test');
        if (mysqli_connect_errno()) {
          echo "<p>Connection failed:".mysqli_connect_error()."</p>\n";
        }
        $username = $_SESSION['uName'];

        $sql = "SELECT device.device_id, device.device_name, iot_users.user_id FROM device INNER JOIN iot_users ON iot_users.user_id = device.device_id WHERE iot_users.user_username = '$username'";

        $queryresult = mysqli_query($conn, $sql) or die(mysqli_error($conn));

        while($row = mysqli_fetch_assoc($queryresult)){
          $device_id = $row['device_id'];
          $user_id = $row['user_id'];
          $device_name = $row['device_name'];
          if($user_id !== 0){
            echo "<h2><a href = \"viewDevice.php?device_id=$device_id&device_name=$device_name\">$device_name</a></h2></br>";
          }
        }
        mysqli_free_result($queryresult);
          mysqli_close($conn);
      }else{
        echo "<p>Please log in to access this page.</p>";
      }
      ?>
    </div>

  </body>

</html>
