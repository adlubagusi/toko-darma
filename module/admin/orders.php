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
    <?php if($vaInvoice['status'] == 1){ ?>
        <h3 class="text-success">Transaksi selesai</h3>
    <?php } ?>

	<!-- DataTales Example -->
	<div class="card shadow mb-4">
		<div class="card-header py-3">
            <a href="administrator/orders" class="btn btn-sm btn-primary"><i class="fa fa-chevron-left"></i> Back</a>
            <a href="administrator/print_detail_order/<?= $vaInvoice['invoice_code']; ?>" class="btn btn-info btn-sm float-right">Print</a>
		</div>
		<div class="card-body">
            <h3 class="lead">Address Data</h3>
            <hr>
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-sm table-borderless">
                        <tr>
                            <td>Recipient's Name</td>
                            <td><?= $vaInvoice['name']; ?></td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td><?= $vaInvoice['email']; ?></td>
                        </tr>
                        <tr>
                            <td>Telephone</td>
                            <td><?= $vaInvoice['telp']; ?></td>
                        </tr>
                        <tr>
                            <td>Region</td>
                            <td><?= $vaRegion['region']; ?></td>
                        </tr>
                        <tr>
                            <td>Address</td>
                            <td><?= $vaInvoice['address']; ?></td>
                        </tr>
                    </table>
                </div>
            </div>
		</div>
	</div>
    <div class="card shadow mb-5">
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th>#</th>
                    <th>Product name</th>
                    <th>Qty</th>
                    <th>Info</th>
                    <th>Price</th>
                    <th>Total</th>
                    <th>Action</th>
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
                        <th>Total Price</th>
                        <th>Rp <?= number2String($vaInvoice['total_price']); ?></script></th>
                    </tr>
                    <tr>
                        <th>Shipping cost</th>
                        <th>Rp <?= number2String($vaInvoice['ongkir']); ?></th>
                    </tr>
                    <tr>
                        <th>Total</th>
                        <th>Rp <?= number2String($vaInvoice['total_all']); ?></th>
                    </tr>
                </table>
            </div>
            <hr>
            <?php if($vaInvoice['status'] == 0){ ?>
                <a href="administrator/finish_orderan/<?= $vaInvoice['invoice_code']; ?>" onclick="return confirm('Yakin ingin menyelesaikan pesanan?');" class="btn btn-info btn-sm">Done</a>
            <?php } ?>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
<?php
}else{
?>
<!-- Begin Page Content -->
<div class="container-fluid">
	<!-- Page Heading -->
	<h1 class="h3 mb-2 text-gray-800 mb-4">Order Data</h1>

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
							<th>Code/Invoice</th>
							<th>Name</th>
							<th>Total Orders</th>
                            <th>Order Date</th>
                            <th>Status</th>
                            <th>Action</th>
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
                            <?php if($data['status'] == 1){ ?>
								<td>Done</td>
							<?php }else{ ?>
								<td>Not finished</td>
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
