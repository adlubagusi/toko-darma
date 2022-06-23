<?php
$dbProduct = mysqli_query($db,"select * from products whre publish=1");
$ob     = isset($_GET['ob']) ? $_GET['ob'] : null;
$cTitleHead = "";
$cOrderBy   = "id";
if($ob != NULL){
    if($ob == "latest"){
       $cTitleHead = 'Sort > Latest';
        $cOrderBy = "id desc";
    }else if($ob == "az"){
       $cTitleHead = 'Sort > Alphabet A-Z';
        $cOrderBy = "title asc";
    }else if($ob == "za"){
       $cTitleHead = 'Sort > Alphabet Z-A';
        $cOrderBy = "title desc";
    }else if($ob == "pmin"){
       $cTitleHead = 'Sort > Lowest Price';
    }else if($ob == "pmax"){
       $cTitleHead = 'Sort > Highest Price';
    }
}
$dbProduct = mysqli_query($db,"select * from products where publish=1 order by $cOrderBy");

?>
<style>
  div.wrapper div.core div.main-product div.card:hover div.card-body p.card-text {
    color: #282828>;
  }

</style>
<div class="wrapper">
    <div class="title-head">
        <?php if($cTitleHead == ""){ ?>
            <h2 class="title">All products</h2>
        <?php }else{ ?>
            <h2 class="title">All products > <?= $cTitleHead ?></h2>
        <?php } ?>
    </div>
    <div class="core">
        <div class="filter">
            <div class="filter-main">
                <div class="top">
                    <p>Filter</p>
                </div>
                <div class="bodf">
                    <p class="title">
                    Sort
                    </p>
                    <a href="?page=products&ob=latest">Latest</a>
                    <a href="?page=products&ob=az">Alphabet A-Z</a>
                    <a href="?page=products&ob=za">Alphabet Z-A</a>
                    <hr>
                    <p class="title">
                    Condition
                    </p>
                    <a href="?page=products&condition=1">New</a>
                    <a href="?page=products&condition=2">Second</a>
                    <hr>
                    <a href="products" class="btn btn-danger text-light btn-sm">Reset Filter</a>
                </div>
            </div>
        </div>
        <div class="main-product">
            <?php if(mysqli_num_rows($dbProduct) > 0){ ?>
            <?php while($p = mysqli_fetch_array($dbProduct)){ ?>
                <a href="?p=<?= $p['link']; ?>">
                <div class="card">
                    <img src="assets/images/product/<?= $p['img']; ?>" class="card-img-top" style="height: 190px; object-fit: cover;">
                    <div class="card-body">
                        <p class="card-text line-3 mb-0"><?= $p['title']; ?></p>
                        <p class="newPrice" style="color: #00aeef;">Rp <?= $p['price']; ?></p>
                    </div>
                </div>
                </a>
            <?php }; ?>
            <div class="clearfix"></div>
            <?php }else{ ?>
                <div class="alert alert-warning">Oops. There are no products to display</div>
            <?php } ?>
        </div>
    </div>
</div>