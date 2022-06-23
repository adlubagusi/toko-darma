<?php
    if(isset($_POST['add_user'])){
        $cNama 	    = $_POST['cName']; 
        $cAddress   = $_POST['cAddress']; 
        $cPoscode   = $_POST['cPoscode']; 
        $cTelp      = $_POST['cTelp'];
        $cEmail     = $_POST['cEmail'];
        $cPassword  = md5($_POST['cPassword']);
        mysqli_query($db,"insert into users (name,address,poscode,telp,email,password) values ('$cNama','$cAddress','$cPoscode','$cTelp','$cEmail','$cPassword')");
        echo "<script>alert('Data Disimpan');</script>";
    }

	if(isset($_POST['edit_user'])){
		$cID	    = $_GET['id'];
        $cNama 	    = $_POST['cName']; 
        $cAddress   = $_POST['cAddress']; 
        $cPoscode   = $_POST['cPoscode']; 
        $cTelp      = $_POST['cTelp'];
        $cEmail     = $_POST['cEmail'];
		$dbDt = mysqli_query($db,"select * from users where id='$cID'");
		if($dbRw = mysqli_fetch_array($dbDt)){
			mysqli_query($db,"update users SET name='$cNama',address='$cAddress',poscode='$cPoscode',telp='$cTelp',email='$cEmail' where id='$cID'");
			echo "<script>alert('Data Disimpan');</script>";
			echo "<script>window.location.href = 'pemilik.php?page=users';</script>";
		}else{
			echo "<script>alert('Data Tidak Ditemukan');</script>";
		}
	}

	if(isset($_GET['opt']) && $_GET['opt'] == "delete"){
		$cID  = $_GET['id'];
		$dbDt = mysqli_query($db,"select * from users where id='$cID'");
		if($dbRw = mysqli_fetch_array($dbDt)){
			mysqli_query($db,"delete from users where id='$cID'");
			echo "<script>alert('Data Dihapus');</script>";
			echo "<script>window.location.href = 'pemilik.php?page=users';</script>";
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
	<h1 class="h3 mb-2 text-gray-800 mb-4">Data User</h1>

	<!-- DataTales Example -->
	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<a
				href="#"
				class="btn btn-primary"
				data-toggle="modal"
				data-target="#addUser"
				>Tambah User</a
			>
		</div>
		<div class="card-body">
            <?php 
            $dbData = mysqli_query($db,"select * from users where level='admin'");
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
							<th>Nama</th>
                            <th>Alamat</th>
                            <th>Kode Pos</th>
                            <th>No. Telp</th>
                            <th>Email</th>
                            <th>Aksi</th>
						</tr>
					</thead>
					<tfoot></tfoot>
					<tbody class="data-content">
                        <?php $no = 1 ?>
						<?php while($dbRow = mysqli_fetch_array($dbData)){?>
						<tr>
                            <td><?= $no ?></td>
                            <td><?= $dbRow['name']; ?></td>
                            <td><?= $dbRow['address']; ?></td>
                            <td><?= $dbRow['poscode']; ?></td>
                            <td><?= $dbRow['telp']; ?></td>
                            <td><?= $dbRow['email']; ?></td>
                            <td>
                                <a href="?page=users&opt=edit&id=<?= $dbRow['id']; ?>" class="btn btn-sm btn-info"><i class="fa fa-pen"></i></a>
                                <a href="?page=users&opt=delete&id=<?= $dbRow['id']; ?>" onclick="return confirm('Apakah anda yakin akan menghapus user ini?')" class="btn btn-sm btn-danger"><i class="fa fa-trash-alt"></i></a>
                            </td>
                        </tr>
                        <?php $no++ ?>
                        <?php } ?>
					</tbody>
				</table>
			</div>
			<?php }else{ ?>
			<div class="alert alert-warning" role="alert">
			Oops, the user is still empty, let's add a user now.
			</div>
            <?php } ?>
		</div>
	</div>
</div>
<!-- /.container-fluid -->

<!-- Modal Add User -->
<div
	class="modal fade"
	id="addUser"
	tabindex="-1"
	role="dialog"
	aria-labelledby="exampleModalLabel"
	aria-hidden="true"
>
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Tambah User</h5>
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
						<label for="name">Nama Lengkap</label>
						<input
							type="text"
							class="form-control"
							id="cName"
							name="cName"
							autocomplete="off"
							required
						/>
					</div>
                    <div class="form-group">
						<label for="name">Alamat</label>
						<input
							type="text"
							class="form-control"
							id="cAddress"
							name="cAddress"
							autocomplete="off"
							required
						/>
					</div>
					<div class="form-group">
						<label for="name">Kode Pos</label>
						<input
							type="text"
							class="form-control"
							id="cPoscode"
							name="cPoscode"
							autocomplete="off"
							required
						/>
					</div>
                    <div class="form-group">
						<label for="name">No. Telp</label>
						<input
							type="text"
							class="form-control"
							id="cTelp"
							name="cTelp"
							autocomplete="off"
							required
						/>
					</div>
                    <div class="form-group">
						<label for="name">Email</label>
						<input
							type="email"
							class="form-control"
							id="cEmail"
							name="cEmail"
							autocomplete="off"
							required
						/>
					</div>
                    <div class="form-group">
						<label for="name">Password</label>
						<input
							type="password"
							class="form-control"
							id="cPassword"
							name="cPassword"
							autocomplete="off"
							required
						/>
					</div>
					<button type="submit" name="add_user" class="btn btn-primary" id="btnAddUser">
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
	<h1 class="h3 mb-2 text-gray-800 mb-4">Edit User</h1>

	<!-- DataTales Example -->
	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<a
				href="?page=users"
				class="btn btn-danger"
				><i class="fa fa-times-circle"></i> Cancel</a
			>
		</div>
		<div class="card-body">
            <?php
            $cID    = $_GET['id']; 
            $dbData = mysqli_query($db,"select* from users where id='$cID'");
            $dbRow  = mysqli_fetch_array($dbData);
            ?>
			<form
				action="?page=users&opt=edit&id=<?= $dbRow['id']; ?>"
				method="post"
				enctype="multipart/form-data"
			>
				<div class="form-group">
					<label for="name">Nama Lengkap</label>
					<input
						type="text"
						class="form-control"
						id="cName"
						name="cName"
						required
						autocomplete="off"
						value="<?= $dbRow['name']; ?>"
					/>
				</div>
				<div class="form-group">
					<label for="name">Alamat</label>
					<input
						type="text"
						class="form-control"
						id="cAddress"
						name="cAddress"
						required
						autocomplete="off"
						value="<?= $dbRow['address']; ?>"
					/>
				</div>
				<div class="form-group">
					<label for="name">Kode Pos</label>
					<input
						type="text"
						class="form-control"
						id="cPoscode"
						name="cPoscode"
						required
						autocomplete="off"
						value="<?= $dbRow['poscode']; ?>"
					/>
				</div>
				<div class="form-group">
					<label for="name">No. Telp</label>
					<input
						type="text"
						class="form-control"
						id="cTelp"
						name="cTelp"
						required
						autocomplete="off"
						value="<?= $dbRow['telp']; ?>"
					/>
				</div>
				<div class="form-group">
					<label for="name">Email</label>
					<input
						type="text"
						class="form-control"
						id="cEmail"
						name="cEmail"
						required
						autocomplete="off"
						value="<?= $dbRow['email']; ?>"
					/>
				</div>
				<button type="submit" name="edit_user" class="btn btn-primary">Edit User</button>
			</form>
		</div>
	</div>
</div>
<!-- /.container-fluid -->

<?php
}
?>