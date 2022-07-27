<?php
include 'include/rajaongkir.php';
$cIdUser = $_SESSION['user_id'];
if(isset($_GET['action'])){
    if($_GET['action'] == "get_ongkir"){
        $cId = $_POST['id'];
        $dbRegion = mysqli_query($db,"select * from region where id='$cId'");
        $nWeight  = 0;
        $nList    = 0;
        $dbCart   = mysqli_query($db,"select * from cart where id_user='$cIdUser'");
        while($c  = mysqli_fetch_array($dbCart)){
            $nWeight += $c['weight'] * $c['qty'];
        }
        $nWeight = $nWeight / 1000;
        $nWeight = ceil($nWeight);
        if($db = mysqli_fetch_array($dbRegion)){
            $nTotal  = intval($db['price']) * intval($nWeight);
            $nList += $nTotal;
        }
        echo json_encode($nList);
        exit;
    }else if($_GET['action'] == "succesfully"){
        $invoice = substr(time(),7) . substr(rand(),0,3);
        $name = $_POST['name'];
        $email = $_POST['email'];
        $telp = $_POST['telp'];
        $region = $_POST['region'];
        $address = $_POST['address'];
        $totalPrice = 0;
        $dateInput = date('Y-m-d H:i:s');
        $weight = 0;
        $dbCart   = mysqli_query($db,"select * from cart where id_user='$cIdUser'");
        while($c  = mysqli_fetch_array($dbCart)){
            $weight += $c['weight'] * $c['qty'];
            $nSubTotal = $c['qty'] * $c['price'];
            $totalPrice += $nSubTotal;
        }
        $weight = $weight / 1000;
        $weight = ceil($weight);
        $ongkir = 0;
        $dbRegion = mysqli_query($db,"select * from region where id='$region'");
        if($r = mysqli_fetch_array($dbRegion)){
            $nTotal  = intval($r['price']) * intval($weight);
            $ongkir += $nTotal;
        }
        $totalAll = intval($totalPrice) + intval($ongkir);
        mysqli_query($db,"insert into invoice (invoice_code,name,email,telp,region,address,ongkir,total_price,total_all,date_input,status_payment,status_delivery) values ('$invoice','$name','$email','$telp','$region','$address','$ongkir','$totalPrice','$totalAll','$dateInput','0','0')");
        
        $dbCart   = mysqli_query($db,"select * from cart where id_user='$cIdUser'");
        while($c  = mysqli_fetch_array($dbCart)){
            mysqli_query($db,"insert into transaction (id_invoice,product_name,price,qty,link,ket) values ('$invoice','{$c['name']}','{$c['price']}','{$c['qty']}','{$c['link']}','{$c['ket']}')"); 
        }
        mysqli_query($db,"delete from cart where id_user='$cIdUser'");
        echo "<script>alert('Transaksi Berhasil! Silahkan Melakukan Pembayaran!')</script>";
        echo "<script>window.location.href = 'index.php?page=rekening';</script>";
        exit;
    }
}

