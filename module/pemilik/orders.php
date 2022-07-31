<?php
    $cTitle    = ($_GET['page'] == "order_proccess") ? "Diproses" : "Dikirim" ;
    $dTglAwal  = (isset($_GET['dTglAwal'])) ? $_GET['dTglAwal'] : date("Y-m-01");
    $dTglAkhir = (isset($_GET['dTglAkhir'])) ? $_GET['dTglAkhir'] : date("Y-m-d");
    $cDisplayTable = isset($_GET['lPreview']) ? "block" : "none";
    $cDisplayPrint = $cDisplayTable;
?>
<!-- Begin Page Content -->
<div class="container-fluid">
	<!-- Page Heading -->
	<h1 class="h3 mb-2 text-gray-800 mb-4">Daftar Pesanan</h1>

	<!-- DataTales Example -->
	<div class="card shadow mb-4">
		<div class="card-header py-3">
            <div class="col-md-12">
            <form action="" method="get">    
                <input type="hidden" name="page" value="orders">
                <div class="row">
                    <div class="col-md-3">
                        <label for="">Antara Tanggal</label> 
                    </div>
                    <div class="col-md-3">
                        <input type="date" name="dTglAwal" id="dTglAwal" class="form-control" value="<?=$dTglAwal?>">
                    </div>
                    <div class="col-md-1" style="text-align:center;">
                    s/d 
                    </div>
                    <div class="col-md-3">
                        <input type="date" name="dTglAkhir" id="dTglAkhir" class="form-control" value="<?=$dTglAkhir?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <label for=""></label> 
                    </div>
                    <div class="col-md-3">
                        <label>
                            <input type="checkbox" name="optAll" id="optAll" value="1" > Tampilkan semua
                        </label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <label for="">Status Pembayaran</label> 
                    </div>
                    <div class="col-md-2">
                        <label>
                            <input type="checkbox" name="optPayment0" id="optPayment0" value="1" > Belum Bayar
                        </label>
                    </div>
                    <div class="col-md-2">
                        <label>
                            <input type="checkbox" name="optPayment1" id="optPayment1" value="1" > Lunas
                        </label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <label for="">Status Pengiriman</label> 
                    </div>
                    <div class="col-md-2">
                        <label>
                            <input type="checkbox" name="optDelivery0" id="optDelivery0" value="1" > Belum Dikirim
                        </label>
                    </div>
                    <div class="col-md-2">
                        <label>
                            <input type="checkbox" name="optDelivery1" id="optDelivery1" value="1" > Dikemas
                        </label>
                    </div>
                    <div class="col-md-2">
                        <label>
                            <input type="checkbox" name="optDelivery2" id="optDelivery2" value="1" > Dikirim
                        </label>
                    </div>
                    <div class="col-md-2">
                        <label>
                            <input type="checkbox" name="optDelivery3" id="optDelivery3" value="1" > Diterima
                        </label>
                    </div>
                    <div class="col-md-3"></div>
                    <div class="col-md-2">
                        <label>
                            <input type="checkbox" name="optRefund1" id="optRefund1" value="1" > Barang Dikembalikan
                        </label>
                    </div>
                    <div class="col-md-2">
                        <label>
                            <input type="checkbox" name="optRefund2" id="optRefund2" value="1" > Refund
                        </label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <input type="hidden" name="lPreview" value="1">
                        <button class="btn btn-info btn-block" id="btnPreview" type="submit">
                            Preview
                        </button>
                    </div>
                    <div class="col-md-2" style="display:<?=$cDisplayPrint?>;">
                        <input type="hidden" name="cTitle" id="cTitleOrder" value="<?=$cTitle?>">
                        <button class="btn btn-primary btn-block" id="btnPrint" type="button">
                            <i class="fa fa-print"></i>
                            Print
                        </button>
                    </div>
                </div>
            </form>
            </div>
		</div>
		<div class="card-body">
            <?php 
            if(!isset($_GET['lPreview'])) exit;
            extract($_GET);
            $dTglAkhir = $dTglAkhir." 23:59:00";
            //$cWhere = "where status_payment='1' and status_delivery='1'";
            //if($_GET['page'] == "order_send") $cWhere = "where status_payment='1' and status_delivery='2'";
            $cWhere = "where date_input >='$dTglAwal' and date_input <= '$dTglAkhir'";
            $dbData = mysqli_query($db,"select * from invoice $cWhere order by id desc");
            if(mysqli_num_rows($dbData) > 0){ 
            ?>
			<div class="table-responsive" id="tbl-orders-pemilik" style="display:<?=$cDisplayTable?>">
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
							<th>Total Pesanan(Rp)</th>
                            <th>Tanggal</th>
                            <th>Status Pembayaran</th>
                            <th>Status Pengiriman</th>
                            <!-- <th>Aksi</th> -->
						</tr>
					</thead>
					<tfoot></tfoot>
					<tbody class="data-content">
                    <?php 
                    $no = 1;
                    $vaArray = [];
                    while($data = mysqli_fetch_array($dbData)){ 
                        $lMasuk = false;
                        if(isset($optPayment0) && $data['status_payment'] == 0) $lMasuk = true;
                        if(isset($optPayment1) && $data['status_payment'] == 1) $lMasuk = true;
                        if(isset($optDelivery0) && $data['status_delivery'] == 0) $lMasuk = true;
                        if(isset($optDelivery1) && $data['status_delivery'] == 1) $lMasuk = true;
                        if(isset($optDelivery2) && $data['status_delivery'] == 2 && $data['status_refund'] == 0) $lMasuk = true;
                        if(isset($optDelivery3) && $data['status_delivery'] == 3) $lMasuk = true;
                        if(isset($optRefund1) && $data['status_refund'] == 1) $lMasuk = true;
                        if(isset($optRefund2) && $data['status_refund'] == 2) $lMasuk = true;
                        if(isset($optAll)) $lMasuk = true;
                        if($lMasuk){  
                    ?>
						<tr>
							<td><?= $no; ?></td>
                            <td><?= $data['invoice_code']; ?></td>
                            <td><?= $data['name']; ?></td>
                            <td><?= number2String($data['total_all']); ?></td>
                            <td><?= date("d-m-Y H:i:s",strtotime($data['date_input'])); ?></td>							
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
                            if($data['status_refund'] > 0){
                                if($data['status_refund'] == 1){
                            ?>
                                <td><span class="badge badge-warning">Barang Dikembalikan</span></td>
                            <?php
                                }else{
                            ?>
                                <td><span class="badge badge-success">Refund</span></td>
                            <?php
                                }
                            }else{
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
                            <?php 
                                } 
                            }
                            ?>
                            <!-- <td>
                                <a href="?page=orders&invoice=<?= $data['invoice_code']; ?>" class="btn btn-sm btn-info"><i class="fa fa-eye"></i></a>
                            </td> -->
                        </tr>
                    <?php
                            $vaArray[] = $data;
                            $no++;
                        }
                    }
                    if(count($vaArray) > 0){
                        $_SESSION['vaArray'] = array();
                        $_SESSION['vaArray'] = $vaArray;
                    } 
                    
                    ?>
					</tbody>
				</table>
			</div>
			<?php 
            }else{ 
            ?>
			<div class="alert alert-warning" role="alert">
			Data Tidak Ditemukan.
			</div>
            <?php } ?>
		</div>
	</div>
</div>
<!-- /.container-fluid -->
