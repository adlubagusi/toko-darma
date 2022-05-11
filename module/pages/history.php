<?php
if(isset($_GET['action'])){
    if($_GET['action'] == "upload_file"){
        $cInvoice = $_POST['cInvoice'];
        $dbData = mysqli_query($db,"select * from invoice where invoice_code='$cInvoice'");
        if($dbRow = mysqli_fetch_array($dbData)){
            $cImg 		  	= round(microtime(true)*1000) ;
            $cDir		  	= "./assets/bukti_transfer/".$cImg;
            if (move_uploaded_file($_FILES["cBuktiTransfer"]["tmp_name"], $cDir)) {
                mysqli_query($db,"update invoice set bukti_transfer='$cImg' where invoice_code='$cInvoice'");
			    echo "<script>alert('File berhasil diupload! Menunggu konfirmasi admin..');</script>";
    			echo "<script>window.location.href = 'index.php?page=history';</script>";
            }else {
                echo "<script>alert('Gagal');</script>";
            }
        }
    }
}

if(isset($_GET['invoice']) && $_GET['invoice'] <> ""){
    $cInvoice = $_GET['invoice'];
    $dbData = mysqli_query($db,"select * from invoice where invoice_code='$cInvoice'");
    $vaInvoice = mysqli_fetch_array($dbData);

    $dbRegion = mysqli_query($db,"select * from region where id='{$vaInvoice['region']}'");
    $vaRegion = mysqli_fetch_array($dbRegion);
?>
<div class="container" style="margin-top:20px;">
	<!-- DataTales Example -->
	<div class="card shadow mb-4">
		<div class="card-header py-3">
            <a href="?page=history" class="btn btn-sm btn-primary"><i class="fa fa-chevron-left"></i> Back</a>
            <h1 class="h3 mb-2 text-gray-800 mb-2" style="float:right">Code/Invoice = <?= $vaInvoice['invoice_code']; ?></h1>
            <!-- <a href="administrator/print_detail_order/<?= $vaInvoice['invoice_code']; ?>" class="btn btn-info btn-sm float-right">Print</a> -->
		</div>
		<div class="card-body">
            <h3 class="lead"> Data Alamat</h3>
            <hr>
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-sm table-borderless">
                        <tr>
                            <td>Nama Penerima</td>
                            <td><?= $vaInvoice['name']; ?></td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td><?= $vaInvoice['email']; ?></td>
                        </tr>
                        <tr>
                            <td>Telepon</td>
                            <td><?= $vaInvoice['telp']; ?></td>
                        </tr>
                        <tr>
                            <td>Wilayah</td>
                            <td><?= $vaRegion['region']; ?></td>
                        </tr>
                        <tr>
                            <td>Alamat Lengkap</td>
                            <td><?= $vaInvoice['address']; ?></td>
                        </tr>
                        <tr>
                            <td>Status Pembayaran</td>
                            <?php if($vaInvoice['status_payment'] == 1){ ?>
                                <td><span class="badge badge-success">Lunas</span></td>
                            <?php
                                }else{ 
                                    if($vaInvoice['bukti_transfer'] <> ""){
                            ?>
								<td><span class="badge badge-warning">Menunggu Konfirmasi Admin</span></td>
                            <?php
                                    }else{
                            ?>
								<td><span class="badge badge-danger">Menunggu Pembayaran</span></td>
                            <?php
                                    }
                                } 
                            ?>
                        </tr>
                        <tr>
                            <td>Status Pengiriman</td>
                            <?php if($vaInvoice['status_delivery'] == 2){ ?>
                                <td><span class="badge badge-success">Dikirim</span></td>
                            <?php
                                }else if($vaInvoice['status_delivery'] == 1){
                            ?>
                                <td><span class="badge badge-warning">Dikemas</span></td>
                            <?php        
                                }else{ ?>
                                <td><span class="badge badge-danger">Belum Dikirim</span></td>
                            <?php } ?>
                        </tr>
                    </table>
                </div>
            </div>
            <hr>
            <?php
            if(!$vaInvoice['status_payment']){
            ?>
            <form class="form-inline" action="?page=history&action=upload_file" method="post" enctype="multipart/form-data">
                <div class="form-group mx-sm-3 mb-2">
                    <label for="inputPassword2" class="">Upload Bukti Transfer&nbsp;</label>
                    <input type="file" class="form-control" name="cBuktiTransfer">
                    <input type="hidden" name="cInvoice" value="<?= $vaInvoice['invoice_code'];?>">
                </div>
                <button type="submit" class="btn btn-primary mb-2">Submit</button>
            </form>
            <?php
            }
            ?>
		</div>
	</div>
    <div class="card shadow mb-5">
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
                $dbOrder = mysqli_query($db,"select * from transaction where id_invoice='$cInvoice'");
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
                        <a href="index.php?p=<?= $data['link']; ?>" target="_blank" class="btn btn-sm btn-success"><i class="fa fa-eye"></i></a>
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
<?php    
}else{
?>
<div class="title">
    <h2>Riwayat Pembelian:</h2>
</div>
<div class="wrapper" style="width:auto;">
    <div class="row">
        <div class="col-md-2">
        </div>
        <div class="col-md-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                </div>
                <div class="card-body">
                    <?php 
                    $cEmail = $_SESSION['email'];
                    $dbData = mysqli_query($db,"select * from invoice where email='$cEmail' order by id desc");
                    if(mysqli_num_rows($dbData) > 0){ 
                    ?>
                    <div class="table-responsive">
                        <table
                            class="table table-bordered"
                            id="dataTable"
                            width="100%"
                            cellspacing="0"
                        >
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Invoice/Tagihan</th>
                                    <th>Nama</th>
                                    <th>Total Pesanan</th>
                                    <th>Tanggal</th>
                                    <th>Status Pembayaran</th>
                                    <th>Status Pengiriman</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tfoot></tfoot>
                            <tbody class="data-content">
                                <?php 
                                $no = 1;
                                while($data = mysqli_fetch_array($dbData)){ 
                                ?>
                                <tr>
                                    <td><?= $no; ?></td>
                                    <td><?= $data['invoice_code']; ?></td>
                                    <td><?= $data['name']; ?></td>
                                    <td>Rp <?= number2String($data['total_all']); ?></td>
                                    <td><?= $data['date_input']; ?></td>							
                                    <?php if($data['status_payment'] == 1){ ?>
                                        <td>Lunas</td>
                                    <?php
                                        }else{ ?>
                                        <td>Belum Lunas</td>
                                    <?php } ?>
                                    <?php if($data['status_delivery'] == 2){ ?>
                                        <td>Dikirim</td>
                                    <?php
                                        }else if($data['status_delivery'] == 1){
                                    ?>
                                        <td>Dikemas</td>
                                    <?php        
                                        }else{ ?>
                                        <td>Belum Diproses</td>
                                    <?php } ?>
                                    <td>
                                        <a href="?page=history&invoice=<?= $data['invoice_code']; ?>" class="btn btn-sm btn-info"><i class="fa fa-search"></i></a>
                                    </td>
                                </tr>
                                <?php
                                    $no++;
                                } 
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <?php 
                    }else{ 
                    ?>
                    <div class="alert alert-warning" role="alert">
                    Oops, the order is still empty.
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
}
?>