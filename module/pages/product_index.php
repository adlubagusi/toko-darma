<style>
.category-list{
    position: relative;
    height: 450px;
    overflow: hidden;
    margin-top: 20px;
}
.category-list .item {
    display: inline-block;
    width: 100%;
    padding: 10px;
    border: 0.7px solid rgba(0,0,0,.05);    
    cursor: pointer;
    background: #fff;
}
.category-list .item:hover {
    transform: translateZ(0);
    z-index: 1;
    border-color: rgba(0,0,0,.12);
    box-shadow: 0 0 0.8125rem 0 rgb(0 0 0 / 5%);
}
.category-list .item img {
    width: 50px;
    left: 30%;
}
.category-list .item p {
    width: 150px;
    text-align: center;
    color: #282828;
    float: right;
    margin-top: 10px;
}
h2.title.float-left {
    color: #222222;
    font-family: "Open Sans";
    font-size: 21px;
    font-weight: 600;
}
.product-item{
    padding: 0px;
}
.product-item .card-text{
    color: #333333;
    font-size: 15px;
    line-height: 22px;
    padding: 0 10px;
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
}
.product-item .newPrice {
    color: #2c598a;
    font-family: "Nunito";
    font-size: 15px;
    font-weight: 600;
    margin-top: 5px;
    padding: 0 10px;
}
</style>
<div class="container">
<div class="row">
    <div class="col-lg-3">
        <div class="category-list">
            <?php 
            $dbCat = mysqli_query($db,"select * from categories limit 0,5");
            while($c = mysqli_fetch_array($dbCat)){ ?>
            <a href="?c=<?= $c['link']; ?>">
                <div class="item">
                    <img src="assets/images/icon/<?= $c['icon']; ?>" alt="">
                    <p><?= $c['name']; ?></p>
                </div>
            </a>
            <?php
            }
            ?>
            <div class="item" data-toggle="modal" data-target="#modalMoreCategory">
                <img src="assets/images/icon/category-more.svg">
                <p>Lainnya</p>
            </div>
        </div>
    </div>
    <div class="col-lg-9">
        <div class="row" style="margin-top:20px;">
            <div class="col-md-12">
                <h2 class="title float-left">New product</h2>
                <a href="?page=products" class="float-right">See All ></a>
            </div>
        </div>
        <div class="row product-container">
        <?php 
        $dbProduct = mysqli_query($db,"select * from products where publish=1 order by id desc limit 0,6");
        while($dbRow = mysqli_fetch_array($dbProduct)){ 
        ?>
            <div class="col-md-3 product-item">
                <a href="?p=<?= $dbRow['link']; ?>">
                <div class="card" style="width:200px;">
                    <img src="assets/images/product/<?= $dbRow['img']; ?>" class="card-img-top" style="height: 190px; object-fit: cover;">
                    <div class="card-body" style="padding:10px;">
                        <p class="card-text line-3 mb-0"><?= $dbRow['title']; ?></p>
                        <p class="newPrice">Rp <?= $dbRow['price']; ?></p>
                    </div>
                </div>
                </a>
            </div>
        <?php
        }
        ?>
        </div>
    </div>
</div>
</div>

<!-- Modal More Category -->
<div class="modal fade" id="modalMoreCategory" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Semua Kategori</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="main-category">
            <?php
            $dbCat = mysqli_query($db,"select * from categories");
            while($c = mysqli_fetch_array($dbCat)){ ?>
            <a href="?c=<?= $c['link']; ?>">
              <div class="item">
                  <img src="assets/images/icon/<?= $c['icon']; ?>">
                  <p><?= $c['name']; ?></p>
              </div>
            </a>
            <?php } ?>
        </div>
      </div>
    </div>
  </div>
</div>