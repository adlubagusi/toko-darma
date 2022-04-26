
<div class="category-menu">
    <div class="main-category">
      <div class="item" data-toggle="modal" data-target="#modalMoreCategory">
          <img src="assets/images/icon/category-more.svg">
          <p>Others</p>
      </div>
      <?php 
        $dbCat = mysqli_query($db,"select * from categories limit 0,7");
        while($c = mysqli_fetch_array($dbCat)){ ?>
        <a href="?c=<?= $c['link']; ?>">
          <div class="item">
              <img src="assets/images/icon/<?= $c['icon']; ?>">
              <p><?= $c['name']; ?></p>
          </div>
        </a>
      <?php }; ?>
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

  <br><br>
<div class="product-wrapper best-product">
  <h2 class="title float-left">New product</h2>
  <a href="?page=products" class="float-right">See All ></a>
  <img src="" class="banner-package" alt="banner" style="width: 100%; opacity: 0; object-fit: cover">
  <div class="main-product">
  <?php 
    $dbProduct = mysqli_query($db,"select * from products where publish=1 order by id desc limit 0,6");
    while($dbRow = mysqli_fetch_array($dbProduct)){ ?>
        <div>
            <a href="?p=<?= $dbRow['link']; ?>">
            <div class="card">
                <img src="assets/images/product/<?= $dbRow['img']; ?>" class="card-img-top" style="height: 190px; object-fit: cover;">
                <div class="card-body">
                    <p class="card-text line-3 mb-0"><?= $dbRow['title']; ?></p>
                    <p class="newPrice">Rp <?= $dbRow['price']; ?></p>
                </div>
            </div>
            </a>
        </div>
    <?php } ?>
    <div class="clearfix"></div>
  </div>
</div>