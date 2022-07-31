<?php   
  if(isset($_GET['action']) || isset($_POST['action'])){
    include $page;
    exit;
  }
    $dbSettings    = mysqli_query($db,"select * from settings");
    $vaSettings    = mysqli_fetch_array($dbSettings);
    $dbGeneral     = mysqli_query($db,"select * from general");
    $vaGeneral     = mysqli_fetch_array($dbGeneral);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title><?= $vaGeneral['app_name'];?></title>

    <!-- Custom fonts for this template-->
    <link
      href="assets/vendor/fontawesome-free/css/all.min.css"
      rel="stylesheet"
      type="text/css"
    />
    <link
      href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
      rel="stylesheet"
    />

    <link rel="shortcut icon" href="assets/images/logo/favicon.png" type="image/x-icon">

    <!-- Custom styles for this template-->
    <link href="assets/css/sb-admin-2.min.css" rel="stylesheet" />

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <link rel="stylesheet" href="assets/select2-4.0.6-rc.1/dist/css/select2.min.css">
    <script src="https://cdn.ckeditor.com/ckeditor5/18.0.0/classic/ckeditor.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.11.5/datatables.min.css"/>

    <link
      rel="shortcut icon"
      href="assets/images/logo/<?= $vaSettings['favicon']; ?>"
      type="image/x-icon"
    />


    <style>

      /* Chrome, Safari, Edge, Opera */
      input::-webkit-outer-spin-button,
      input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
      }

      /* Firefox */
      input[type=number] {
        -moz-appearance: textfield;
      }

      .ck-editor__editable_inline {
          min-height: 300px;
      }

      .description-product-detail {
        color: #666;
      }

      .description-product-detail h2 {
        font-size: 22px;
      }

      .description-product-detail h3 {
        font-size: 19px;
      }

      .description-product-detail h4 {
        font-size: 17px;
      }

      .description-product-detail p {
        font-size: 14.5px;
      }

      .description-product-detail img {
        width: 50%;
      }

    </style>

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  </head>

  <body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
      <!-- Sidebar -->
      <ul
        class="navbar-nav bg-gradient-dark sidebar sidebar-dark accordion"
        id="accordionSidebar"
      >
        <!-- Sidebar - Brand -->
        <a
          class="sidebar-brand d-flex align-items-center justify-content-center"
          href="?page=home"
        >
          <div class="sidebar-brand-icon rotate">
            <i class="fa fa-shopping-cart"></i>
          </div>
          <div class="sidebar-brand-text mx-3">ADMIN PANEL</div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0" />

        <!-- Nav Item - Dashboard -->
        <li class="nav-item">
          <a class="nav-link" href="?page=home">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a
          >
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider" />

        <?php $orders = mysqli_num_rows(mysqli_query($db,"select * from invoice where status_payment=0")); ?>
        <li class="nav-item">
          <a class="nav-link" href="?page=orders">
            <i class="fas fa-fw fa-shopping-cart"></i>
            <span>Pesanan</span> <small class="badge badge-warning"><?=$orders?> baru</small></a
          >
        </li>

        <li class="nav-item">
          <a class="nav-link" href="?page=categories">
            <i class="fas fa-fw fa-tag"></i>
            <span>Kategori</span></a
          >
        </li>

        <li class="nav-item">
          <a class="nav-link" href="?page=products">
            <i class="fas fa-fw fa-box-open"></i>
            <span>Produk</span></a
          >
        </li>

        <li class="nav-item">
          <a class="nav-link" href="?page=settings">
            <i class="fas fa-fw fa-cog"></i>
            <span>Pengaturan</span></a
          >
        </li>

        <br />

        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block" />

        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
          <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>
      </ul>
      <!-- End of Sidebar -->

      <!-- Content Wrapper -->
      <div id="content-wrapper" class="d-flex flex-column">
        <!-- Main Content -->
        <div id="content">
          <!-- Topbar -->
          <nav
            class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow"
          >
            <!-- Sidebar Toggle (Topbar) -->
            <button
              id="sidebarToggleTop"
              class="btn btn-link d-md-none rounded-circle mr-3"
            >
              <i class="fa fa-bars"></i>
            </button>

            <!-- Topbar Search -->
            <!-- <form
              class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search"
            >
              <div class="input-group">
                <input
                  type="text"
                  class="form-control bg-light border-0 small"
                  placeholder="Search for..."
                  name="search"
                />
                <div class="input-group-append">
                  <button class="btn btn-primary" type="submit">
                    <i class="fas fa-search fa-sm"></i>
                  </button>
                </div>
              </div>
            </form> -->

            <!-- Topbar Navbar -->
            <ul class="navbar-nav ml-auto">
              <!-- Nav Item - User Information -->
              <li class="nav-item dropdown no-arrow">
                <a
                  class="nav-link dropdown-toggle"
                  href="#"
                  id="userDropdown"
                  role="button"
                  data-toggle="dropdown"
                  aria-haspopup="true"
                  aria-expanded="false"
                >
                  <span class="mr-2 d-none d-lg-inline text-gray-600 small"
                    >Login as <?= $_SESSION['name']?></span
                  >
                </a>
                <!-- Dropdown - User Information -->
                <div
                  class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                  aria-labelledby="userDropdown"
                >
                  <a class="dropdown-item" href="?page=profile">
                    <i
                      class="fas fa-user-edit fa-sm fa-fw mr-2 text-gray-400"
                    ></i>
                    Edit Profile
                  </a>
                  <a
                    class="dropdown-item"
                    href="#"
                    data-toggle="modal"
                    data-target="#logoutModal"
                  >
                    <i
                      class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"
                    ></i>
                    Logout
                  </a>
                </div>
              </li>
            </ul>
          </nav>
          <!-- End of Topbar -->

            <?php include $page;?>
          </div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
  <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Sure you want logout</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">Choose "Logout" below when you are ready to end your current session.</div>
      <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
        <a class="btn btn-primary" href="logout.php">Logout</a>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap core JavaScript-->
