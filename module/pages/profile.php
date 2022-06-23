<?php
    $cUserID  = $_SESSION['user_id'];
    if(isset($_POST['save_biodata'])){
        $cNama    = $_POST['cNama'];
        $cAlamat  = $_POST['cAlamat'];
        $cPoscode = $_POST['cPoscode'];
        $cTelp    = $_POST['cTelp'];
        mysqli_query($db,"update users set name='$cNama',address='$cAlamat',poscode='$cPoscode',telp='$cTelp' where id='$cUserID'");
        $_SESSION['name']     = $cNama;
        $_SESSION['telp']     = $cTelp;
        $_SESSION['address']  = $cAlamat;
        $_SESSION['poscode']  = $cPoscode;
        echo "<script>alert('Data Disimpan');</script>";
        echo "<script>window.location.href = 'index.php?page=profile';</script>";
    }else if(isset($_POST['save_pass'])){
        $cPassOld = md5($_POST['cPassOld']);
        $cPassNew = md5($_POST['cPassNew']);
        $cPassRe  = md5($_POST['cPassRe']);
        $dbData   = mysqli_query($db,"select * from users where id='$cUserID'");
        if($dbRow = mysqli_fetch_array($dbData)){
            $cUserPassword = $dbRow['password'];
            if($cUserPassword == $cPassOld){
                if($cPassNew == $cPassRe){
                    mysqli_query($db,"update users set password='$cPassNew' where id='$cUserID'");
                    echo "<script>alert('Password Berhasil Diperbarui! Silahkan Login Kembali..');</script>";
                    echo "<script>window.location.href = 'logout.php';</script>";
                }else{
                    echo "<script>alert('Password Baru Tidak Cocok');</script>";
                }
            }else{
                echo "<script>alert('Password Lama Tidak Sama');</script>";
            }
        }
    }
    
?>
<div class="title">
    <h2>Profil</h2>
</div>
<div class="wrapper">
    <h3>Biodata</h3>
    <form action="?page=profile" method="post">
        <div class="row" style="margin-top:5px;">
            <div class="col-md-2">
                <label for="">Nama</label>
            </div>
            <div class="col-md-10">
                <input type="text" name="cNama" class="form-control" value="<?=$_SESSION['name']?>">
            </div>
        </div>
        <div class="row" style="margin-top:5px;">
            <div class="col-md-2">
                <label for="">Alamat</label>
            </div>
            <div class="col-md-10">
                <input type="text" name="cAlamat" class="form-control" value="<?=$_SESSION['address']?>">
            </div>
        </div>
        <div class="row" style="margin-top:5px;">
            <div class="col-md-2">
                <label for="">Kode Pos</label>
            </div>
            <div class="col-md-10">
                <input type="text" name="cPoscode" class="form-control" value="<?=$_SESSION['poscode']?>">
            </div>
        </div>
        <div class="row" style="margin-top:5px;">
            <div class="col-md-2">
                <label for="">Telepon</label>
            </div>
            <div class="col-md-10">
                <input type="text" name="cTelp" class="form-control" value="<?=$_SESSION['telp']?>">
            </div>
        </div>
        <div class="row" style="margin-top:5px;">
            <div class="col-md-2 offset-md-10">
                <button type="submit" name="save_biodata" class="btn btn-primary btn-block">
                    <i class="fa fa-check"></i>
                    Simpan
                </button>
            </div>
        </div>
    </form>
    <hr>
    <h3>Akun</h3>
    <form action="?page=profile" method="post">
        <div class="row" style="margin-top:5px;">
            <div class="col-md-3">
                <label for="">Email</label>
            </div>
            <div class="col-md-9">
                <input type="email" name="cNama" class="form-control" value="<?=$_SESSION['email']?>" readonly title="email tidak bisa diubah">
            </div>
        </div>
        <hr>
        <div class="row" style="margin-top:5px;">
            <div class="col-md-5">
                <h3>Ubah Password<h3>
            </div>
        </div>
        <div class="row" style="margin-top:5px;">
            <div class="col-md-3">
                <label for="">Password Lama</label>
            </div>
            <div class="col-md-9">
                <input type="password" name="cPassOld" class="form-control">
            </div>
        </div>
        <div class="row" style="margin-top:5px;">
            <div class="col-md-3">
                <label for="">Password Baru</label>
            </div>
            <div class="col-md-9">
                <input type="password" name="cPassNew" class="form-control">
            </div>
        </div>
        <div class="row" style="margin-top:5px;">
            <div class="col-md-3">
                <label for="">Ulangi Password</label>
            </div>
            <div class="col-md-9">
                <input type="password" name="cPassRe" class="form-control">
            </div>
        </div>
        <div class="row" style="margin-top:5px;">
            <div class="col-md-2 offset-md-10">
                <button type="submit" name="save_pass" class="btn btn-warning btn-block">
                    <i class="fa fa-lock"></i>
                    Simpan
                </button>
            </div>
        </div>
    </form>
</div>