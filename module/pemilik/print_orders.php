<?php
$vaArray = $_SESSION['vaArray'];

$cTitle    = $_GET['titleorder'] ;
$dTglAwal  = (isset($_GET['tglawal'])) ? $_GET['tglawal'] : date("Y-m-01");
$dTglAkhir = (isset($_GET['tglakhir'])) ? $_GET['tglakhir'] : date("Y-m-d");
?>
<style>
@media print {
    body * {
        visibility: hidden;
    }
    #section-to-print, #section-to-print * {
        visibility: visible;
    }
    #section-to-print {
        position: absolute;
        left: 0;
        top: 0;
    }
}
</style>
<script>
        window.print();
</script>
<div class="table-responsive" id="section-to-print">
    <h4 style="text-align:center">Daftar Pesanan <?=$cTitle?></h4>
    <h5 style="text-align:center">Antara Tanggal <?=$dTglAwal?> s/d <?=$dTglAkhir?></h5>
    <table
        class="table table-bordered"
        width="100%"
        cellspacing="0"
    >
        <thead>
            <tr>
                <th>#</th>
                <th>Invoice/Tagihan</th>
                <th>Nama</th>
                <th>Total Pesanan</th>
                <th>Tanggal</th>
                <th>Status Pembayaran</th>
                <th>Status Pengiriman</th>
                <!-- <th>Aksi</th> -->
            </tr>
        </thead>
        <tfoot></tfoot>
        <tbody class="value-content">
            <?php 
            $no = 1;
            foreach($vaArray as $key=>$value){ 
            ?>
            <tr>
                <td><?= $no; ?></td>
                <td><?= $value['invoice_code']; ?></td>
                <td><?= $value['name']; ?></td>
                <td>Rp <?= number2String($value['total_all']); ?></td>
                <td><?= $value['date_input']; ?></td>							
                <?php if($value['status_payment'] == 1){ ?>
                    <td><span class="badge badge-success">Lunas</span></td>
                <?php
                    }else{ 
                        if($value['bukti_transfer'] <> ""){
                ?>
                    <td><span class="badge badge-info">Bukti Transfer Tersedia</span></td>
                <?php
                        }else{
                ?>
                    <td><span class="badge badge-danger">Menunggu Pembayaran</span></td>
                <?php
                        }
                    } 
                ?>
                <?php 
                    if($value['status_delivery'] == 3){ 
                ?>
                    <td><span class="badge badge-success">Pesanan Diterima</span></td>
                <?php 
                    }elseif($value['status_delivery'] == 2){ 
                ?>
                    <td><span class="badge badge-info">Dikirim</span></td>
                <?php
                    }else if($value['status_delivery'] == 1){
                ?>
                    <td><span class="badge badge-warning">Dikemas</span></td>
                <?php        
                    }else{ ?>
                    <td><span class="badge badge-danger">Belum Dikirim</span></td>
                <?php } ?>
                <!-- <td>
                    <a href="?page=orders&invoice=<?= $value['invoice_code']; ?>" class="btn btn-sm btn-info"><i class="fa fa-eye"></i></a>
                </td> -->
            </tr>
            <?php
                $vaArray[] = $value;
                $no++;
            }
            ?>
        </tbody>
    </table>
</div>