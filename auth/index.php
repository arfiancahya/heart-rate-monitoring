<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <link rel="shortcut icon" type="image/x-icon" href="../assets/img/stisla.svg" />
  <title>Smart Care - Login</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="../assets/modules/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="../assets/modules/fontawesome/css/all.min.css">


  <!-- Template CSS -->
  <link rel="stylesheet" href="../assets/css/mystyle.css">
  <link rel="stylesheet" href="../assets/css/components.css">

  <?php
  session_start();
  if (isset($_SESSION['id_user'])) {
    header('location:../');
  } else {
    include 'connect.php';
    if (isset($_POST['submit'])) {
      @$user = mysqli_real_escape_string($conn, $_POST['username']);
      @$pass = mysqli_real_escape_string($conn, $_POST['password']);

      $login = mysqli_query($conn, "SELECT * FROM user WHERE (username='$user' or email='$user') AND password='".md5($pass)."'");
      $cek = mysqli_num_rows($login);
      $userid = mysqli_fetch_array($login);

      if ($cek == 0) {
        echo '
        <script>
        setTimeout(function() {
          swal({
            title: "Login Gagal",
            text: "Username, Email, atau Password Anda Salah. Mohon periksa kembali form anda!",
            icon: "error"
            });
            }, 500);
            </script>
            ';
      } else {
        header('location:../');
        $_SESSION['id_user'] = $userid['id'];
      }
    }
  ?>
</head>

<body>
  <div id="app">
    <section class="login-content">
      <div class="login-container">
        <div class="login-style">
          <div class="login-coloum pdn-btm">
            <div class="login-brand">
              <h1 class="clr-h1">Sign In To Smart Care </h1>
              <div class="text-align-center">
                <i class="fab fa-facebook-f fa-2x"></i>
                <i class="fab fa-google-plus-g fa-2x mrg"></i>
                <i class="fab fa-linkedin-in fa-2x"></i>
              </div>
            </div>
            <p class="text-center">or use your email account</p>
            <form method="POST" action="" class="needs-validation" novalidate="" autocomplete="off">
              <div class="form-group form-flex">
                <label for="username" class="form-hidden">Username</label>
                <i class="far fa-envelope fa-lg form-icon"></i>
                <div class="form-edit">
                  <input id="username" type="text" placeholder="Email / Username" class="form-control form-bord " minlength="2" name="username" tabindex="1" required autofocus>
                  <div class="invalid-feedback">
                    Mohon isi username anda dengan benar!
                  </div>
                </div>
              </div>

              <div class="form-group form-flex">
                <div class="d-block">
                  <label for="password" class="control-label form-hidden">Password</label>
                </div>
                <i class="fas fa-lock fa-lg  form-icon"></i>
                <div class="form-edit">
                  <input id="password" type="password" placeholder="Password" class="form-control form-bord" name="password" tabindex="2" required>
                  <div class="invalid-feedback">
                    Mohon isi password anda!
                  </div>
                </div>
              </div>
              <div class="div-syle">
                <a href="forget.php" class="a-style">
                  <p class="text-center a-style">Forgot your password</p>
                </a>
              </div>
              <div class="form-group form-flexs mrg-btm-reset">
                        <button type="submit" name="submit" class="btn black btn-primary btn-lg btn-block btn-width" tabindex="4">
                Sign In
                </button>
              </div>
              <div id="myId" class="div-syle d-none">
                <a href="register.php" class="a-style">
                  <p class="text-center a-style">First time here? <span style="text-decoration: underline; font-weight: bold;">signup</span></p>
                </a>
              </div>
            </form>
          </div>
          <div class="register-brand">
            <h1 class="text-center">Hello My Friend!</h1>
            <p class="margin">Enter your personal details and start journey with us </p>
            <a href="register.php"><button type="submit" class="btn black margin btn-lg btn-block btn-width btn-reg" tabindex="4">
                Sign Up
              </button>
            </a>

          </div>
        </div>


      </div>

  </div>
  </section>
  </div>

  <!-- General JS Scripts -->
  <script src="../assets/modules/jquery.min.js"></script>
  <script src="../assets/modules/popper.js"></script>
  <script src="../assets/modules/tooltip.js"></script>
  <script src="../assets/modules/bootstrap/js/bootstrap.min.js"></script>
  <script src="../assets/modules/nicescroll/jquery.nicescroll.min.js"></script>
  <script src="../assets/modules/moment.min.js"></script>
  <script src="../assets/js/stisla.js"></script>

  <!-- Template JS File -->
  <script src="../assets/js/scripts.js"></script>
  <script src="../assets/js/custom.js"></script>
  <!-- Sweet Alert -->
  <script src="../assets/modules/sweetalert/sweetalert.min.js"></script>
  <script src="../assets/js/page/modules-sweetalert.js"></script>
</body>
<?php } ?>

</html>