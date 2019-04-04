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
    <script type="text/javascript" src="smoothie.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
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
        $device_name = isset($_REQUEST['device_name']) ? $_REQUEST['device_name'] : null;
        if (null !== $_SESSION['uName']){
          echo "<h1>Readings for $device_name </h1><div class=\"divider\"></div>";
          $conn = mysqli_connect('127.0.0.1', 'test', '123456789', 'test');
          if (mysqli_connect_errno()) {
            echo "<p>Connection failed:".mysqli_connect_error()."</p>\n";
          }
        }
        $device_id = isset($_REQUEST['device_id']) ? $_REQUEST['device_id'] : null;
      ?>
      <h1>Temperature</h1>
      <canvas id="tempCanvas" width="980" height="200"></canvas>
      <script>
        var tempSmoothie = new SmoothieChart();
        tempSmoothie.streamTo(document.getElementById("tempCanvas"), 1000);
        var line1 = new TimeSeries();
        var idString = " <?php echo $device_id ?> ";
        var id = parseInt(idString, 10);
        setInterval(function() {
          $.post('getTemp.php', {id: id}, function(data){
            var temp = parseFloat(data);
            line1.append(new Date().getTime(), temp);
          });
        }, 1000);
        tempSmoothie.addTimeSeries(line1);
      </script>

      <div class=\"divider\"></div>

      <h1>Humidity</h1>
      <canvas id="humidityCanvas" width="980" height="200"></canvas>

      <script>
        var humiditySmoothie = new SmoothieChart();
        humiditySmoothie.streamTo(document.getElementById("humidityCanvas"), 1000);
        var line2 = new TimeSeries();
        var idString = " <?php echo $device_id ?> ";
        var id = parseInt(idString, 10);
        setInterval(function() {
          $.post('getHumidity.php', {id: id}, function(data){
            var humidity = parseFloat(data);
            line2.append(new Date().getTime(), humidity);
          });
        }, 1000);
        humiditySmoothie.addTimeSeries(line2);
      </script>

    </div>

  </body>

</html>
