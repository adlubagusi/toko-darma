<script>
	function convertToNumber(string){
		let number = string.replace(',', '').replace('.','');
		number = parseInt(number);
		number = number/100;
		const formatter = new Intl.NumberFormat('en-US', {
			minimumFractionDigits: 2
		})
		number = formatter.format(number);
		return number;
	}
</script>
<?php
if(isset($_POST['kirim_pesanan'])){
    $cInvoice  = $_GET['invoice'];
    $cNoResi   = $_POST['cNoResi'];
    $cExpedisi = $_POST['cExpedisi'];
    mysqli_query($db,"update invoice set no_resi='$cNoResi',expedisi='$cExpedisi',status_delivery='2' where invoice_code='$cInvoice'");
    echo "<script>alert('Pesanan Sudah Dikirim');</script>";
    echo "<script>window.location.href = 'admin.php?page=orders';</script>";
}
if(isset($_GET['opt'])){
    if($_GET['opt'] == "proses"){
        $cInvoice = $_GET['invoice'];
        mysqli_query($db,"update invoice set status_payment='1',status_delivery='1' where invoice_code='$cInvoice'");
        echo "<script>alert('Data Disimpan');</script>";
        echo "<script>window.location.href = 'admin.php?page=orders';</script>";
    }
}

if(isset($_GET['invoice']) && $_GET['invoice'] <> ""){
    $cInvoice = $_GET['invoice'];
    $dbData = mysqli_query($db,"select * from invoice where invoice_code='$cInvoice'");
    $vaInvoice = mysqli_fetch_array($dbData);

    $dbRegion = mysqli_query($db,"select * from region where id='{$vaInvoice['region']}'");
    $vaRegion = mysqli_fetch_array($dbRegion);
?>
<!-- Begin Page Content -->
<div class="container-fluid">
	<!-- Page Heading -->
	<h1 class="h3 mb-2 text-gray-800 mb-2">Code/Invoice = <?= $vaInvoice['invoice_code']; ?></h1>
    <?php if($vaInvoice['status_payment'] == 1 && $vaInvoice['status_delivery'] == 3){ ?>
        <h3 class="text-success">Transaksi selesai</h3>
    <?php } ?>

	<!-- DataTales Example -->
	<div class="card shadow mb-4">
		<div class="card-header py-3">
            <a href="?page=orders" class="btn btn-sm btn-primary"><i class="fa fa-chevron-left"></i> Back</a>
            <!-- <a href="administrator/print_detail_order/<?= $vaInvoice['invoice_code']; ?>" class="btn btn-info btn-sm float-right">Print</a> -->
		</div>
		<div class="card-body">
            <h3 class="lead"> Data Pesanan</h3>
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
                            <?php 
                                if($vaInvoice['status_delivery'] == 3){
                            ?>
                                <td><span class="badge badge-success">Pesanan Diterima</span></td>
                            <?php
                                }else if($vaInvoice['status_delivery'] == 2){ 
                            ?>
                                <td><span class="badge badge-info">Dikirim</span></td>
                            <?php
                                }else if($vaInvoice['status_delivery'] == 1){
                            ?>
                                <td><span class="badge badge-warning">Dikemas</span></td>
                            <?php        
                                }else{ ?>
                                <td><span class="badge badge-danger">Belum Dikirim</span></td>
                            <?php } ?>
                        </tr>
                        <?php
                            if($vaInvoice['status_delivery'] >= 2){
                        ?>
                        <tr>
                            <td>No. Resi</td>
                            <td><?=$vaInvoice['no_resi']?></td>
                        </tr>
                        <tr>
                            <td>Expedisi</td>
                            <td><?=$vaInvoice['expedisi']?></td>
                        </tr>
                        <?php       
                            }
                        ?>
                    </table>
                </div>
            </div>
            <hr>
            <?php
                if($vaInvoice['bukti_transfer'] <> "" && is_file("assets/bukti_transfer/".$vaInvoice['bukti_transfer'])){
            ?>
            <h3 class="lead"> Bukti Transfer <a href="assets/bukti_transfer/<?=$vaInvoice['bukti_transfer']?>" target="_blank"  class="btn btn-sm btn-info"><i class="fa fa-search"></i></a> </h3>
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
            <hr>
            <?php if($vaInvoice['status_payment'] == 0){ ?>
                <a href="?page=orders&opt=proses&invoice=<?= $vaInvoice['invoice_code']; ?>" onclick="return confirm('Anda sudah menerima pembayaran dan akan memproses pesanan?');" class="btn btn-info btn-sm">Proses</a>
            <?php }else if($vaInvoice['status_payment'] == 1 && $vaInvoice['status_delivery'] == 1){?>
                <a
                    href="#"
                    class="btn btn-primary btn-sm"
                    data-toggle="modal"
                    data-target="#kirimPesanan"
                    >Kirim Pesanan</a
                >
            <?php } ?>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
<!-- Modal Kirim Pesanan -->
<div
	class="modal fade"
	id="kirimPesanan"
	tabindex="-1"
	role="dialog"
	aria-labelledby="exampleModalLabel"
	aria-hidden="true"
>
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Anda Akan Mengirimkan Pesanan?</h5>
				<button
					type="button"
					class="close"
					data-dismiss="modal"
					aria-label="Close"
				>
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form
					action=""
					method="post"
				>
					<div class="form-group">
						<label for="name">No. Resi</label>
						<input
							type="text"
							class="form-control"
							id="cNoResi"
							name="cNoResi"
							autocomplete="off"
							required
						/>
					</div>
                    <div class="form-group">
						<label for="name">Expedisi</label>
						<input
							type="text"
							class="form-control"
							id="cExpedisi"
							name="cExpedisi"
							autocomplete="off"
							required
						/>
					</div>
					<button type="submit" name="kirim_pesanan" class="btn btn-success">
					Submit
					</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">
					Batal
					</button>
				</form>
			</div>
		</div>
	</div>
</div>
<?php
}else{
?>
<!-- Begin Page Content -->
<div class="container-fluid">
	<!-- Page Heading -->
	<h1 class="h3 mb-2 text-gray-800 mb-4">Data Pesanan</h1>

	<!-- DataTales Example -->
	<div class="card shadow mb-4">
		<div class="card-header py-3">
		</div>
		<div class="card-body">
            <?php 
            $dbData = mysqli_query($db,"select * from invoice order by id desc");
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
								<td><span class="badge badge-success">Lunas</span></td>
							<?php
                                }else{ 
                                    if($data['bukti_transfer'] <> ""){
                            ?>
								<td><span class="badge badge-info">Bukti Transfer Tersedia</span></td>
                            <?php
                                    }else{
                            ?>
								<td><span class="badge badge-danger">Menunggu Pembayaran</span></td>
                            <?php
                                    }
                                } 
                            ?>
                            <?php 
                                if($data['status_delivery'] == 3){ 
                            ?>
                                <td><span class="badge badge-success">Pesanan Diterima</span></td>
                            <?php 
                                }elseif($data['status_delivery'] == 2){ 
                            ?>
                                <td><span class="badge badge-info">Dikirim</span></td>
                            <?php
                                }else if($data['status_delivery'] == 1){
                            ?>
                                <td><span class="badge badge-warning">Dikemas</span></td>
                            <?php        
                                }else{ ?>
                                <td><span class="badge badge-danger">Belum Dikirim</span></td>
                            <?php } ?>
                            <td>
                                <a href="?page=orders&invoice=<?= $data['invoice_code']; ?>" class="btn btn-sm btn-info"><i class="fa fa-eye"></i></a>
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
<!-- /.container-fluid -->
<?php
}
?>
