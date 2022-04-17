<?php
    if(isset($_POST['add_category'])){
        $cCategory 	 = $_POST['cCategory']; 
		$cFileName	   = round(microtime(true)*1000);
		$cDir		   = "./assets/images/icon/".$cFileName;
		$cLink		   = textToLink($cCategory);
        if (move_uploaded_file($_FILES["cCategoryIcon"]["tmp_name"], $cDir)) {
			mysqli_query($db,"insert into categories (name,icon,link) values ('$cCategory','$cFileName','$cLink')");
			echo "<script>alert('Data Disimpan');</script>";
		}else {
			echo "<script>alert('Gagal');</script>";
		}
    }

	if(isset($_POST['edit_category'])){
		$cID		 = $_GET['id'];
		$cCategory 	 = $_POST['cCategory']; 
		$cLink		 = textToLink($cCategory);
		$dbDt = mysqli_query($db,"select * from categories where id='$cID'");
		if($dbRw = mysqli_fetch_array($dbDt)){
			$cFileName  = $_POST['cOldIcon'];
			if($_FILES['cNewIcon']['name'] <> ""){
				$cFileName	   = round(microtime(true)*1000);
				$cDir		   = "./assets/images/icon/".$cFileName;
				if (!move_uploaded_file($_FILES["cNewIcon"]["tmp_name"], $cDir)) {
					echo "<script>alert('Gagal Upload');</script>";
				}
			}
			mysqli_query($db,"update categories SET name='$cCategory',icon='$cFileName',link='$cLink' where id='$cID'");
			echo "<script>alert('Data Disimpan');</script>";
			echo "<script>window.location.href = 'admin.php?page=categories';</script>";
		}else{
			echo "<script>alert('Data Tidak Ditemukan');</script>";
		}
	}

	if(isset($_GET['opt']) && $_GET['opt'] == "delete"){
		$cID  = $_GET['id'];
		$dbDt = mysqli_query($db,"select * from categories where id='$cID'");
		if($dbRw = mysqli_fetch_array($dbDt)){
			mysqli_query($db,"delete from categories where id='$cID'");
			echo "<script>alert('Data Dihapus');</script>";
			echo "<script>window.location.href = 'admin.php?page=categories';</script>";
		}else{
			echo "<script>alert('Data Tidak Ditemukan');</script>";
		}
	}
?>
<?php
if(!isset($_GET['opt'])){
?>
<!-- Begin Page Content -->
<div class="container-fluid">
	<!-- Page Heading -->
	<h1 class="h3 mb-2 text-gray-800 mb-4">Data Kategori</h1>

	<!-- DataTales Example -->
	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<a
				href="#"
				class="btn btn-primary"
				data-toggle="modal"
				data-target="#addCategory"
				>Tambah Category</a
			>
		</div>
		<div class="card-body">
            <?php 
            $dbData = mysqli_query($db,"select * from categories");
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
							<th>Icon</th>
							<th>Nama</th>
                            <th>Link</th>
                            <th>Action</th>
						</tr>
					</thead>
					<tfoot></tfoot>
					<tbody class="data-content">
                        <?php $no = 1 ?>
						<?php while($dbRow = mysqli_fetch_array($dbData)){?>
						<tr>
                            <td><?= $no ?></td>
                            <td><img style="width: 50px" src="assets/images/icon/<?= $dbRow['icon']; ?>"></td>
                            <td><?= $dbRow['name']; ?></td>
                            <td><?= $dbRow['link']; ?></td>
                            <td>
                                <a href="?page=categories&opt=edit&id=<?= $dbRow['id']; ?>" class="btn btn-sm btn-info"><i class="fa fa-pen"></i></a>
                                <a href="?page=categories&opt=delete&id=<?= $dbRow['id']; ?>" onclick="return confirm('Apakah anda yakin akan menghapus kategori ini?')" class="btn btn-sm btn-danger"><i class="fa fa-trash-alt"></i></a>
                            </td>
                        </tr>
                        <?php $no++ ?>
                        <?php } ?>
					</tbody>
				</table>
			</div>
			<?php }else{ ?>
			<div class="alert alert-warning" role="alert">
			Oops, the category is still empty, let's add a category now.
			</div>
            <?php } ?>
		</div>
	</div>
</div>
<!-- /.container-fluid -->

<!-- Modal Add Category -->
<div
	class="modal fade"
	id="addCategory"
	tabindex="-1"
	role="dialog"
	aria-labelledby="exampleModalLabel"
	aria-hidden="true"
>
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Add Category</h5>
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
					enctype="multipart/form-data"
				>
					<div class="form-group">
						<label for="name">Kategori</label>
						<input
							type="text"
							class="form-control"
							id="name"
							name="cCategory"
							autocomplete="off"
							required
						/>
					</div>
					<div class="form-group">
						<label for="icon">Icon</label>
						<input
							type="file"
							class="form-control"
							required
							name="cCategoryIcon"
							id="icon"
						/>
						<small id="iconHelp" class="form-text text-muted"
							>Recommended icon size 100x100 px</small
						>
					</div>
					<button type="submit" name="add_category" class="btn btn-primary" id="btnAddCategory">
					Add
					</button>
				</form>
			</div>
		</div>
	</div>
</div>
<?php
}else if($_GET['opt'] == "edit"){
?>
<!-- Begin Page Content -->
<div class="container-fluid">
	<!-- Page Heading -->
	<h1 class="h3 mb-2 text-gray-800 mb-4">Edit Category</h1>

	<!-- DataTales Example -->
	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<a
				href="?page=categories"
				class="btn btn-danger"
				><i class="fa fa-times-circle"></i> Cancel</a
			>
		</div>
		<div class="card-body">
            <?php
            $cID    = $_GET['id']; 
            $dbData = mysqli_query($db,"select* from categories where id='$cID'");
            $dbRow  = mysqli_fetch_array($dbData);
            ?>
			<form
				action="?page=categories&opt=edit&id=<?= $dbRow['id']; ?>"
				method="post"
				enctype="multipart/form-data"
			>
				<div class="form-group">
					<label for="name">Category Name</label>
					<input
						type="text"
						class="form-control"
						id="name"
						name="cCategory"
						required
						autocomplete="off"
						value="<?= $dbRow['name']; ?>"
					/>
				</div>
				<div class="form-group">
					<label>Old Icon</label><br />
					<input
						type="hidden"
						name="cOldIcon"
						value="<?= $dbRow['icon']; ?>"
					/>
					<img
						src="assets/images/icon/<?= $dbRow['icon']; ?>"
						style="width: 70px;"
					/>
				</div>
				<div class="form-group">
					<label for="icon">New Icon</label>
					<input type="file" name="cNewIcon" id="icon" class="form-control" />
				</div>
				<button type="submit" name="edit_category" class="btn btn-primary">Edit Category</button>
			</form>
		</div>
	</div>
</div>
<!-- /.container-fluid -->

<?php
}
?>