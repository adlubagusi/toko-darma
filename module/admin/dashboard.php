<!-- Begin Page Content -->
<div class="container-fluid">

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
</div>

<!-- Content Row -->
<div class="row">

  <?php //$data = $this->db->get_where('invoice', ['status' => 0])->num_rows(); ?>
  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-dark shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">Pesanan Masuk</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800">15</div>
          </div>
          <div class="col-auto">
            <i class="fas fa-calendar fa-2x text-gray-300"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-dark shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">Pesanan Sukses</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800">5</div>
          </div>
          <div class="col-auto">
            <i class="fas fa-calendar fa-2x text-gray-300"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php //$data = $this->db->get('categories')->num_rows(); ?>
  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-dark shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">Kategori</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800">8</div>
          </div>
          <div class="col-auto">
            <i class="fas fa-calendar fa-2x text-gray-300"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php //$data = $this->db->get('products')->num_rows(); ?>
  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-dark shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">Produk</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800">10</div>
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
            Orders In
            </div>
            <div class="card-body">
                                <div class="table-responsive">
                  <table class="table table-bordered" width="100%">
                      <tbody><tr>
                          <th>Invoice</th>
                          <th>Name</th>
                          <th>Total</th>
                      </tr>
                                                <tr>
                              <td>981165</td>
                              <td>Tes</td>
                              <td>1.562.500</td>
                          </tr>
                                        </tbody></table>
                </div>
                            </div>
        </div>
    </div>    
        <div class="col-md-6 mb-3">
        <div class="card shadow">
            <div class="card-header">
            About Mooi            </div>
            <div class="card-body">
                Mooi is an easy and reliable online shop site. We have a physical shop that you can visit. Here sells a variety of computers, gadgets, and men's and women's clothing                <hr>
                Denpasar, Bali            </div>
        </div>
    </div>
</div>


</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

</div>
<!-- End of Content Wrapper -->