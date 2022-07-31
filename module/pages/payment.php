<?php
include 'include/rajaongkir.php';
$cIdUser = $_SESSION['user_id'];
if(isset($_GET['action'])){
    if($_GET['action'] == "getprovice"){
        $rajaongkir = new Rajaongkir();
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
    }else if($_GET['action'] == "getlistshippingcost"){
        $rajaongkir  = new Rajaongkir();
        $origin      = $_POST['origin'];
        $destination = $_POST['destination'];
        $weight      = $_POST['weight'];
        $courier     = $_POST['courier'];
        $data = json_decode($rajaongkir->cost($origin,$destination,$weight,$courier),true);
        if(!empty($data['rajaongkir']['results'])){
            $cost = $data['rajaongkir']['results'][0]['costs'];
            // echo json_encode($cost);
            include 'module/pages/kurirdata.php';
            exit;
        }
    }else if($_GET['action'] == "countshipppingcost"){
        $rowid  = $_POST['rowid'];
        $ongkir = $_POST['ongkir'];
        mysqli_query($db,"update cart set ongkir='$ongkir' where id='$rowid'");
    

        $cost = 0;
        $dbCart = mysqli_query($db,"select c.*,p.province,p.city 
                               from cart c 
                               left join products p on p.id=c.id_product
                               where c.id_user='$cIdUser'");
        while($item = mysqli_fetch_array($dbCart)){
            $cost += $item['ongkir'];
        }
        echo $cost;
        exit;
    }else if($_GET['action'] == "succesfully"){
        $invoice    = substr(time(),7) . substr(rand(),0,3);
        $name       = $_POST['name'];
        $email      = $_POST['email'];
        $telp       = $_POST['telp'];
        $province   = $_POST['province'];
        $city       = $_POST['city'];
        $address    = $_POST['address'];
        $totalPrice = 0;
        $dateInput  = date('Y-m-d H:i:s');
        $weight = 0;
        $ongkir = 0;
        $dbCart   = mysqli_query($db,"select * from cart where id_user='$cIdUser'");
        while($c  = mysqli_fetch_array($dbCart)){
            $weight     += $c['weight'] * $c['qty'];
            $nSubTotal  = $c['qty'] * $c['price'];
            $totalPrice += $nSubTotal;
            $ongkir     += $c['ongkir'];
        }
        $totalAll = intval($totalPrice) + intval($ongkir);
        mysqli_query($db,"insert into invoice (invoice_code,name,email,telp,province,city,address,ongkir,total_price,total_all,date_input,status_payment,status_delivery) values ('$invoice','$name','$email','$telp','$province','$city','$address','$ongkir','$totalPrice','$totalAll','$dateInput','0','0')");
        
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
                <label for="province">Provinsi</label>
                <select name="province" id="selectProvince" class="form-control" required>
                </select>
            </div>
            <div class="form-group">
                <label for="city">Kota/Kabupaten</label>
                <select name="city" id="selectCity" class="form-control" required>
                </select>
            </div>
            <div class="form-group">
                <label for="address">Alamat Lengkap</label>
                <textarea name="address" rows="3" id="address" class="form-control" placeholder="Isikan nama jalan, nomor rumah, nama gedung, dll." required><?= $_SESSION['address']?></textarea>
            </div>
        </div>
        <!-- <div class="line"></div> -->
        <?php 
        $dbCart = mysqli_query($db,"select c.*,p.province,p.city 
                               from cart c 
                               left join products p on p.id=c.id_product
                               where c.id_user='$cIdUser'");
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
                    $noBarang = 1;
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
                    <td><script>document.write(convertToNumber('<?= $nSubTotalPrice; ?>'))</script></td>
                </tr>
                <tr>
                    <td colspan="4">
                        <div class="form-group">
                            <label>Pilih Pengiriman</label><br>
                            <?php
                                $kurir=array('jne','tiki','pos');
                                $no = 1;
                                foreach($kurir as $rkurir){
                            ?>
                            <div class="radio" style="display: inline-block;">
                                <label>
                                    <input type="radio" name="kurir<?=$noBarang;?>" id="kurir<?=$noBarang."_".$no++;?>" value="<?php echo $rkurir; ?>" onclick="setKurir('<?=$item['city']?>','<?=$rkurir?>','<?=$item['weight']?>','<?=$item['id']?>');">
                                    <?php echo strtoupper($rkurir); ?>
                                </label>
                            </div>
                            <?php
                                 }
                                 $noBarang++
                            ?>
                        </div>
                        <div id="kuririnfo_<?=$item['id']?>" style="display: none;">
                            <div class="form-group">
                                <div class="col-md-12">
                                    <div class='alert alert-info' style='padding:5px; border-radius:0px; margin-bottom:0px'>Service</div>
                                    <p class="form-control-static" id="kurirserviceinfo_<?=$item['id']?>"></p>
                                </div>
                            </div>
                        </div>
                        <div class="list">
                            <p style="float:left;">Biaya Pengiriman:</p>
                            <p id="paymentSendingPrice_<?=$item['id']?>" style="float:right;">Rp 0</p>
                            <input type="hidden" name="sendingPrice_<?=$item['id']?>" id="sendingPrice_<?=$item['id']?>" value="0">
                        </div>
                    </td>
                </tr>
                <?php } ?>
            </table>
        </div>
        <?php
        }else{ ?>
            <div class="alert alert-warning">Anda belum memiliki belanjaan. Ayo belanja dulu.</div>
        <?php 
        } 
        ?>
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