<?php
$vaArray = $_SESSION['vaArray'];

$dTglAwal  = (isset($_GET['tglawal'])) ? $_GET['tglawal'] : date("Y-m-01");
$dTglAkhir = (isset($_GET['tglakhir'])) ? $_GET['tglakhir'] : date("Y-m-d");
?>
<style>
table tr td.align-right{
    text-align:right;
}
/* table tfoot td{
    font-weight:bold;
} */
hr{
    width: 210px;
    float: left;
}
@media print {
    body * {
        visibility: hidden;
    }
    #section-to-print, #section-to-print * {
        visibility: visible;
        overflow: hidden;
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
    <h4 style="text-align:center">Laba/Rugi Penjualan</h4>
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
                <th>Barang</th>
                <th>Tanggal</th>
                <th>Harga Beli</th>
                <th>Harga Jual</th>
                <th>Laba/Rugi</th>
            </tr>
        </thead>
        <tbody class="data-content">
            <?php 
            $no = 1;
            $nTotalPendapatan = 0;
            $nTotalBiaya      = 0;
            $nTotalLabaRugi   = 0;
            foreach($vaArray as $key=>$value){ 
                $cProductName = $value['product_name'];
                if(strlen($cProductName) > 20){
                    $cProductName = substr($cProductName,0,20)."...";
                }
                $nTotalPendapatan += $value['price'];
                $nTotalBiaya      += $value['purchase_price'];
                $nLabaRugi         = $value['price'] - $value['purchase_price'] ;
                $nTotalLabaRugi   += $nLabaRugi
            ?>
            <tr>
                <td><?= $no; ?></td>
                <td><?= $value['id_invoice']; ?></td>
                <td><?= $cProductName; ?></td>
                <td><?= date("d-m-Y H:i:s",strtotime($value['date_input'])); ?></td>
                <td class="align-right"><?= number2String($value['purchase_price']); ?></td>
                <td class="align-right"><?= number2String($value['price']); ?></td>
                <td class="align-right"><?= number2String($nLabaRugi)?></td>
                
            </tr>
            <?php
                $no++;
            } 
            
            ?>
        </tbody>
    </table>
    <div class="row">
        <div class="col-md-4">
            <table>
                <tr>
                    <td>Total Pendapatan</td>
                    <td>:</td>
                    <td class="align-right"><?= number2String($nTotalPendapatan)?></td>
                </tr>
                <tr>
                    <td>Total Biaya</td>
                    <td>:</td>
                    <td class="align-right"><?= number2String($nTotalBiaya)?></td>
                </tr>
                <tr>
                    <td colspan="3">
                        <hr>-
                    </td>
                </tr>
                <tr>
                    <td>Laba/Rugi</td>
                    <td>:</td>
                    <td class="align-right"><?= number2String($nTotalLabaRugi)?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
