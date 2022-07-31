<?php
if(!empty($cost)){
    $cost_id = $_POST['cost_id'];
    $i=0;
    foreach($cost as $row){
        $i+=1;
        $tarif=$row['cost'][0]['value'];
        $service=$row['service'];
        $deskripsi=$row['description'];
        $waktu=$row['cost'][0]['etd']?$row['cost'][0]['etd']:"-";
?>
<div class="col-md-12">
    <div class="radio" style='margin: 0px;'>
        <label>
            <input type="radio" name="service_<?=$cost_id?>" class="service_<?=$cost_id?>" data-id="<?php echo $i; ?>" value="<?php echo $service; ?>"/> <?php echo $deskripsi; ?>
        </label>
    </div>
    <input type="hidden" name="tarif_<?=$cost_id?>" id="tarif_<?=$cost_id?>_<?php echo $i; ?>" value="<?php echo $tarif; ?>"/>
    <p style='margin-left: 19px;'>
        Tarif <b>Rp <?php echo number_format($tarif,0); ?></b><br/>
        Estimasi sampai <b><?php echo str_replace("HARI","",$waktu); ?> hari</b>
    </p>
</div>
<?php
    }
?>

<script>
    $(document).ready(function(){
        $(".service_<?=$cost_id?>").each(function(o_index,o_val){
            $(this).on("change",function(){
                var did=$(this).attr('data-id');
                var tarif=$("#tarif_<?=$cost_id?>_"+did).val();
                $("#paymentSendingPrice_<?=$cost_id?>").text(convertToNumber(tarif,2));
//                 hitung();
                const id_cost = "<?=$cost_id?>";
                countTotalShipppingCost(id_cost,tarif);
            });
        });
    });
</script>
<?php } ?>