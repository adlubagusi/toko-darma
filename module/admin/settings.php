<?php
    if(isset($_POST['change_general'])){
        $cTitle         = $_POST['cTitle'];
        $cSlogan        = $_POST['cSlogan'];
        $cWhatsapp      = $_POST['cWhatsapp'];
        $cEmailContact  = $_POST['cEmailContact'];
        mysqli_query($db,"update general set app_name='$cTitle',slogan='$cSlogan',whatsapp='$cWhatsapp',email_contact='$cEmailContact'");
        echo "<script>alert('Data Disimpan');</script>";
        echo "<script>window.location.href = 'admin.php?page=settings&opt=general';</script>";
    }
    if(isset($_POST['edit_description_setting'])){
        $cDesc = $_POST['cDesc'];
        mysqli_query($db,"update settings set short_desc='$cDesc'");
        echo "<script>alert('Data Disimpan');</script>";
        echo "<script>window.location.href = 'admin.php?page=settings&opt=description';</script>";
    }
    if(isset($_POST['change_address'])){
        $cAddress = $_POST['cAddress'];
        mysqli_query($db,"update settings set address='$cAddress'");
        echo "<script>alert('Data Disimpan');</script>";
        echo "<script>window.location.href = 'admin.php?page=settings&opt=address';</script>";
    }
?>
<!-- Begin Page Content -->
<div class="container-fluid">
	<!-- Page Heading -->
	<h1 class="h3 mb-2 text-gray-800 mb-4">Settings</h1>

	<div class="row">
        <div class="col-md-3">
            <div class="card shadow">
                <div class="card-body">
                    <div class="list-group">
                        <a href="?page=settings&opt=general" class="list-group-item list-group-item-action">Umum</a>
                        <a href="?page=settings&opt=address" class="list-group-item list-group-item-action">Alamat</a>
                    </div>
                </div>
            </div>
        </div>
        <?php
        if(!isset($_GET['opt']) ||$_GET['opt'] == "general"){
        ?>
        <div class="col-md-9">
            <div class="card shadow">
                <div class="card-header">
                    <h2 class="lead text-dark mb-0">General</h2>
                </div>
                    <div class="card-body">
                        <form action="?page=settings" method="post">
                            <div class="form-group">
                                <label for="title">Website Name</label>
                                <input type="text" autocomplete="off" name="cTitle" id="title" class="form-control" required value="<?= $vaGeneral['app_name']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="slogan">Website slogan</label>
                                <input type="text" autocomplete="off" name="cSlogan" id="slogan" class="form-control" required value="<?= $vaGeneral['slogan']; ?>">
                                <small class="text-muted">Will appear on the title home</small>
                            </div>
                            <!-- <div class="form-group">
                                <label for="color">Navigation Color</label>
                                <input type="text" autocomplete="off" name="color" id="color" class="form-control" required value="<?= $vaGeneral['navbar_color']; ?>">
                                <small class="text-muted">Use hex code. Example: #12283F</small>
                            </div> -->
                            <div class="form-group">
                                <label for="whatsapp">WhatsApp</label>
                                <input type="number" autocomplete="off" name="cWhatsapp" id="whatsapp" class="form-control" required value="<?= $vaGeneral['whatsapp']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="email_contact">Email Contact</label>
                                <input type="text" autocomplete="off" name="cEmailContact" id="email_contact" class="form-control" required value="<?= $vaGeneral['email_contact']; ?>">
                            </div>
                            <button type="submit" name="change_general" class="btn btn-sm btn-success">Update</button>    
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php
        }else if($_GET['opt'] == "address"){
        ?>
        <div class="col-md-9">
            <div class="card shadow">
                <div class="card-header">
                    <h2 class="lead text-dark mb-0">Alamat</h2>
                </div>
                <div class="card-body">
                    <form action="?page=settings" method="post">
                        <div class="form-group">
                            <label for="address">Masukkan alamat seperti nama jalan, kota, dll</label>
                            <textarea name="cAddress" value="<?= $vaSettings['address']; ?>" required class="form-control" id="address"><?= $vaSettings['address']; ?></textarea>
                        </div>
                        <button name="change_address" class="btn btn-info">Change Address</button>
                    </form>
                </div>
            </div>
        </div>
        <?php
        }
        ?>
    </div>
</div>
<!-- /.container-fluid -->
