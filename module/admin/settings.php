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
    if(isset($_POST['add_delivery'])){
        $cRegion = $_POST['cRegion'];
        $nPrice  = string2Number($_POST['cPrice']);
        mysqli_query($db,"insert into region (region,price) values ('$cRegion','$nPrice')");
        echo "<script>alert('Data Disimpan');</script>";
        echo "<script>window.location.href = 'admin.php?page=settings&opt=delivery';</script>";
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
                        <!-- <a href="?page=setting&opt=banner" class="list-group-item list-group-item-action">Banner Slider</a> -->
                        <a href="?page=settings&opt=description" class="list-group-item list-group-item-action">Deskripsi</a>
                        <!-- <a href="?page=settings&opt=sosmed" class="list-group-item list-group-item-action">Social media</a> -->
                        <a href="?page=settings&opt=address" class="list-group-item list-group-item-action">Alamat</a>
                        <a href="?page=settings&opt=delivery" class="list-group-item list-group-item-action">Area Pengiriman</a>
                    </div>
                </div>
            </div>
        </div>
        <?php
        if(!isset($_GET['opt']) ||$_GET['opt'] == "general"){
        ?>
        <div class="col-lg-9">
            <div class="card shadow">
                <div class="card-body">
                    <p class="lead">Logo</p>
                    <img src="assets/images/logo/<?= $vaSettings['logo'] ?>" alt="logo" style="padding: 10px; background-color: <?= $vaGeneral['navbar_color']; ?>;" width="40%">
                    <form action="?page=settings&opt=change_logo" method="post" enctype="multipart/form-data">
                        <div class="form-group mt-2">
                            <input type="file" name="cLogo" id="logo" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-sm btn-success">Change Logo</button>    
                    </form>
                    <hr>
                    <p class="lead">Favicon</p>
                    <img src="assets/images/logo/<?= $vaSettings['favicon'] ?>" alt="favicon" width="70px">
                    <form action="?page=settings&opt=change_favicon" method="post" enctype="multipart/form-data">
                        <div class="form-group mt-2">
                            <input type="file" name="cLogo" id="logo" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-sm btn-success">Change Favicon</button>    
                    </form>
                    <div class="col-md-9">
                </div>
            </div>
        </div>
        <div class="card shadow mt-3">
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
        <?php
        }else if($_GET['opt'] == "description"){
        ?>
        <div class="col-md-9">
            <div class="card shadow">
                <div class="card-header">
                    <h2 class="lead text-dark mb-0">Deskripsi Singkat</h2>
                </div>
                <div class="card-body">
                    <!-- <p class="text-muted">This brief description is shown in the footer</p> -->
                    <form action="?page=settings" method="post">
                        <div class="form-group">
                            <textarea name="cDesc" id="desc" class="form-control" rows="5"><?= $vaSettings['short_desc']; ?></textarea>
                        </div>
                        <button name="edit_description_setting" class="btn btn-sm btn-info">Edit Description</button>
                    </form>
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
        }else if($_GET['opt'] == "delivery"){
        ?>
        <div class="col-md-9">
            <div class="card shadow">
                <div class="card-header">
                    <h2 class="lead text-dark mb-0">Area Pengiriman</h2>
                </div>
                <div class="card-body">
                   <a href="?page=settings&opt=add_delivery" class="btn btn-sm btn-info">Add</a>
                   <hr>
                   <table class="table table-bordered">
                        <tr>
                            <th>#</th>
                            <th>Destination</th>
                            <th>Cost/Kg</th>
                            <th>Action</th>
                        </tr>
                        <?php 
                        $no=1; 
                        $dbDelivery = mysqli_query($db,"select * from `region`");
                        while($dbR  = mysqli_fetch_array($dbDelivery)){ ?>
                        <tr>
                            <td><?= $no; ?></td>
                            <td><?= $dbR['region']; ?></td>
                            <td>Rp <?= number2String($dbR['price']); ?></script></td>
                            <td style="width: 100px">
                                <a href="administrator/delete_delivery/<?= $dbR['id']; ?>" onclick="return confirm('Are sure you want to delete this delivery region?')" class="btn btn-sm btn-danger"><i class="fa fa-trash-alt"></i></a>
                            </td>
                        </tr>
                        <?php $no++; } ?>
                   </table>
                </div>
            </div>
        </div>
        <?php
        }else if($_GET['opt'] == "add_delivery"){
        ?>
        <div class="col-md-9">
            <div class="card shadow">
                <div class="card-header">
                    <h2 class="lead text-dark mb-0">Tambah Area Pengiriman</h2>
                </div>
                <div class="card-body">
                    <form action="?page=settings" method="post">
                    <div class="form-group">
                        <label for="region">Wilayah</label>
                        <input
                            type="text"
                            class="form-control"
                            id="region"
                            name="cRegion"
                            autocomplete="off"
                            required
                            value=""
                        >
                    </div>
                    <div class="form-group">
                    <label for="price">Harga/Kg</label>
                        <input
                            type="text"
                            class="form-control input-money"
                            id="price"
                            name="cPrice"
                            autocomplete="off"
                            required
                            value=0
                        >
                        <small id="priceHelp" class="form-text text-muted"
                            >Contoh pengisian: 1,000.00</small
                        >
                    </div>
                    <button type="submit" name="add_delivery" class="btn btn-primary">Add</button>
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
