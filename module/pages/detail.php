<?php
$cLink  = $_GET['p'];
$dbData = mysqli_query($db,"select p.*,p.id AS productId, p.link AS linkP,c.name,c.link
                        from products p
                        left join categories c on p.category=c.id 
                        where p.link='$cLink' group by p.id desc");
$vaProduct  = mysqli_fetch_array($dbData);

$vaRating = array();
$dbRating = mysqli_query($db,"select * from rating where id_product='{$vaProduct['productId']}'");
while($dbRow = mysqli_fetch_array($dbRating)){
    $vaRating[] = $dbRow;
}
?>
<div class="wrapper">
    <div class="navigation">
        <a href="index.php">Home</a>
        <i class="fa fa-caret-right"></i>
        <a href="?c=<?= $vaProduct['link']; ?>"><?= $vaProduct['name']; ?></a>
        <i class="fa fa-caret-right"></i>
        <a><?= $vaProduct['title']; ?></a>
    </div>
    <div class="top">
        <div class="main-top">
            <div class="img">
                <a href="assets/images/product/<?= $vaProduct['img']; ?>" data-lightbox="img-1">
                    <img src="assets/images/product/<?= $vaProduct['img']; ?>" alt="Product" class="jumbo-thumb">
                </a>
                <div class="img-slider">
                    <img src="assets/images/product/<?= $vaProduct['img']; ?>" alt="gambar" class="thumb">
                    <?php 
                    $dbImg = mysqli_query($db,"select * from img_product where id_product='{$vaProduct['productId']}'");
                    while($vaImg = mysqli_fetch_array($dbImg)){ ?>
                        <img src="assets/images/product/<?= $vaImg['img']; ?>" alt="gambar" class="thumb">
                    <?php } ?>
                </div>
            </div>
            <div class="ket">
                <h1 class="title"><?= $vaProduct['title']; ?></h1>
                <p class="subtitle">
                    Terjual <?= $vaProduct['transaction']; ?> Produk &bull; <?= $vaProduct['viewer'] + 1; ?>x Dilihat<br>
                    Dikirim dari <?= $vaProduct['region']?>
                </p>
                <hr>
                <div class="alert alert-dismissible alert-success">
                    Untuk cek ongkir, silahkan klik <a href="https://berdu.id/cek-ongkir" target="_blank" class="alert-link">disini</a>.
                </div>
                <table>
                    <tr>
                        <td class="t">Harga</td>
                        <td class="price">Rp <?= $vaProduct['price']; ?></td>
                    </tr>
                    <tr>
                        <td class="t">Kondisi</td>
                        <?php if($vaProduct['condit'] == 1){ ?>
                            <td>Baru</td>
                        <?php }else{ ?>
                            <td>Bekas</td>
                        <?php } ?>
                    </tr>
                    <tr>
                        <td class="t">Berat</td>
                        <td><?= $vaProduct['weight']; ?> gram</td>
                    </tr>
                    <tr>
                        <td class="t">Stok</td>
                        <td><?= $vaProduct['stock']; ?> produk</td>
                    </tr>
                    <?php if($vaProduct['stock'] > 0){ ?>
                    <tr>
                        <?php $priceP = $vaProduct['price']; ?>
                        <td class="t">Stok</td>
                        <td>
                            <button onclick="minusProduct('<?= $priceP; ?>')">-</button><!--
                        --><input disabled type="text" value="1" id="qtyProduct" class="valueJml"><!--
                        --><button onclick="plusProduct('<?= $priceP; ?>', '<?= $vaProduct['stock']; ?>')">+</button>
                        </td>
                    </tr>
                    <tr>
                        <td class="t">Total</td>
                        <td>Rp <span id="detailTotalPrice"><?= $priceP; ?></span></td>
                    </tr>
                    <?php } ?>
                </table>
                <hr>
                <?php 
                if($vaProduct['stock'] > 0){ 
                    if(!isset($_SESSION['user_id'])){
                ?>
                <button class="btn btn-warning pl-5 pr-5" onclick="login_first()">Beli Sekarang</button>
                <button class="btn btn-primary" onclick="login_first()">Masukkan Keranjang</button>
                <?php       
                    }else{
                ?>
                <button class="btn btn-warning pl-5 pr-5" onclick="buy()">Beli Sekarang</button>
                <button class="btn btn-primary" onclick="addCart()">Masukkan Keranjang</button>
                <?php
                    }
                ?>
                <?php }else{ ?>
                <p class="btn btn-outline-secondary">Stok Habis</p>
                <?php } ?>
            </div>
        </div>
    </div>
    <hr>
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="deskripsi-tab" data-toggle="tab" href="#deskripsi" role="tab" aria-controls="deskripsi" aria-selected="true">Deskripsi</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="komentar-tab" data-toggle="tab" href="#komentar" role="tab" aria-controls="komentar" aria-selected="false">Review</a>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="deskripsi" role="tabpanel" aria-labelledby="deskripsi-tab">
            <div class="description">
                <?= nl2br($vaProduct['description']); ?>
            </div>
        </div>
        <div class="tab-pane fade" id="komentar" role="tabpanel" aria-labelledby="komentar-tab">
            <div class="comments-area">
                <h4><?=count($vaRating)?> Review</h4>
                <?php
                // echo "<pre>";
                // print_r($vaRating);
                foreach($vaRating as $key=>$value){
                ?>
                <div class="comment-list">
                    <div class="single-comment justify-content-between d-flex" style="border-bottom: 1px solid #eee;">
                        <div class="user justify-content-between d-flex">
                            <div class="thumb" style="width: 40px;height: 50px;;">
                                <img src="assets/images/user.png" alt="" style="width: 100%;height: 100%;">
                            </div>
                            <div class="desc">
                                <div class="side-left">
                                    <h5><a href="#"><?=$value['nama']?></a></h5>
                                    <p class="date"><?=$value['datetime']?> </p>
                                </div>
                                <div class="side-right">
                                    <p class="comment">
                                        <fieldset class="rating">
                                            <span id="stars<?=$value['ID']?>">
                                                <script>
                                                    function getStars(id,rating) {
                                                        rating = Math.round(rating * 2) / 2;
                                                        let output = [];
                                                        for (var i = rating; i >= 1; i--)
                                                        output.push('<i class="fa fa-star" aria-hidden="true" style="color: gold;"></i>&nbsp;');
                                                        if (i == .5) output.push('<i class="fa fa-star-half-o" aria-hidden="true" style="color: gold;"></i>&nbsp;');
                                                        for (let i = (5 - rating); i >= 1; i--)
                                                        output.push('<i class="fa fa-star-o" aria-hidden="true" style="color: gold;"></i>&nbsp;');
                                                        document.getElementById("stars"+id).innerHTML = output.join('');
                                                    }
                                                    getStars('<?=$value['ID']?>','<?=$value['rating']?>');
                                                </script>
                                            </span>
                                        </fieldset>
                                        <?php echo $value['deskripsi'];?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
    <hr>
</div>

<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script>
    function plusProduct(price, stock){
        let inputJml;
        inputJml = parseInt($("input.valueJml").val());
        inputJml = inputJml + 1;
        if(inputJml <= stock){
            $("input.valueJml").val(inputJml);
            const newPrice = inputJml * price;
            const rpFormat = convertToNumberDetail(price, inputJml);
            $("#detailTotalPrice").text(rpFormat);
        }
    }

    function minusProduct(price){
        let inputJml;
        inputJml = parseInt($("input.valueJml").val());
        inputJml = inputJml - 1;
        if(inputJml >= 1){
            $("input.valueJml").val(inputJml);
            const newPrice = inputJml * price;
            const rpFormat = convertToNumberDetail(price, inputJml);
            $("#detailTotalPrice").text(rpFormat);
        }
    }
    
    function convertToNumberDetail(string, multiplier){
        let number = string.replace(',', '').replace('.','');
        number = parseInt(number);
        number = number/100;
        number = number * multiplier;
        const formatter = new Intl.NumberFormat('id-ID', {
            minimumFractionDigits: 2
        })
        number = formatter.format(number);
        return number;
    }

    function number_format (number, decimals, decPoint, thousandsSep) {
        number = (number + '').replace(/[^0-9+\-Ee.]/g, '')
        var n = !isFinite(+number) ? 0 : +number
        var prec = !isFinite(+decimals) ? 0 : Math.abs(decimals)
        var sep = (typeof thousandsSep === 'undefined') ? ',' : thousandsSep
        var dec = (typeof decPoint === 'undefined') ? '.' : decPoint
        var s = ''

        var toFixedFix = function (n, prec) {
        var k = Math.pow(10, prec)
        return '' + (Math.round(n * k) / k)
            .toFixed(prec)
        }

        // @todo: for IE parseFloat(0.55).toFixed(0) = 0;
        s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.')
        if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep)
        }
        if ((s[1] || '').length < prec) {
        s[1] = s[1] || ''
        s[1] += new Array(prec - s[1].length + 1).join('0')
        }

        return s.join(dec)
    }
    function login_first(){
        location.href = "login.php"
    }

    function buy(){
        $.ajax({
            url: "?page=cart",
            type: "post",
            data: {
                id: <?= $vaProduct['productId']; ?>,
                qty: $("#qtyProduct").val(),
                action: 'add_to_cart'
            },
            success: function(data){
                location.href = "?page=cart"
            }
        })
    }

    function addCart(){
        $.ajax({
            url: "?page=cart",
            type: "post",
            data: {
                id: <?= $vaProduct['productId']; ?>,
                qty: $("#qtyProduct").val(),
                action: 'add_to_cart'
            },
            success: function(data){
                $(".navbar-cart-inform").html(`<i class="fa fa-shopping-cart"></i> Cart(1)`);
                swal({
                    title: "Berhasil Ditambahkan ke Keranjang",
                    text: `<?= $vaProduct['title']; ?>`,
                    icon: "success",
                    buttons: true,
                    buttons: ["Lanjutkan Belanja", "Lihat Keranjang"],
                    })
                    .then((cart) => {
                    if (cart) {
                        location.href = "?page=cart"
                    }
                });
            }
        })
    }

    // slider product
    const containerImgProduct = document.querySelector("div.wrapper div.top div.main-top div.img");
    const jumboImgProduct = document.querySelector("div.wrapper div.top div.main-top div.img img.jumbo-thumb");
    const jumboHrefImgProduct = document.querySelector("div.wrapper div.top div.main-top div.img a");
    const thumbsImgProduct = document.querySelectorAll("div.wrapper div.top div.main-top div.img div.img-slider img.thumb");
    
    containerImgProduct.addEventListener('click', function(e){
        if(e.target.className == 'thumb'){
            jumboImgProduct.src = e.target.src;
            jumboHrefImgProduct.href = e.target.src;
            
            thumbsImgProduct.forEach(function(thumb){
                thumb.className = 'thumb';
            })
        }
    })

    

</script>
