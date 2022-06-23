<?php
$vaArray = $_SESSION['vaArray'];
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
    <h4 style="text-align:center">Daftar Barang Terlaris</h4>
    <table
        class="table table-bordered"
        width="100%"
        cellspacing="0"
    >
        <thead>
            <tr>
                    <th>#</th>
                    <th>Photo</th>
                    <th>Title</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Kategori</th>
                    <th>Terjual</th>
                </tr>
        </thead>
        <tfoot></tfoot>
        <tbody class="data-content">
            <?php 
            $no = 1;
            foreach($vaArray as $key=>$value){ 
            ?>
            <tr>
                <td><?= $no; ?></td>
                <td><img style="width: 50px" src="assets/images/product/<?= $value['productsImg']; ?>"></td>
                <td><?= $value['productsTitle']; ?></td>
                <td><?= $value['productsPrice']; ?></td>
                <td><?= $value['productsStock']; ?></td>
                <td><?= $value['categoriesName']; ?></td>
                <td><?= $value['transaction']; ?> x</td>
                
            </tr>
            <?php
                $no++;
            } 
            
            ?>
        </tbody>
    </table>
</div>