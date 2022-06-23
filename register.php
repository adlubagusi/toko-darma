<?php
require_once 'include/cfg.php';
$cError = "" ; 
if(isset($_POST['submitregister'])){
    $cName      = $_POST['cName'];
    $cAlamat    = $_POST['cAlamat'];
    $cTelp      = $_POST['cTelp'];
    $cPoscode   = $_POST['cPoscode'];
    $cEmail     = $_POST['cEmail'];
    $cPassword  = md5($_POST['cPassword']);
    $dbData = mysqli_query($db,"select * from users where email='$cEmail'");
    if($dbRow = mysqli_fetch_array($dbData)){
        $cError = "Email sudah terdaftar, silahkan <a href='login.php'>login</a>" ;
    }else{
        mysqli_query($db,"insert into users (name,address,telp,poscode,email,password,level) values ('$cName','$cAlamat','$cTelp','$cPoscode','$cEmail','$cPassword','user')");
        echo "<script>alert('Pendaftaran akun berhasil, silahkan login..');</script>";
        echo "<script>window.location.href = 'login.php';</script>";
    }
}
else{
    $cError = "" ; 
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Daftar</title>

  <!-- Custom fonts for this template-->
  <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="assets/css/sb-admin-2.min.css" rel="stylesheet">

  <link rel="shortcut icon" href="assets/images/logo/favicon.png" type="image/x-icon">

</head>

<body class="bg-gradient-light">

  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-6 col-lg-y6 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-12">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Daftar Akun Baru!</h1>
                  </div>
                  <?php
                    if($cError <> ""){
                        echo "<div class='alert alert-warning'>".$cError."</div>";
                    }
                  ?>
                  <form class="user" action="" method="post">
                    <div class="form-group" style="text-align: center;">
                      <label class="label">Sudah Punya Akun? <a href="login.php">Login</a></label>
                    </div>
                    <div class="form-group">
                      <label for="name">Nama Lengkap</label>
                      <input type="text" autocomplete="off" id="name" name="cName" required class="form-control">
                    </div>
                    <div class="form-group">
                      <label for="alamat">Alamat</label>
                      <input type="text" autocomplete="off" id="alamat" name="cAlamat" required class="form-control">
                    </div>
                    <div class="form-group">
                      <label for="telp">No. Telpon</label>
                      <input type="text" autocomplete="off" id="telp" name="cTelp" required class="form-control">
                    </div>
                    <div class="form-group">
                      <label for="poscode">Kode Pos</label>
                      <input type="text" autocomplete="off" id="poscode" name="cPoscode" required class="form-control">
                    </div>
                    <div class="form-group">
                      <label for="cEmail">Email</label>
                      <input type="email" autocomplete="off" id="email" name="cEmail" required class="form-control">
                    </div>
                    <div class="form-group">
                      <label for="password">Password</label>
                      <input type="password" autocomplete="off" id="password" name="cPassword" required class="form-control">
                    </div>
                    <button type="submit" name="submitregister" class="btn btn-block btn-dark">Submit</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="assets/vendor/jquery/jquery.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="assets/vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="assets/js/sb-admin-2.min.js"></script>

</body>

</html>
