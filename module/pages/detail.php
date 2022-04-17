<?php
$cLink  = $_GET['p'];
$dbData = mysqli_query($db,"select p.*,p.id AS productId, p.link AS linkP,c.name,c.link
                        from products p
                        left join categories c on p.category=c.id 
                        where p.link='$cLink' group by p.id desc");
$vaProduct  = mysqli_fetch_array($dbData);
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
                <p class="subtitle">Terjual <?= $vaProduct['transaction']; ?> Produk &bull; <?= $vaProduct['viewer'] + 1; ?>x Dilihat</p>
                <hr>
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
                <?php if($vaProduct['stock'] > 0){ ?>
                <button class="btn btn-warning pl-5 pr-5" onclick="buy()">Beli Sekarang</button>
                <button class="btn btn-primary" onclick="addCart()">Masukkan Keranjang</button>
                <?php }else{ ?>
                <p class="btn btn-outline-secondary">Out of stock</p>
                <?php } ?>
            </div>
        </div>
    </div>
    <hr>
    <div class="description">
        <?= nl2br($vaProduct['description']); ?>
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
        const formatter = new Intl.NumberFormat('en-US', {
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

    function buy(){
        $.ajax({
            url: "modules/pages/cart",
            type: "post",
            data: {
                id: <?= $vaProduct['productId']; ?>,
                qty: $("#qtyProduct").val(),
                action: 'buy'
            },
            success: function(data){
                location.href = "cart"
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
                console.log(data);
                $(".navbar-cart-inform").html(`<i class="fa fa-shopping-cart"></i> Cart(1)`);
                swal({
                    title: "Successfully Added to Cart",
                    text: `<?= $vaProduct['title']; ?>`,
                    icon: "success",
                    buttons: true,
                    buttons: ["Continue Shopping", "View Cart"],
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
