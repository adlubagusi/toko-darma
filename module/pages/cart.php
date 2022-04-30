<?php
$cIdUser = $_SESSION['user_id'];
if(isset($_POST['action'])){
    if($_POST['action'] == "add_to_cart"){
        $cId     = $_POST['id'];
        $nQty    = $_POST['qty'];
        $dbProduct = mysqli_query($db,"select * from products where id='$cId'");
        if($vaProduct = mysqli_fetch_array($dbProduct)){
            $nPrice   = string2Number($vaProduct['price']);
            mysqli_query($db,"insert into cart (id_product,id_user,name,price,qty,img,link,weight,ket) values ('$cId','$cIdUser','{$vaProduct['title']}',
                            '$nPrice','$nQty','{$vaProduct['img']}','{$vaProduct['link']}','{$vaProduct['weight']}','')");
        }
    }
}
if(isset($_GET['action'])){
    if($_GET['action'] == "delete_cart"){
        mysqli_query($db,"delete from cart where id_user='$cIdUser'");
        echo "<script>window.location.href = 'index.php?page=cart';</script>";
    }else if($_GET['action'] == "add_ket"){
        $cId = $_POST['rowid'];
        $cKet = $_POST['ket'];
        
        mysqli_query($db,"update cart set ket='$cKet' where id='$cId'");
    }else if($_GET['action'] == "get_item"){
        $cId = $_POST['rowid'];
        $dbCart = mysqli_query($db,"select * from cart where id='$cId'");
        if($vaCart = mysqli_fetch_array($dbCart)){
            echo json_encode($vaCart);
            exit;
        }
    }
}
if(isset($_GET['delete'])){
    $cId = $_GET['delete'];
    mysqli_query($db,"delete from cart where id='$cId'");
    echo "<script>window.location.href = 'index.php?page=cart';</script>";
}
?>
<link rel="stylesheet" type="text/css" href="assets/css/cart.css">
<div class="wrapper">
    <div class="navigation">
        <a href="index.php">Home</a>
        <i class="fa fa-caret-right"></i>
        <a>Cart</a>
    </div>
    <div class="core mt-4">
        <div class="product">
            <?php 
            $dbCart = mysqli_query($db,"select * from cart where id_user='$cIdUser'");
            if(mysqli_num_rows($dbCart) > 0){
                $nTotalPrice = 0;
                while($item = mysqli_fetch_array($dbCart)){
                    $nSubTotal = $item['price'] * $item['qty'];
            ?>
            <div class="item">
                <div class="item-main">
                    <img src="assets/images/product/<?= $item['img']; ?>" alt="">
                    <a href="?p=<?= $item['link']; ?>"><h2 class="title mb-0"><?= $item['name']; ?></h2></a>
                    <small class="text-muted">Qty: <?= $item['qty']; ?></small>
                    <h3 class="price mt-0 mb-0">Rp <script>document.write(convertToNumber('<?= $nSubTotal ?>'))</script></h3>
                    <?php if($item['ket'] == ''){ ?>
                        <small class="desc_product_<?= $item['id']; ?>"><a href="#" class="text-dark" data-toggle="modal" data-target="#modalAddDescription" onclick="showModalAddKet('<?= $item['id']; ?>')">Tambahkan deskripsi</a></small>
                    <?php }else{ ?>
                        <small class="desc_product_<?= $item['id']; ?>">Info: <?= $item['ket']; ?> <a href="#" class="text-dark" data-toggle="modal" data-target="#modalEditDescription" onclick="showModalEditKet('<?= $item['id']; ?>')"><i class="fa text-info fa-edit"></i></a></small>
                    <?php } ?>
                    <div class="clearfix"></div>
                </div>
                <a href="?page=cart&delete=<?= $item['id']; ?>" onclick="return confirm('Are you sure you want to remove this product from your cart?')"><i class="fa fa-trash"></i></a>
            </div>
            <hr>
            <?php 
                $nTotalPrice +=$nSubTotal;    
            } 
            ?>
            <a href="?page=cart&action=delete_cart" onclick="return confirm('Are you sure you want to empty the Cart?')"><button class="btn btn-outline-dark">Empty the Cart</button></a>
            <?php }else{ ?>
                <div class="alert alert-warning">Keranjang masih kosong. Ayo belanja dulu..</div>
                <br><br><br>
            <?php } ?>
        </div>
        <div class="total shadow">
            <h2 class="title">Ringkasan Belanja</h2>
            <hr>
            <div class="list">
                <p>Total Items</p>
                <p><?= mysqli_num_rows($dbCart);?></p>
            </div>
            <script>
                
            </script>
            <div class="list">
                <p>Total Price</p>
                <p>Rp <script>document.write(convertToNumber('<?=$nTotalPrice;?>'))</script></p>
            </div>
            <?php if(mysqli_num_rows($dbCart)){ ?>
                <a href="?page=payment">
                    <button class="btn btn-dark btn btn-block mt-2">Continue to Payment</button>
                </a>
            <?php }else{ ?>
                <a href="index.php">
                    <button class="btn btn-dark btn btn-block mt-2">Belanja dulu</button>
                </a>
            <?php } ?>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="modalEditDescription" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalCenterTitle">Edit Description</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body" id="bodyModalEditKet">
            
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="btnEditKetProduct" data-dismiss="modal">Save</button>
        </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalAddDescription" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalCenterTitle">Add Description</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body" id="bodyModalAddKet">
            
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="btnSaveKetProduct" data-dismiss="modal">Save</button>
        </div>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script>

    function showModalAddKet(id){
        $("#bodyModalAddKet").html(`<div class="form-group">
            <textarea name="ket_product" id="ket_product" class="form-control form-control-sm" placeholder="Model, size, color, etc."></textarea>
            <input type="hidden" id="rowid_pro" value=${id}>
        </div>`);
    }

    function showModalEditKet(id){
        $.ajax({
            url: "?page=cart&action=get_item",
            type: "post",
            dataType: "json",
            data: {
                rowid: id
            },
            success: function(res){
                $("#bodyModalEditKet").html(`<div class="form-group">
                    <textarea name="ket_product" id="ket_product_edit" class="form-control form-control-sm" placeholder="Model, size, color, etc.">${res.ket}</textarea>
                    <input type="hidden" id="rowid_pro_edit" value=${id}>
                </div>`);      
            }
        })
    }

    $("#btnSaveKetProduct").on('click', function(){
        const rowid  = $("#rowid_pro").val();
        const ket    = $("#ket_product").val();
        $.ajax({
            url: "?page=cart&action=add_ket",
            type: "post",
            data: {
                rowid: rowid,
                ket: ket
            },
            success: function(){
                $("small.desc_product_"+rowid).html("ket: " + ket + ` <a href="#" class="text-dark" data-toggle="modal" data-target="#modalEditDescription" onclick="showModalEditKet('${rowid}')"><i class="fa text-info fa-edit"></i></a>`);
            }
        })
    })

    $("#btnEditKetProduct").on('click', function(){
        const rowid = $("#rowid_pro_edit").val();
        const ket = $("#ket_product_edit").val();
        $.ajax({
            url: "?page=cart&action=add_ket",
            type: "post",
            data: {
                rowid: rowid,
                ket: ket
            },
            success: function(){
                $("small.desc_product_"+rowid).html("ket: " + ket + ` <a href="#" class="text-dark" data-toggle="modal" data-target="#modalEditDescription" onclick="showModalEditKet('${rowid}')"><i class="fa text-info fa-edit"></i></a>`);
            }
        })
    })

</script>