<?php
include 'include/rajaongkir.php';
$rajaongkir = new Rajaongkir();
	if(isset($_POST['add_product'])){
		$cTitle 		= $_POST['cTitle'];
		$nPrice 		= string2Number($_POST['nPrice']);
		$nPurchasePrice = string2Number($_POST['nPurchasePrice']);
		$nStock 	    = $_POST['nStock'];
		$cCategory 		= $_POST['cCategory'];
		$cCondition 	= $_POST['cCondition'];
		$cStatus 	  	= $_POST['cStatus'];
		$nWeight      	= $_POST['nWeight'];
		$cDescription 	= $_POST['cDescription'];
		$cProvince   	= $_POST['cProvince'];
		$cCity   		= $_POST['cCity'];

        $cLink			= textToLink($cTitle);
		$cImg 		  	= round(microtime(true)*1000) ;//$_FILES['cImg'];
		$cDir		  	= "./assets/images/product/".$cImg;
		$dDate			= date("Y-m-d H:i:s");
		if (move_uploaded_file($_FILES["cImg"]["tmp_name"], $cDir)) {
			mysqli_query($db,"insert into products (title,purchase_price,price,stock,category,condit,weight,img,description,date_submit,publish,link,province,city) 
						values ('$cTitle','$nPurchasePrice','$nPrice','$nStock','$cCategory','$cCondition','$nWeight','$cImg','$cDescription','$dDate','$cStatus','$cLink','$cProvince','$cCity')");
			echo "<script>alert('Data Disimpan');</script>";
			echo "<script>window.location.href = 'admin.php?page=products';</script>";
		}else {
			echo "<script>alert('Gagal');</script>";
		}
	}

	if(isset($_POST['edit_product'])){
		
		$cID		    = $_GET['id'];
		$cTitle 		= clean($_POST['cTitle']);
		$nPurchasePrice = string2Number($_POST['nPurchasePrice']);
		$nPrice 		= string2Number($_POST['nPrice']);
		$nStock 	    = $_POST['nStock'];
		$cCategory 		= $_POST['cCategory'];
		$cCondition 	= $_POST['cCondition'];
		$cStatus 	  	= $_POST['cStatus'];
		$nWeight      	= $_POST['nWeight'];
		$cProvince		= $_POST['cProvince'];
		$cCity			= $_POST['cCity'];
		$cDescription 	= clean($_POST['cDescription']);
		$dbDt = mysqli_query($db,"select * from products where id='$cID'");
		if($dbRw = mysqli_fetch_array($dbDt)){
			$cFileName  = $_POST['cOldImg'];
			if($_FILES['cNewImg']['name'] <> ""){
				$cFileName	   = round(microtime(true)*1000);
				$cDir		   = "./assets/images/product/".$cFileName;
				if (!move_uploaded_file($_FILES["cNewImg"]["tmp_name"], $cDir)) {
					echo "<script>alert('Gagal Upload');</script>";
				}
			}
			mysqli_query($db,"update products set title='$cTitle',purchase_price='$nPurchasePrice',price='$nPrice',stock='$nStock',category='$cCategory',condit='$cCondition',publish='$cStatus',weight='$nWeight',description='$cDescription',img='$cFileName' where id='$cID'");
			if($cProvince <> "" && $cCity<>""){
				mysqli_query($db,"update products set province='$cProvince',city='$cCity' where id='$cID'");
			}
			echo "<script>alert('Data Disimpan');</script>";
			echo "<script>window.location.href = 'admin.php?page=products';</script>";
		}else{
			echo "<script>alert('Data Tidak Ditemukan');</script>";
		}
	}

	if(isset($_GET['opt'])){
		if($_GET['opt'] == "delete"){
			$cID  = $_GET['id'];
			$dbDt = mysqli_query($db,"select * from products where id='$cID'");
			if($dbRw = mysqli_fetch_array($dbDt)){
				mysqli_query($db,"delete from products where id='$cID'");
				echo "<script>alert('Data Dihapus');</script>";
				echo "<script>window.location.href = 'admin.php?page=products';</script>";
			}else{
				echo "<script>alert('Data Tidak Ditemukan');</script>";
			}
		}else if($_GET['opt'] == "delete_other_img"){
			$cID  = $_GET['id'];
			$cIDProduk = $_GET['idproduk'];
			$dbDt = mysqli_query($db,"select * from img_product where id='$cID'");
			if($dbRw = mysqli_fetch_array($dbDt)){
				if(file_exists("./assets/images/product/".$dbRw['img'])) unlink("./assets/images/product/".$dbRw['img']);
				mysqli_query($db,"delete from img_product where id='$cID'");
				echo "<script>alert('Data Dihapus');</script>";
				echo "<script>window.location.href = 'admin.php?page=products&opt=add_img&id=".$cIDProduk."';</script>";
			}else{
				echo "<script>alert('Data Tidak Ditemukan');</script>";
			}
		}else if($_GET['opt'] == "delete_video"){
			$cID  = $_GET['id'];
			$cIDProduk = $_GET['idproduk'];
			$dbDt = mysqli_query($db,"select * from video_product where id='$cID'");
			if($dbRw = mysqli_fetch_array($dbDt)){
				if(file_exists("./assets/video/product/".$dbRw['video'])) unlink("./assets/video/product/".$dbRw['video']);
				mysqli_query($db,"delete from video_product where id='$cID'");
				echo "<script>alert('Data Dihapus');</script>";
				echo "<script>window.location.href = 'admin.php?page=products&opt=add_img&id=".$cIDProduk."';</script>";
			}else{
				echo "<script>alert('Data Tidak Ditemukan');</script>";
			}
		}
	}

	if(isset($_POST['add_img_product'])){
		$cID = $_GET['id'];
		$cFileName	   = round(microtime(true)*1000);
		$cDir		   = "./assets/images/product/".$cFileName;
		if (move_uploaded_file($_FILES["cImg"]["tmp_name"], $cDir)) {
			mysqli_query($db,"insert into img_product (id_product,img) values ('$cID','$cFileName')");
			echo "<script>alert('Data Disimpan');</script>";
		}else {
			echo "<script>alert('Gagal');</script>";
		}
	}
	if(isset($_POST['add_video_product'])){
		$cID = $_GET['id'];
		$cFileName	   = round(microtime(true)*1000);
		$cDir		   = "./assets/video/product/".$cFileName;
		if (move_uploaded_file($_FILES["cVideo"]["tmp_name"], $cDir)) {
			mysqli_query($db,"insert into video_product (id_product,video) values ('$cID','$cFileName')");
			echo "<script>alert('Data Disimpan');</script>";
			echo "<script>window.location.href = 'admin.php?page=products&opt=add_img&id=".$cID."';</script>";
		}else {
			echo "<script>alert('Gagal');</script>";
		}
	}
	if(isset($_GET['action'])){
		if($_GET['action'] == "getprovice"){
			$data = json_decode($rajaongkir->province(null));
			$data = $data->rajaongkir->results;
			foreach($data as $key=>$value){
				$vaArr[]     = array("id"=>$value->province_id, "text"=>$value->province) ;
			}
			$search     = isset($_GET['q']) ? $_GET['q'] : "";
			if($search <> ""){
				$vaArr = [];
				foreach($data as $key=>$value){
					$nRow = stripos("P". $value->province, $search);
					if($nRow > 0){
						$vaArr[]     = array("id"=>$value->province_id, "text"=>$value->province) ;
					}
				}
			}
			echo json_encode($vaArr);
			exit;
		}else if($_GET['action'] == "getcity"){
			$cIDProvice = $_GET['id_province'];
			$rajaongkir = new Rajaongkir();
			$data = json_decode($rajaongkir->city($cIDProvice));
			$data = $data->rajaongkir->results;
			foreach($data as $key=>$value){
				$type        = ($value->type == "Kabupaten") ? "" : "Kota";
				$vaArr[]     = array("id"=>$value->city_id, "text"=>$type ." ". $value->city_name) ;
			}
			$search     = isset($_GET['q']) ? $_GET['q'] : "";
			if($search <> ""){
				$vaArr = [];
				foreach($data as $key=>$value){
					$nRow = stripos($value->type ." ". $value->city_name, $search);
					if($nRow > 0){
						$type        = ($value->type == "Kabupaten") ? "" : "Kota";
						$vaArr[]     = array("id"=>$value->city_id, "text"=>$type ." ". $value->city_name) ;
					}
				}
			}
			echo json_encode($vaArr);
			exit;
		}
	}
?>
<?php
if(!isset($_GET['opt'])){
?>
<!-- Begin Page Content -->
<div class="container-fluid">
	<!-- Page Heading -->
	<h1 class="h3 mb-2 text-gray-800 mb-4">Data Produk/Barang</h1>

	<!-- DataTales Example -->
	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<a
				href="?page=products&opt=add"
				class="btn btn-primary"
				>Tambah Produk</a
			>
		</div>
		<div class="card-body">
            <?php
            $dbData = mysqli_query($db,"select p.id AS productsId, p.title AS productsTitle, p.price AS productsPrice, p.stock AS productsStock, 
                                        p.date_submit AS productsDate, p.img AS productsImg, p.publish AS productsPublish, c.name AS categoriesName
                                        from products p
                                        left join categories c on p.category=c.id
                                        order by p.id Desc"
                                    );
            if(mysqli_num_rows($dbData) > 0){ ?>
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
								<th>Photo</th>
								<th>Title</th>
								<th>Price</th>
								<th>Stock</th>
								<th>Category</th>
								<th style="width: 150px">Input date</th>
								<th>Status</th>
								<th style="width: 130px">Action</th>
							</tr>
						</thead>
						<tfoot></tfoot>
						<tbody class="data-content">
							<?php $no = 1; ?>
							<?php while($dbRow = mysqli_fetch_array($dbData)){ ?>
							<tr>
								<td><?= $no ?></td>
								<td><img style="width: 50px" src="assets/images/product/<?= $dbRow['productsImg']; ?>"><small><a href="?page=products&opt=add_img&id=<?= $dbRow['productsId']; ?>" target="_blank" class="btn-block mt-2">Gambar Lainnya</a></small></td>
								<td><?= $dbRow['productsTitle']; ?></td>
								<td><?= number2String($dbRow['productsPrice']); ?></td>
								<td><?= $dbRow['productsStock']; ?></td>
								<td><?= $dbRow['categoriesName']; ?></td>
								<td><?= $dbRow['productsDate']; ?></td>
								<?php if($dbRow['productsPublish'] == 1){ ?>
									<td>Publish</td>
								<?php }else{ ?>
									<td>Draft</td>
								<?php } ?>
								<td>
									<!-- <a href="administrator/product/<?= $dbRow['productsId']; ?>" class="btn btn-sm btn-success"><i class="fa fa-eye"></i></a> -->
									<a href="?page=products&opt=edit&id=<?= $dbRow['productsId']; ?>" class="btn btn-sm btn-info"><i class="fa fa-pen"></i></a>
									<a href="?page=products&opt=delete&id=<?= $dbRow['productsId']; ?>" onclick="return confirm('Apakah anda yakin menghapus produk ini')" class="btn btn-sm btn-danger"><i class="fa fa-trash-alt"></i></a>
								</td>
							</tr>
							<?php $no++ ?>
							<?php } ?>
						</tbody>
					</table>
				</div>
				<?php }else{ ?>
				<div class="alert alert-warning" role="alert">
				Oops, the product is still empty, let's add the product now.
				</div>
				<?php } ?>
		</div>
	</div>
</div>
<!-- /.container-fluid -->
<?php
}else if($_GET['opt'] == "add"){
?>
<!-- Begin Page Content -->
<div class="container-fluid">
	<!-- Page Heading -->
	<h1 class="h3 mb-2 text-gray-800 mb-4">Tambah Produk</h1>

	<!-- DataTales Example -->
	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<a href="?page=products" class="btn btn-danger"
				><i class="fa fa-times-circle"></i> Cancel</a
			>
		</div>
		<div class="card-body">
			<form
				action=""
				method="post"
				enctype="multipart/form-data"
			>
				<div class="form-row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="title">Judul</label>
							<input
								type="text"
								class="form-control"
								id="title"
								name="cTitle"
								placeholder="Isikan Judul Produk"
								autocomplete="off"
                                required
                                value=""
							/>
						</div>
					</div>
				</div>
				<div class="form-row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="purchase_price">Harga Beli</label>
							<input
								type="text"
								class="form-control input-money"
								id="purchase_price"
								name="nPurchasePrice"
								placeholder="0"
								autocomplete="off"
                                required
                                value=""
							/>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="price">Harga Jual</label>
							<input
								type="text"
								class="form-control input-money"
								id="price"
								name="nPrice"
								placeholder="0"
								autocomplete="off"
                                required
                                value=""
							/>
						</div>
					</div>
				</div>
				<div class="form-row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="stock">Stok</label>
							<input
								type="number"
								class="form-control"
								id="stock"
								name="nStock"
								placeholder="Stok Produk"
								autocomplete="off"
                                required
                                value=1
							/>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="cat">Kategori</label>
							<select class="form-control" id="cat" name="cCategory" >
								<?php 
                                $dbData = mysqli_query($db,"select * from categories");
                                while($dbRow = mysqli_fetch_array($dbData)){ ?>
								<option value="<?= $dbRow['id'] ?>"><?= $dbRow['name'] ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
				</div>
				<div class="form-row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="condit">Kondisi</label>
							<select class="form-control" id="condit" name="cCondition">
								<option value="1">Baru</option>
								<option value="2">Bekas</option>
							</select>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="weight">Berat (gram)</label>
							<input
								type="number"
								class="form-control"
								id="weight"
								name="nWeight"
								placeholder="Berat Produk (dalam gram)"
								autocomplete="off"
                                required
                                value=0
							/>
						</div>
					</div>
				</div>
				<div class="form-row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="img">Foto Utama</label>
							<input
								type="file"
								name="cImg"
								id="img"
								class="form-control"
                                required
                                value=""
							/>
						</div>
                    </div>
                    <div class="col-md-6">
						<div class="form-group">
							<label for="status">Status</label>
							<select class="form-control" id="status" name="cStatus">
								<option value="1">Publish</option>
								<option value="2">Draft</option>
							</select>
						</div>
					</div>
				</div>
				<div class="form-row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="selectProvince">Asal Provinsi</label>
                            <select name="cProvince" id="selectProvince" class="form-control" required>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="selectCity">Asal Kota</label>
                            <select name="cCity" id="selectCity" class="form-control" required>
                            </select>
                        </div>
                    </div>
                </div>
				<div class="form-group">
					<label for="description">Deskripsi</label>
					<textarea
						class="form-control"
						id="descriptionEditor"
						name="cDescription"
						rows="7"
					>
                    </textarea>
				</div>
				<button type="submit" name="add_product" class="btn btn-primary">Upload Produk</button>
			</form>
		</div>
	</div>
</div>
<!-- /.container-fluid -->
<?php
}else if($_GET['opt'] == "edit"){
?>

<!-- Begin Page Content -->
<div class="container-fluid">
	<!-- Page Heading -->
	<h1 class="h3 mb-2 text-gray-800 mb-4">Edit Produk</h1>

	<!-- DataTales Example -->
	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<a href="?page=products" class="btn btn-danger"
				><i class="fa fa-times-circle"></i> Cancel</a
			>
		</div>
		<div class="card-body">
			<?php
            $cID    = $_GET['id']; 
            $dbData = mysqli_query($db,"select p.*,p.id AS productId, p.link AS linkP,c.name
										from products p
										left join categories c on p.category=c.id 
										where p.id='$cID' group by p.id desc");
            $dbR  = mysqli_fetch_array($dbData);
			$province  	   = json_decode($rajaongkir->province($dbR['province']));
			$province_id   = $province->rajaongkir->results->province_id;
			$province_text = $province->rajaongkir->results->province;

			$city  	   = json_decode($rajaongkir->city($dbR['province'],$dbR['city']));
			$city_id   = $city->rajaongkir->results->city_id;
			$city_text = $city->rajaongkir->results->city_name;
			?>
			<form
				action="?page=products&opt=edit&id=<?= $dbR['productId'] ?>"
				method="post"
				enctype="multipart/form-data"
			>
				<div class="form-row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="title">Judul</label>
							<input
								type="text"
								class="form-control"
								id="title"
								name="cTitle"
								placeholder="Fill in the Product Title"
								autocomplete="off"
                                required
                                value="<?= $dbR['title']; ?>"
							/>
						</div>
					</div>
				</div>
				<div class="form-row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="price">Harga Beli</label>
							<input
								type="text"
								class="form-control input-money"
								id="purchase_price"
								name="nPurchasePrice"
								placeholder="0"
								autocomplete="off"
                                required
                                value="<?= $dbR['purchase_price']; ?>"
							/>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="price">Harga Jual</label>
							<input
								type="text"
								class="form-control input-money"
								id="price"
								name="nPrice"
								placeholder="0"
								autocomplete="off"
                                required
                                value="<?= $dbR['price']; ?>"
							/>
						</div>
					</div>
				</div>
				<div class="form-row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="stock">Stok</label>
							<input
								type="number"
								class="form-control"
								id="stock"
								name="nStock"
								placeholder="Stock of Product"
								autocomplete="off"
                                required
                                value="<?= $dbR['stock']; ?>"
							/>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="cat">Kategori</label>
							<select class="form-control" id="cat" name="cCategory">
								<option value="<?= $dbR['category'] ?>"><?= $dbR['name'] ?></option>
								<?php 
								$dbData = mysqli_query($db,"select * from categories");
								while($dbRow = mysqli_fetch_array($dbData)){ ?>
								<option value="<?= $dbRow['id'] ?>"><?= $dbRow['name'] ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
				</div>
				<div class="form-row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="condit">Kondisi</label>
							<select class="form-control" id="condit" name="cCondition">
                                <?php if($dbR['condit'] == 1){ ?>
                                    <option value="1">Baru</option>
								    <option value="2">Second</option>
                                <?php }else{ ?>
								    <option value="2">Baru</option>
                                    <option value="1">New</option>
                                <?php } ?>
							</select>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="weight">Berat (gram)</label>
							<input
								type="number"
								class="form-control"
								id="weight"
								name="nWeight"
								placeholder="Dalam satuan gram"
								autocomplete="off"
                                required
                                value="<?= $dbR['weight']; ?>"
							/>
						</div>
					</div>
				</div>
				<div class="form-row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="img">Foto Utama</label>
							<input
								type="file"
								name="cNewImg"
								id="img"
								class="form-control"
							/>
						</div>
                    </div>
                    <div class="col-md-6">
						<div class="form-group">
							<label for="status">Status</label>
							<select class="form-control" id="status" name="cStatus">
                                <?php if($dbR['publish'] == 1){ ?>
                                    <option value="1">Publish</option>
								    <option value="2">Draft</option>
                                <?php }else{ ?>
								    <option value="2">Draft</option>
                                    <option value="1">Publish</option>
                                <?php } ?>
							</select>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<label>Foto Lama</label>
							<img src="assets/images/product/<?= $dbR['img']; ?>" style="width: 150px">
							<input type="hidden" name="cOldImg" value="<?= $dbR['img']; ?>">
					</div>
				</div>
				<div class="form-row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="selectProvince">Asal Provinsi</label>
                            <select name="cProvince" id="selectProvince" class="form-control" required>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="selectCity">Asal Kota</label>
                            <select name="cCity" id="selectCity" class="form-control" required>
                            </select>
                        </div>
                    </div>
                </div>
				<div class="form-group">
					<label for="description">Description</label>
					<textarea
						class="form-control"
						id="descriptionEditor"
						name="cDescription"
						rows="7"
						required
					><?= $dbR['description']; ?></textarea>
				</div>
				<button type="submit" name="edit_product" class="btn btn-primary">Edit Product</button>
			</form>
		</div>
	</div>
</div>
<!-- /.container-fluid -->
<?php
}else if($_GET['opt'] == "add_img"){
	$cID = $_GET['id'];
	$dbData = mysqli_query($db,"select p.*,p.id AS productId, p.link AS linkP,c.name
							from products p
							left join categories c on p.category=c.id 
							where p.id='$cID' order by p.id desc");
	$dbR  	 = mysqli_fetch_array($dbData);
	$dbImg   = mysqli_query($db,"select * from img_product where id_product='$cID'");
	$dbVideo = mysqli_query($db,"select * from video_product where id_product='$cID'");	
?>
<div class="container-fluid">
	<!-- Page Heading -->
	<h1 class="h4 mb-2 text-gray-800 mb-4"><?= $dbR['title']; ?></h1>

    <div class="row">
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header">
                    <p class="lead mb-0 pb-0">Other Image</p>
                </div>
                <div class="card-body">
                    <?php if(mysqli_num_rows($dbImg) > 0){ ?>
                    <div class="row">
                        <?php while($dbRImg = mysqli_fetch_array($dbImg)){ ?>
                            <div class="col-md-6 mb-3">
                                <img src="assets/images/product/<?= $dbRImg['img'] ?>" width="100%">
                                <a href="?page=products&opt=delete_other_img&id=<?= $dbRImg['id']; ?>&idproduk=<?= $cID;?>" class="btn btn-block btn-sm btn-danger mt-1" onclick="return confirm('Apakah Anda Yakin?')">Delete</a>
                            </div>
                        <?php } ?>
                    </div>
                    <?php }else{ ?>
                        <div class="alert alert-warning">Belum ada foto untuk produk <?= $dbR['title']; ?> yet</div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header">
                    <p class="lead mb-0 pb-0">Upload Other Images</p>
                </div>
                <div class="card-body">
                    <form action="?page=products&opt=add_img&id=<?= $dbR['productId']; ?>" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <input type="file" name="cImg" id="img" class="form-control" accept="image/x-png,image/gif,image/jpeg" required>
                        </div>
                        <input type="hidden" name="help" value="1">
                        <button name="add_img_product" class="btn btn-sm btn-info" type="submit">Add</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
	<div class="row">
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header">
                    <p class="lead mb-0 pb-0">Video</p>
                </div>
                <div class="card-body">
                    <?php if(mysqli_num_rows($dbVideo) > 0){ ?>
                    <div class="row">
                        <?php while($dbRVideo = mysqli_fetch_array($dbVideo)){ ?>
                            <div class="col-md-6 mb-3">
                                <video src="assets/video/product/<?= $dbRVideo['video'] ?>" controls width="100%"></video>
                                <a href="?page=products&opt=delete_video&id=<?= $dbRVideo['id']; ?>&idproduk=<?= $cID;?>" class="btn btn-block btn-sm btn-danger mt-1" onclick="return confirm('Apakah Anda Yakin?')">Delete</a>
                            </div>
                        <?php } ?>
                    </div>
                    <?php }else{ ?>
                        <div class="alert alert-warning">Belum ada video untuk produk <?= $dbR['title']; ?> yet</div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header">
                    <p class="lead mb-0 pb-0">Upload Video</p>
                </div>
                <div class="card-body">
                    <form action="?page=products&opt=add_video&id=<?= $dbR['productId']; ?>" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <input type="file" name="cVideo" id="video" class="form-control" accept="video/mp4,video/x-m4v,video/*" required>
                        </div>
                        <input type="hidden" name="help" value="1">
                        <button name="add_video_product" class="btn btn-sm btn-info" type="submit">Add</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
}
?>