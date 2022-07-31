<?php
    if(isset($_GET['opt'])){
		if($_GET['opt'] == "delete_other_img"){
			$cID  = $_GET['id'];
			$cIDProduk = $_GET['idinvoice'];
			$dbDt = mysqli_query($db,"select * from img_refund where id='$cID'");
			if($dbRw = mysqli_fetch_array($dbDt)){
				if(file_exists("./assets/images/refund/".$dbRw['img'])) unlink("./assets/images/product/".$dbRw['img']);
				mysqli_query($db,"delete from img_refund where id='$cID'");
				echo "<script>alert('Data Dihapus');</script>";
                echo "<script>window.location.href = '?page=refund&invoice=".$cIDProduk."';</script>";
			}else{
				echo "<script>alert('Data Tidak Ditemukan');</script>";
			}
		}else if($_GET['opt'] == "delete_other_video"){
			$cID  = $_GET['id'];
			$cIDProduk = $_GET['idinvoice'];
			$dbDt = mysqli_query($db,"select * from video_refund where id='$cID'");
			if($dbRw = mysqli_fetch_array($dbDt)){
				if(file_exists("./assets/video/refund/".$dbRw['video'])) unlink("./assets/video/product/".$dbRw['img']);
				mysqli_query($db,"delete from video_refund where id='$cID'");
				echo "<script>alert('Data Dihapus');</script>";
                echo "<script>window.location.href = '?page=refund&invoice=".$cIDProduk."';</script>";
			}else{
				echo "<script>alert('Data Tidak Ditemukan');</script>";
			}
		}
	}
    if(isset($_POST['add_img_refund'])){
		$cID = $_GET['id'];
		$cFileName	   = round(microtime(true)*1000);
		$cDir		   = "./assets/images/refund/";
        if(!is_dir($cDir)){
            @mkdir($cDir);
        }
        $dbDt = mysqli_query($db,"select * from img_refund where id_invoice='$cID'");
        if(mysqli_num_rows($dbDt) < 3){
            if (move_uploaded_file($_FILES["cImg"]["tmp_name"], $cDir.$cFileName)) {
                mysqli_query($db,"insert into img_refund (id_invoice,img) values ('$cID','$cFileName')");
                echo "<script>alert('Data Disimpan');</script>";
                echo "<script>window.location.href = '?page=refund&invoice=".$cID."';</script>";
            }else {
                echo "<script>alert('Gagal');</script>";
            }
        }else{
            echo "<script>alert('Max. File Upload 3x');</script>";
            echo "<script>window.location.href = '?page=refund&invoice=".$cID."';</script>";
        }
		
	}
    if(isset($_POST['add_video_refund'])){
		$cID = $_GET['id'];
		$cFileName	   = round(microtime(true)*1000);
		$cDir		   = "./assets/video/refund/";
        if(!is_dir($cDir)){
            @mkdir($cDir);
        }
        $dbDt = mysqli_query($db,"select * from video_refund where id_invoice='$cID'");
        if(mysqli_num_rows($dbDt) < 1){
            if (move_uploaded_file($_FILES["cVideo"]["tmp_name"], $cDir.$cFileName)) {
                mysqli_query($db,"insert into video_refund (id_invoice,video) values ('$cID','$cFileName')");
                echo "<script>alert('Data Disimpan');</script>";
                echo "<script>window.location.href = '?page=refund&invoice=".$cID."';</script>";
            }else {
                echo "<script>alert('Gagal');</script>";
            }
        }else{
            echo "<script>alert('Max. File Upload 1x');</script>";
            echo "<script>window.location.href = '?page=refund&invoice=".$cID."';</script>";
        }
		
	}
    if(isset($_POST['submit_refund'])){
        $cInvoice    = $_GET['invoice'];
        $cRefundText = $_POST['refundtext'];
        mysqli_query($db,"update invoice set status_refund='1',refund_text='$cRefundText' where invoice_code='$cInvoice'");
        echo "<script>alert('Barang Dikembalikan ke Penjual');</script>";
        echo "<script>window.location.href = 'index.php?page=history';</script>";
    }
	$cID = $_GET['invoice'];
    
    $dbData = mysqli_query($db,"select * from invoice where invoice_code='$cID'");
    $vaInvoice = mysqli_fetch_array($dbData);

	$dbImg   = mysqli_query($db,"select * from img_refund where id_invoice='$cID'");
	$dbVideo = mysqli_query($db,"select * from video_refund where id_invoice='$cID'");
