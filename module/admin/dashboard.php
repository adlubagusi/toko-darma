<!-- Begin Page Content -->
<div class="container-fluid">

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
</div>

<!-- Content Row -->
<div class="row">

  <?php 
  $data = mysqli_num_rows(mysqli_query($db,"select * from invoice where status_payment=0"));
  ?>
  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-dark shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">Pesanan Masuk</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800"><?=$data?></div>
          </div>
          <div class="col-auto">
            <i class="fas fa-calendar fa-2x text-gray-300"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php 
  $data = mysqli_num_rows(mysqli_query($db,"select * from invoice where status_payment=1"));
  ?>
  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-dark shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">Pesanan Sukses</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800"><?=$data?></div>
          </div>
          <div class="col-auto">
            <i class="fas fa-calendar fa-2x text-gray-300"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php 
  $data = mysqli_num_rows(mysqli_query($db,"select * from categories"));
  ?>
  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-dark shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">Kategori</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800"><?=$data?></div>
          </div>
          <div class="col-auto">
            <i class="fas fa-calendar fa-2x text-gray-300"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php 
  $data = mysqli_num_rows(mysqli_query($db,"select * from products"));
  ?>
  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-dark shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">Produk</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800"><?=$data?></div>
          </div>
          <div class="col-auto">
            <i class="fas fa-calendar fa-2x text-gray-300"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
  
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <div class="card shadow">
            <div class="card-header">
            Pesanan Masuk
            </div>
            <div class="card-body">
                <?php 
                $data = mysqli_query($db,"select * from invoice where status_payment=0");
                if(mysqli_num_rows($data) > 0){ ?>
                <div class="table-responsive">
                  <table class="table table-bordered" width="100%">
                      <tr>
                          <th>Invoice</th>
                          <th>Name</th>
                          <th>Total</th>
                      </tr>
                      <?php while($d = mysqli_fetch_array($data)){ ?>
                          <tr>
                              <td><?= $d['invoice_code'] ?></td>
                              <td><?= $d['name'] ?></td>
                              <td><?= number_format($d['total_all'],0,".",",") ?></td>
                          </tr>
                      <?php } ?>
                  </table>
                </div>
                <?php }else{ ?>
                    <div class="alert alert-warning">Belum ada pesanan</div>
                <?php } ?>
            </div>
        </div>
    </div>    
        <div class="col-md-6 mb-3">
        <div class="card shadow">
            <div class="card-header">
              Tentang <?= $vaGeneral['app_name']; ?>            
            </div>
            <div class="card-body">
            <?= $vaSettings['short_desc']; ?>
          </div>
        </div>
    </div>
</div>


</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

</div>
<!-- End of Content Wrapper -->