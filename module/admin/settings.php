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
    if(isset($_GET['opt'])){
		if($_GET['opt'] == "delete_delivery"){
			$cID  = $_GET['id'];
			$dbDt = mysqli_query($db,"select * from region where id='$cID'");
			if($dbRw = mysqli_fetch_array($dbDt)){
				mysqli_query($db,"delete from region where id='$cID'");
				echo "<script>alert('Data Dihapus');</script>";
				echo "<script>window.location.href = 'admin.php?page=settings&opt=delivery';</script>";
			}else{
				echo "<script>alert('Data Tidak Ditemukan');</script>";
			}
		}
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
                        <a href="?page=settings&opt=delivery" class="list-group-item list-group-item-action">Area Pengiriman</a>
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
                                <a href="?page=settings&opt=delete_delivery&id=<?= $dbR['id']; ?>" onclick="return confirm('Apakah Anda Yakin?')" class="btn btn-sm btn-danger"><i class="fa fa-trash-alt"></i></a>
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