?>
<div class="container-fluid">
	<!-- Page Heading -->
	<h1 class="h4 mb-2 text-gray-800 mb-4"></h1>
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <div class="card shadow mb-5">
                <div class="card-header py-3">
                    <a href="?page=history" class="btn btn-sm btn-primary"><i class="fa fa-chevron-left"></i> Back</a>
                    <h1 class="h3 mb-2 text-gray-800 mb-2" style="float:right">Code/Invoice = <?= $vaInvoice['invoice_code']; ?></h1>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th>#</th>
                            <th>Nama Barang</th>
                            <th>Jml</th>
                            <th>Info</th>
                            <th>Harga</th>
                            <th>Total</th>
                            <th>Aksi</th>
                        <?php 
                        $no=1; 
                        $dbOrder = mysqli_query($db,"select * from transaction where id_invoice='$cID'");
                        while($data = mysqli_fetch_array($dbOrder)){ ?>
                        </tr>
                            <td><?= $no; ?></td>
                            <td><?= $data['product_name']; ?></td>
                            <td class="text-center"><?= $data['qty']; ?></td>
                            <?php if($data['ket'] == ""){ ?>
                                <td>-</td>
                            <?php }else{ ?>
                                <td><?= $data['ket']; ?></td>
                            <?php } ?>
                            <td>Rp <?= number2String($data['price']); ?></td>
                            <?php $total = $data['price'] * $data['qty']; ?>
                            <td>Rp <?= number2String($total); ?></td>
                            <td>
                                <a href="index.php?p=<?= $data['link']; ?>" target="_blank" class="btn btn-sm btn-success"><i class="fa fa-search"></i></a>
                            </td>
                        <tr>
                        <?php 
                            $no++; 
                            }
                        ?>
                        </tr>
                    </table>
                    <div class="col-md-6">
                        <table class="table table-borderless table-sm">
                            <tr>
                                <th>Total Harga</th>
                                <th>Rp <?= number2String($vaInvoice['total_price']); ?></script></th>
                            </tr>
                            <tr>
                                <th>Biaya Pengiriman</th>
                                <th>Rp <?= number2String($vaInvoice['ongkir']); ?></th>
                            </tr>
                            <tr>
                                <th>Total</th>
                                <th>Rp <?= number2String($vaInvoice['total_all']); ?></th>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-1">
        </div>
        <div class="col-md-5">
            <div class="card shadow mb-4">
                <div class="card-header">
                    <p class="lead mb-0 pb-0">Upload Foto Barang</p>
                </div>
                <div class="card-body">
                    <form action="?page=refund&opt=add_img&id=<?= $cID; ?>" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <input type="file" name="cImg" id="img" class="form-control" accept="image/x-png,image/gif,image/jpeg"  required>
                        </div>
                        <input type="hidden" name="help" value="1">
                        <button name="add_img_refund" class="btn btn-sm btn-info" type="submit">Tambah</button>
                    </form>
                </div>
            </div>
            <div class="card shadow mb-4">
                <div class="card-header">
                    <p class="lead mb-0 pb-0">Bukti Barang (Max 3)</p>
                </div>
                <div class="card-body">
                    <?php if(mysqli_num_rows($dbImg) > 0){ ?>
                    <div class="row">
                        <?php while($dbRImg = mysqli_fetch_array($dbImg)){ ?>
                            <div class="col-md-6 mb-3">
                                <img src="assets/images/refund/<?= $dbRImg['img'] ?>" width="100%">
                                <a href="?page=refund&opt=delete_other_img&id=<?= $dbRImg['id']; ?>&idinvoice=<?= $cID;?>" class="btn btn-block btn-sm btn-danger mt-1" onclick="return confirm('Apakah Anda Yakin?')">Delete</a>
                            </div>
                        <?php } ?>
                    </div>
                    <?php }else{ ?>
                        <div class="alert alert-warning">Belum ada foto</div>
                    <?php } ?>
                </div>
            </div>

            <div class="card shadow mb-4">
                <div class="card-header">
                    <p class="lead mb-0 pb-0">Upload Video (Opsional)</p>
                </div>
                <div class="card-body">
                    <form action="?page=refund&opt=add_video&id=<?= $cID; ?>" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <input type="file" name="cVideo" id="video" class="form-control" accept="video/mp4,video/x-m4v,video/*">
                        </div>
                        <input type="hidden" name="help" value="1">
                        <button name="add_video_refund" class="btn btn-sm btn-info" type="submit">Tambah</button>
                    </form>
                </div>
            </div>
            <div class="card shadow mb-4">
                <div class="card-header">
                    <p class="lead mb-0 pb-0">Bukti Video (Max 1)</p>
                </div>
                <div class="card-body">
                    <?php if(mysqli_num_rows($dbVideo) > 0){ ?>
                    <div class="row">
                        <?php while($dbRVideo = mysqli_fetch_array($dbVideo)){ ?>
                            <div class="col-md-6 mb-3">
                                <video src="assets/video/refund/<?= $dbRVideo['video'] ?>" width="100%" controls></video>
                                <a href="?page=refund&opt=delete_other_video&id=<?= $dbRVideo['id']; ?>&idinvoice=<?= $cID;?>" class="btn btn-block btn-sm btn-danger mt-1" onclick="return confirm('Apakah Anda Yakin?')">Delete</a>
                            </div>
                        <?php } ?>
                    </div>
                    <?php }else{ ?>
                        <div class="alert alert-warning">Belum ada video</div>
                    <?php } ?>
                </div>
            </div>

        </div>
        <div class="col-md-5">
            <div class="card shadow mb-4">
                <div class="card-header">
                    <p class="lead mb-0 pb-0">Form Pengembalian Barang</p>
                </div>
                <div class="card-body">
                    <form action="?page=refund&invoice=<?= $cID; ?>" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="name">Atas Nama</label>
                            <input type="text" id="name" autocomplete="off" class="form-control" readonly name="name" value="<?= $_SESSION['name']?>">
                        </div>
                        <div class="form-group">
                            <label for="name">Email</label>
                            <input type="text" id="name" autocomplete="off" class="form-control" readonly name="enail" value="<?= $_SESSION['email']?>">
                        </div>
                        <div class="form-group">
                            <label for="name">Alasan Pengembalian</label>
                            <textarea name="refundtext" id="refundtext" cols="30" rows="2" class="form-control"></textarea>
                        </div>
                        <button name="submit_refund" class="btn btn-warning btn-block" type="submit">Kirimkan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>