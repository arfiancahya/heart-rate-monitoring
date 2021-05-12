<?php  
 session_start();
 include 'auth/connect.php';
 $sessionid = $_SESSION['id_user'];

 if (!isset($sessionid)) {
   header('location:auth');
 } 

 if(isset($_POST["sensorValue"]) && isset($_POST["sensorEcg"]))
 {
  $sensor_value = mysqli_real_escape_string($conn, $_POST["sensorValue"]);
  $ecg_value = mysqli_real_escape_string($conn, $_POST["sensorEcg"]);
  $tgl = date('Y-m-d');
  
    //insert post  
    $sql = "INSERT INTO history(id_user, tgl, sensor_value, ecg_value ) VALUES ('".$_SESSION['id_user']."', '".$tgl."','".$sensor_value."', '".$ecg_value."')";  
    mysqli_query($conn, $sql);  
    echo mysqli_insert_id($conn);  

 }  
 ?>