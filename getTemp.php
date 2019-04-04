
<?php
  $id = $_POST["id"];
  $conn = mysqli_connect('127.0.0.1', 'test', '123456789', 'test');
  $sql = "SELECT temps.temp from temps WHERE temp_id = '$id' ORDER BY temps.timetaken DESC LIMIT 1";
  $queryresult = mysqli_query($conn, $sql) or die(mysqli_error($conn));
  while($row = mysqli_fetch_assoc($queryresult)){
    $temp = $row['temp'];
  }
  mysqli_free_result($queryresult);
  mysqli_close($conn);
  echo "$temp";
?>
