<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <link rel="shortcut icon" type="image/x-icon" href="../assets/img/Icon Patah.svg" />
  <title>P A T A H - Register</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="../assets/modules/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="../assets/modules/fontawesome/css/all.min.css">


  <!-- Template CSS -->
  <link rel="stylesheet" href="../assets/css/mystyle.css">
  <link rel="stylesheet" href="../assets/css/components.css">
</head>
<body>
<div class="container" align="center">
  <br>
    <?php
         include 'connect.php';
         $token=$_GET['t'];
         $sql=mysqli_query($conn, "SELECT * FROM user WHERE token='".$token."' AND aktif='0'");
         if (mysqli_num_rows($sql)>0) {
             //update data users aktif
             mysqli_query($conn,"UPDATE user SET aktif='1' WHERE token='".$token."' AND aktif='0'");
             echo '<div class="alert alert-success">
                        Akun anda sudah aktif, silahkan <a href="index.php">Login</a>
                        </div>';
         }else{
                    //data tidak di temukan
                     echo '<div class="alert alert-warning">
                        Invalid Token!
                        </div>';
                   }
    ?>
</div>
</body>
</html>