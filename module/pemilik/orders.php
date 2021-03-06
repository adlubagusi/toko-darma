<?php
    $cTitle    = ($_GET['page'] == "order_proccess") ? "Diproses" : "Dikirim" ;
    $dTglAwal  = (isset($_GET['tglawal'])) ? $_GET['tglawal'] : date("Y-m-01");
    $dTglAkhir = (isset($_GET['tglakhir'])) ? $_GET['tglakhir'] : date("Y-m-d");
    $cDisplayTable = isset($_GET['tglakhir']) ? "block" : "none";
    $cDisplayPrint = $cDisplayTable;
?>
<!-- Begin Page Content -->
<div class="container-fluid">
	<!-- Page Heading -->
	<h1 class="h3 mb-2 text-gray-800 mb-4">Data Pesanan <?=$cTitle?></h1>

	<!-- DataTales Example -->
	<div class="card shadow mb-4">
		<div class="card-header py-3">
            <div class="col-md-9">
                <label for="">Antara Tanggal</label> 
                <div class="row">
                    <div class="col-md-3">
                        <input type="date" name="dTglAwal" id="dTglAwal" class="form-control" value="<?=$dTglAwal?>">
                    </div>
                    <div class="col-md-1" style="text-align:center;">
                    s/d 
                    </div>
                    <div class="col-md-3">
                        <input type="date" name="dTglAkhir" id="dTglAkhir" class="form-control" value="<?=$dTglAkhir?>">
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-info btn-block" id="btnPreview">
                            Preview
                        </button>
                    </div>
                    <div class="col-md-2" style="display:<?=$cDisplayPrint?>;">
                        <input type="hidden" name="cTitle" id="cTitleOrder" value="<?=$cTitle?>">
                        <button class="btn btn-primary btn-block" id="btnPrint">
                            <i class="fa fa-print"></i>
                            Print
                        </button>
                    </div>
                </div>
            </div>
		</div>
		<div class="card-body">
            <?php 
            $dTglAkhir = $dTglAkhir." 23:59:00";
            $cWhere = "where status_payment='1' and status_delivery='1'";
            if($_GET['page'] == "order_send") $cWhere = "where status_payment='1' and status_delivery='2'";
            $cWhere .= " and date_input >='$dTglAwal' and date_input <= '$dTglAkhir'";
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
							<th>Total Pesanan</th>
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
                            <!-- <td>
                                <a href="?page=orders&invoice=<?= $data['invoice_code']; ?>" class="btn btn-sm btn-info"><i class="fa fa-eye"></i></a>
                            </td> -->
                        </tr>
                        <?php
                            $vaArray[] = $data;
                            $no++;
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