<script src="assets/vendor/jquery/jquery.min.js"></script>
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="assets/vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="assets/js/sb-admin-2.min.js"></script>

<!-- Page level plugins -->
<script src="assets/vendor/chart.js/Chart.min.js"></script>
<script src="assets/select2-4.0.6-rc.1/dist/js/select2.min.js"></script>
<script src="assets/plentz-jquery-maskmoney-cdbeeac/dist/jquery.maskMoney.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.11.5/datatables.min.js"></script>
<!-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/scroller/2.0.5/js/dataTables.scroller.min.js"></script> -->

<script>

ClassicEditor
.create( document.querySelector( '#descriptionEditor' ) )
.then( editor => {
        console.log( editor );
} )
.catch( error => {
        console.error( error );
} );

$('#dataTable').DataTable( {
            deferRender:    true,
            // scrollY:        800,
            scrollCollapse: true,
            scroller:       true
        } );

$("#sendMailTo").select2({
    placeholder: 'Choose a Destination',
    language: 'id'
})

$("#selectProductForAddPackage").select2({
    placeholder: 'Select Product',
    language: 'id'
})

$(".input-money").maskMoney();
$("#showModalBodyAddPromo .input-money-hide").maskMoney();

$('#modalInfoForDemoMode').modal('show');


$("#selectProvince").select2({
    allowClear: true,
    placeholder: 'Select Province',
    language: 'id',
    ajax: {
        url: "?page=products&action=getprovice",
        dataType: 'json',
        delay: 250,
        processResults: function (data) {
            return {
                results: data
            };
        },
        cache: true
    }
});
$("#selectProvince").change(getCity);
function getCity(){
    const id = $("#selectProvince").val();
    $("#selectCity").select2({
        allowClear: true,
        placeholder: 'Select City',
        language: 'id',
        ajax: {
            url: "?page=products&action=getcity&id_province="+id,
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: data
                };
            },
            cache: true
        }
    });
}
function setSelect2(selector, id, text){
    $(selector)
      .find('option')
      .remove()
      .end()
      .append('<option value="'+id+'">'+text+'</option>');
}
<?php
if(isset($province_id)){
?>
setSelect2("#selectProvince",'<?=$province_id?>','<?=$province_text?>');
<?php
}
if(isset($city_id)){
?>
setSelect2("#selectCity",'<?=$city_id?>','<?=$city_text?>');
<?php
}
?>
</script>

</body>

</html>
