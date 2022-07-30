<?php
    $cTitle    = "Data Penjualan";
    $dTglAwal  = (isset($_GET['tglawal'])) ? $_GET['tglawal'] : date("Y-m-01");
    $dTglAkhir = (isset($_GET['tglakhir'])) ? $_GET['tglakhir'] : date("Y-m-d");
    $cDisplayTable = isset($_GET['tglakhir']) ? "block" : "none";
    $cDisplayPrint = $cDisplayTable;
?>
<!-- Begin Page Content -->
<div class="container-fluid">
	<!-- Page Heading -->
	<h1 class="h3 mb-2 text-gray-800 mb-4">Laba/Rugi Penjualan</h1>

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
                        <button class="btn btn-primary btn-block" id="btnPrintSales">
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
            $cWhere = "where i.status_payment='1' and i.status_delivery='3'";
            $cWhere .= " and i.date_input >='$dTglAwal' and i.date_input <= '$dTglAkhir'";
            $dbData = mysqli_query($db,"select t.id_invoice,t.product_name,i.date_input,p.purchase_price,t.price
                                   from transaction t 
                                   left join invoice i on i.invoice_code=t.id_invoice 
                                   left join products p on p.link=t.link
                                   $cWhere order by t.id");
            echo mysqli_error($db);                       
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
                            <th>Barang</th>
                            <th>Tanggal</th>
							<th>Harga Beli (Rp)</th>
							<th>Harga Jual (Rp)</th>
							<th>Laba/Rugi (Rp)</th>
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
                            <td><?= $data['id_invoice']; ?></td>
                            <td><?= $data['product_name']; ?></td>
                            <td><?= date("d-m-Y H:i:s",strtotime($data['date_input'])); ?></td>
                            <td><?= number2String($data['purchase_price']); ?></td>
                            <td><?= number2String($data['price']); ?></td>
                            <td><?= number2String($data['price']-$data['purchase_price']); ?></td>
                            
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
