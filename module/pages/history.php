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
    }else if($_GET['action'] == "terima_pesanan"){
        $cInvoice = $_GET['invoice'];
        mysqli_query($db,"update invoice set status_delivery='3' where invoice_code='$cInvoice'");
        //update barang terjual
        // $dbData = mysqli_query($db,"select * from transaction where id_invoice='$cInvoice'");
        // while($dbRow = mysqli_fetch_array($dbData)){
        //     $cLink = $dbRow['Link'];
        //     $dbDt = mysqli_query($db,"select * from products where link='$cLink'");
        //     if($dbR = mysqli_fetch_array($dbDt)){
        //         $nTransaction = $dbR['transaction'] + $dbRow['qty']; 
        //         mysqli_query($db,"update products set transaction='$nTransaction' where id='{$dbR['id']}'");
        //     }
        // }
        echo "<script>alert('Pesanan Sudah Diterima');</script>";
        echo "<script>window.location.href = 'index.php?page=history';</script>";
    }else if($_GET['action'] == "get_item"){
        $cInvoice = $_GET['rowid'];
        $vaArray  = array();
        $dbRating = mysqli_query($db,"select r.rating,r.deskripsi,p.id,p.title product_name,p.img 
                                from rating r 
                                left join products p on p.id=r.id_product
                                where r.id_invoice='$cInvoice' group by r.id");
        if(mysqli_num_rows($dbRating) > 0){
            while($dbRow   = mysqli_fetch_array($dbRating)){
                $vaArray[] = $dbRow;
            }
        }else{
            $dbData = mysqli_query($db,"select t.product_name,p.img,p.id 
                                    from transaction t 
                                    left join products p on p.link=t.link
                                    where t.id_invoice='$cInvoice'");
            while($dbRow   = mysqli_fetch_array($dbData)){
                $dbRow['deskripsi'] = "";
                $vaArray[] = $dbRow;
            }
        }    
        echo json_encode($vaArray);
        exit;
    }else if($_GET['action'] == "penilaian"){
        $cInvoice = $_POST['id_invoice'] ;
        $vaArray = array();
        foreach($_POST['rating'] as $key=>$value){
            $vaArray[$key]['rating'] = $value;
        } 
        foreach($_POST['deskripsi'] as $key=>$value){
            $vaArray[$key]['deskripsi'] = $value;
        } 
        foreach($vaArray as $key=>$value){
            $cNama      = $_SESSION['name'];
            $cEmail     = $_SESSION['email'];
            $cDeskripsi = $value['deskripsi'];
            $nRating    = $value['rating'];
            $cProductID = $key;
            $dDateTime  = date("Y-m-d h:i:s");

            mysqli_query($db,"insert into rating (nama,email,deskripsi,status,rating,id_product,id_invoice,datetime) 
                             values('$cNama','$cEmail','$cDeskripsi','1','$nRating','$cProductID','$cInvoice','$dDateTime')");
            echo mysqli_error($db) ;
        }
        echo  "Penilaian Berhasil Dilakukan";
        exit;
    }else if($_GET['action'] == "refund"){
        $cInvoice = $_GET['invoice'];
        mysqli_query($db,"update invoice set status_refund='1' where invoice_code='$cInvoice'");

        echo "<script>alert('Barang Dikembalikan ke Penjual');</script>";
        echo "<script>window.location.href = 'index.php?page=history';</script>";
    }
}

if(isset($_GET['invoice']) && $_GET['invoice'] <> ""){
    $cInvoice = $_GET['invoice'];
    $dbData = mysqli_query($db,"select * from invoice where invoice_code='$cInvoice'");
    $vaInvoice = mysqli_fetch_array($dbData);

    $dbRegion = mysqli_query($db,"select * from region where id='{$vaInvoice['region']}'");
    $vaRegion = mysqli_fetch_array($dbRegion);

    $vaRating = array();
    $dbRating = mysqli_query($db,"select * from rating where id_invoice='$cInvoice'");
    while($dbRow = mysqli_fetch_array($dbRating)){
        $vaRating[] = $dbRow;
    }
?>
<div class="container" style="margin-top:20px;">
	<!-- DataTales Example -->
	<div class="card shadow mb-4">
		<div class="card-header py-3">
            <a href="?page=history" class="btn btn-sm btn-primary"><i class="fa fa-chevron-left"></i> Back</a>
            <h1 class="h3 mb-2 text-gray-800 mb-2" style="float:right">Code/Invoice = <?= $vaInvoice['invoice_code']; ?></h1>
            <?php if($vaInvoice['status_payment'] == 1 && $vaInvoice['status_delivery'] == 3 && count($vaRating) > 0){ ?>
                <h3 class="text-success">Transaksi selesai</h3>
            <?php } ?>
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
                            if($vaInvoice['status_refund'] > 0){
                                if($vaInvoice['status_refund'] == 1){
                            ?>
                                <td><span class="badge badge-warning">Barang Dikembalikan</span></td>
                            <?php
                                }else{
                            ?>
                                <td><span class="badge badge-success">Refund</span></td>
                            <?php
                                }
                            }else{
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
                            <?php 
                                }
                            }
                            ?>
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
            $cTextBukti = "Upload";
            if($vaInvoice['status_payment'] == 1 && $vaInvoice['status_delivery'] == 3){ 
                if(count($vaRating) > 0){
            ?>
                <a class="btn btn-default btn-outline-info" data-toggle="modal" data-target="#modalPenilaian" onclick="showModalPenilaian('<?= $vaInvoice['invoice_code']; ?>')">
                    <i class="fa fa-star"></i>
                    Lihat Penilaian
                </a>  
            <?php
                }else{
            ?>
                <a class="btn btn-warning" data-toggle="modal" data-target="#modalPenilaian" onclick="showModalPenilaian('<?= $vaInvoice['invoice_code']; ?>')">
                    <i class="fa fa-pencil"></i>
                    Beri Penilaian
                </a>  
            <?php
                }    
            }else{
                if(is_file("assets/bukti_transfer/".$vaInvoice['bukti_transfer'])){
                    $cTextBukti = "Ganti";
            ?>
            <div class="form-group mx-sm-3 mb-2">
                <label> Lihat Bukti Transfer <a href="assets/bukti_transfer/<?=$vaInvoice['bukti_transfer']?>" target="_blank"  class="btn btn-sm btn-info"><i class="fa fa-search"></i></a> </label>
            </div>
            <?php    
                }
            }
            if(!$vaInvoice['status_payment']){
            ?>
            <form class="form-inline" action="?page=history&action=upload_file" method="post" enctype="multipart/form-data">
                <div class="form-group mx-sm-3 mb-2">
                    <label for="inputPassword2" class=""><?=$cTextBukti?> Bukti Transfer&nbsp;</label>
                    <input type="file" class="form-control" name="cBuktiTransfer">
                    <input type="hidden" name="cInvoice" value="<?= $vaInvoice['invoice_code'];?>">
                </div>
                <button type="submit" class="btn btn-primary mb-2">Submit</button>
            </form>
            <?php
            }else if($vaInvoice['status_delivery'] == 2 && $vaInvoice['status_refund'] == 0){
            ?>
            <a class="btn btn-outline-success" href="index.php?page=history&action=terima_pesanan&invoice=<?=$_GET['invoice']?>" onclick="return confirm('Anda yakin sudah menerima pesanan?');">
                <i class="fa fa-check"></i>
                Pesanan Sudah Diterima
            </a>  
            <!-- <a class="btn btn-danger" href="index.php?page=history&action=refund&invoice=<?=$_GET['invoice']?>" onclick="return confirm('Anda akan mengajuan pengembalian?');"> -->
            <a class="btn btn-danger" href="index.php?page=history&action=refund&invoice=<?=$_GET['invoice']?>"  onclick="return confirm('Anda yakin akan mengembalikan barang?');"> 
                <i class="fa fa-box"></i>
                Ajukan Pengembalian
            </a>  
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
                        <a href="index.php?p=<?= $data['link']; ?>" target="_blank" class="btn btn-sm btn-success"><i class="fa fa-search"></i></a>
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
                                        <td><span class="badge badge-success">Lunas</span></td>
                                    <?php
                                        }else{ 
                                            if($data['bukti_transfer'] <> ""){
                                    ?>
                                        <td><span class="badge badge-warning">Menunggu Konfirmasi<br>Admin</span></td>
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
                                        }else if($data['status_delivery'] == 2){ 
                                    ?>
                                        <td><span class="badge badge-info">Dikirim</span></td>
                                    <?php
                                        }else if($data['status_delivery'] == 1){
                                    ?>
                                        <td><span class="badge badge-warning">Dikemas</span></td>
                                    <?php        
                                        }else{ 
                                    ?>
                                        <td><span class="badge badge-danger">Belum Diproses</span></td>
                                    <?php 
                                        } 
                                    }
                                    ?>
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
<!-- Modal -->
<div class="modal fade" id="modalPenilaian" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form method="post" id="formPenilaian">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Nilai Produk</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="bodyModalPenilaian">
                
            </div>
            <div class="modal-footer">
                <input type="hidden" name="id_invoice" id="id_invoice" value=<?= $cInvoice?>>
                <button type="submit" class="btn btn-primary" id="btnPenilaian">Kirim</button>
            </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script>
    
    function showModalPenilaian(id){
        $("#bodyModalPenilaian").html("");
        $.ajax({
            url: "?page=history&action=get_item",
            type: "get",
            dataType: "json",
            data: {
                rowid: id
            },
            success: function(res){
                // console.log(res);
                $.each(res,function(key,value){
                    if(value.rating > 0) $("#btnPenilaian").css("display","none") ;
                    var checked1 = (value.rating == 1) ? "checked" : "";
                    var checked2 = (value.rating == 2) ? "checked" : "";
                    var checked3 = (value.rating == 3) ? "checked" : "";
                    var checked4 = (value.rating == 4) ? "checked" : "";
                    var checked5 = (value.rating == 5) ? "checked" : "";
                    $("#bodyModalPenilaian").append(`<div class="form-group">
                        <ul class="list-group">
                            <li class="list-group-item">
                                <label><img src="assets/images/product/`+value.img+`" style="width:40px;margin:5px;border-radius:10px;">`+value.product_name+`</label>
                                <fieldset class="rating">
                                    
                                    <input id="demo-1`+key+`" type="radio" name="rating[`+value.id+`]" value="1" `+checked1+`> 
                                    <label for="demo-1`+key+`">1 star</label>
                                    <input id="demo-2`+key+`" type="radio" name="rating[`+value.id+`]" value="2" `+checked2+`>
                                    <label for="demo-2`+key+`">2 stars</label>
                                    <input id="demo-3`+key+`" type="radio" name="rating[`+value.id+`]" value="3" `+checked3+`>
                                    <label for="demo-3`+key+`">3 stars</label>
                                    <input id="demo-4`+key+`" type="radio" name="rating[`+value.id+`]" value="4" `+checked4+`>
                                    <label for="demo-4`+key+`">4 stars</label>
                                    <input id="demo-5`+key+`" type="radio" name="rating[`+value.id+`]" value="5" `+checked5+`>
                                    <label for="demo-5`+key+`">5 stars</label>
                                    
                                    <div class="stars">
                                        <label for="demo-1`+key+`" aria-label="1 star" title="1 star"></label>
                                        <label for="demo-2`+key+`" aria-label="2 stars" title="2 stars"></label>
                                        <label for="demo-3`+key+`" aria-label="3 stars" title="3 stars"></label>
                                        <label for="demo-4`+key+`" aria-label="4 stars" title="4 stars"></label>
                                        <label for="demo-5`+key+`" aria-label="5 stars" title="5 stars"></label>   
                                    </div>
                                    
                                </fieldset>
                                <textarea name="deskripsi[`+value.id+`]" id="deskripsi_`+value.id+`" class="form-control form-control-sm" placeholder="Berikan ulasanmu untuk barang ini.">`+value.deskripsi+`</textarea>
                            </li>
                        </ul>
                    </div>`);      
                })
            }
        })
    }
    $("#formPenilaian").submit(function(e){
        e.preventDefault();
        var fd = new FormData(this);
        $.ajax({
            url:"?page=history&action=penilaian",
            type:"post",
            data:fd,
            processData:false,
            contentType:false,
            cache:false,
            async:false,
            success: function(res){
                alert(res);
                window.location.href = 'index.php?page=history';
            }   
        });
    })
</script>