?>
<form action="?page=payment&action=succesfully" method="post">
<div class="wrapper">
    <div class="core">
        <?php 
        $dbCart = mysqli_query($db,"select * from cart where id_user='$cIdUser'");
        if(mysqli_num_rows($dbCart) > 0){
            $nTotalPrice = 0;
            $nSubTotalPrice = 0;
        ?>
        <div class="products">
            <table class="table">
                <tr>
                    <th>Produk</th>
                    <th>Jumlah</th>
                    <th>Info</th>
                    <th>Harga</th>
                </tr>
                <?php
                    while($item = mysqli_fetch_array($dbCart)){
                        $nSubTotalPrice = $item['price'] * $item['qty'];
                        $nTotalPrice += $nSubTotalPrice;
                ?>
                <tr>
                    <td># <?= $item['name']; ?></td>
                    <td class="text-center"><?= $item['qty']; ?></td>
                    <?php if($item['ket'] == ""){ ?>
                        <td>-</td>
                    <?php }else{ ?>
                        <td><?= $item['ket']; ?></td>
                    <?php } ?>
                    <td>Rp <script>document.write(convertToNumber('<?= $nSubTotalPrice; ?>'))</script></td>
                </tr>
                <?php } ?>
            </table>
        </div>
        <div class="line"></div>
        <div class="address">
            <h2 class="title">Alamat Pengiriman</h2>
            <hr>
            <div class="form-group">
                <label for="name">Atas Nama</label>
                <input type="text" id="name" autocomplete="off" class="form-control" required name="name" value="<?= $_SESSION['name']?>">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" autocomplete="off" class="form-control" required name="email" value="<?= $_SESSION['email']?>">
            </div>
            <div class="form-group">
                <label for="telp">Telepon</label>
                <input type="number" id="telp" autocomplete="off" class="form-control" required name="telp" value="<?= $_SESSION['telp']?>">
            </div>
            <div class="form-group">
                <label for="selectRegionPayment">Wilayah</label>
                <select name="region" id="selectRegionPayment" class="form-control" required>
                    <option></option>
                    <?php 
                    $dbRegion = mysqli_query($db,"select * from region order by region");
                    while($d = mysqli_fetch_array($dbRegion)){ 
                    ?>
                        <option value="<?= $d['id']; ?>"><?= $d['region']; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label for="address">Alamat Lengkap</label>
                <textarea name="address" rows="3" id="address" class="form-control" placeholder="Isikan nama jalan, nomor rumah, nama gedung, dll." required></textarea>
            </div>
        </div>
        <?php }else{ ?>
            <div class="alert alert-warning">Anda belum memiliki belanjaan. Ayo belanja dulu.</div>
        <?php } ?>
    </div>
    <div class="total shadow">
        <h2 class="title">Ringkasan Belanja</h2>
        <hr>
        <div class="list">
            <p>Total Belanja</p>
            <p>Rp <script>document.write(convertToNumber('<?= $nTotalPrice ?>'))</script></p>
        </div>
            <div class="list">
                <p>Biaya pengiriman</p>
                <p id="paymentSendingPrice">Rp <script>document.write(convertToNumber('0'))</script></p>
            </div>
            <hr>
            <div class="list">
                <p>Total Tagihan</p>
                <p id="paymentTotalAll">Rp <script>document.write(convertToNumber('<?= $nTotalPrice ?>'))</script></p>
            </div>
        <?php if(mysqli_num_rows($dbCart) > 0){?>
            <button class="btn btn-dark btn btn-block mt-2" id="btnPaymentNow" type="submit">Continue</button>
        <?php }else{ ?>
            <div class="alert mt-2 alert-warning">Keranjang Anda Masing Kosong.</div>
            <a href="index.php">
                <button class="btn btn-dark btn btn-block mt-2">Belanja dulu</button>
            </a>
        <?php } ?>
    </div>
</div>
</form>
<script src="assets/select2-4.0.6-rc.1/dist/js/select2.min.js"></script>
<script>
    $("#selectRegionPayment").select2({
        placeholder: 'Pilih Wilayah',
        language: 'id'
    })
    $("#selectRegionPayment").change(paymentOngkirPrice)

    function paymentOngkirPrice(){
        $("#paymentSendingPrice").text("Loading..")
        const id = $("#selectRegionPayment").val();
        $.ajax({
            url: "?page=payment&action=get_ongkir",
            type: "post",
            dataType: "json",
            async: true,
            data: {
                id: id
            },
            success: function(data){
                $("#paymentSendingPrice").text("Rp "+convertToNumber(data));
                const price = "<?= $nTotalPrice ?>";
                const total = parseInt(price) + parseInt(data);
                $("#paymentTotalAll").text("Rp "+convertToNumber(total));
            }
        });
    }
    
</script>