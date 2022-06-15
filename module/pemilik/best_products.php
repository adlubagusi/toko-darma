<?php
    $cTitle    = "Data Barang Terlaris";
    $dTglAwal  = (isset($_GET['tglawal'])) ? $_GET['tglawal'] : date("Y-m-01");
    $dTglAkhir = (isset($_GET['tglakhir'])) ? $_GET['tglakhir'] : date("Y-m-d");
?>
<!-- Begin Page Content -->
<div class="container-fluid">
	<!-- Page Heading -->
	<h1 class="h3 mb-2 text-gray-800 mb-4"><?=$cTitle?></h1>

	<!-- DataTales Example -->
	<div class="card shadow mb-4">
		<div class="card-header py-3">
            <div class="col-md-9">
                <input type="hidden" name="cTitle" id="cTitleOrder" value="<?=$cTitle?>">
                <button class="btn btn-primary" id="btnPrintBestProduct">
                    <i class="fa fa-print"></i>
                    Print
                </button>
            </div>
		</div>
		<div class="card-body">
            <?php 
            $dbData = mysqli_query($db,"select p.id AS productsId, p.title AS productsTitle, p.price AS productsPrice, p.stock AS productsStock, 
                                        p.date_submit AS productsDate, p.img AS productsImg, p.publish AS productsPublish, c.name AS categoriesName,p.transaction
                                        from products p
                                        left join categories c on p.category=c.id
                                        order by transaction desc");
            if(mysqli_num_rows($dbData) > 0){ 
            ?>
			<div class="table-responsive" id="tbl-bestproduct-pemilik">
				<table
					class="table table-bordered"
					id="dataTable"
					width="100%"
					cellspacing="0"
				>
					<thead>
                        <tr>
								<th>#</th>
								<th>Photo</th>
								<th>Title</th>
								<th>Price</th>
								<th>Stock</th>
								<th>Kategori</th>
								<th>Terjual</th>
							</tr>
					</thead>
					<tfoot></tfoot>
					<tbody class="data-content">
						<?php 
                        $no = 1;
                        while($dbRow = mysqli_fetch_array($dbData)){ 
                        ?>
						<tr>
							<td><?= $no; ?></td>
                            <td><img style="width: 50px" src="assets/images/product/<?= $dbRow['productsImg']; ?>"></td>
                            <td><?= $dbRow['productsTitle']; ?></td>
                            <td><?= $dbRow['productsPrice']; ?></td>
                            <td><?= $dbRow['productsStock']; ?></td>
                            <td><?= $dbRow['categoriesName']; ?></td>
                            <td><?= $dbRow['transaction']; ?> x</td>
                            
                        </tr>
                        <?php
                            $vaArray[] = $dbRow;
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
