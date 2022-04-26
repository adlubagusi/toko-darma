<?php

?>
<script>
    function convertToNumber(string){
        let number = string.replace(',', '').replace('.','');
        number = parseInt(number);
        number = number/100;
        const formatter = new Intl.NumberFormat('en-US', {
            minimumFractionDigits: 2
        })
        number = formatter.format(number);
        return number;
    }
</script>
<?php
echo "<script>alert('under construction !');</script>";
exit;
?>
<form action="payment/succesfully" method="post">
<div class="wrapper">
    <div class="core">
        <?php if($this->cart->total_items() > 0){ ?>
        <div class="products">
            <table class="table">
                <tr>
                    <th>Product</th>
                    <th>Qty</th>
                    <th>Info</th>
                    <th>Price</th>
                </tr>
                <?php foreach($this->cart->contents() as $item): ?>
                <tr>
                    <td># <?= $item['name']; ?></td>
                    <td class="text-center"><?= $item['qty']; ?></td>
                    <?php if($item['ket'] == ""){ ?>
                        <td>-</td>
                    <?php }else{ ?>
                        <td><?= $item['ket']; ?></td>
                    <?php } ?>
                    <td><?= $this->config->item('currency'); ?><script>document.write(convertToNumber('<?= $item['subtotal']; ?>'))</script></td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
        <div class="line"></div>
        <div class="address">
            <h2 class="title">Shipping address</h2>
            <hr>
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" autocomplete="off" class="form-control" required name="name">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" autocomplete="off" class="form-control" required name="email">
            </div>
            <div class="form-group">
                <label for="telp">Telephone</label>
                <input type="number" id="telp" autocomplete="off" class="form-control" required name="telp">
            </div>
            <div class="form-group">
                <label for="selectRegionPayment">Region</label>
                <select name="region" id="selectRegionPayment" class="form-control" required>
                    <option></option>
                    <?php foreach($region->result_array() as $d): ?>
                        <option value="<?= $d['id']; ?>"><?= $d['region']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="address">Full Address</label>
                <textarea name="address" rows="3" id="address" class="form-control" placeholder="Fill in the street name, house number, building name, etc." required></textarea>
            </div>
        </div>
        <?php }else{ ?>
            <div class="alert alert-warning">Oops. You don't have any groceries yet. Let's shop first.</div>
        <?php } ?>
    </div>
    <div class="total shadow">
        <h2 class="title">Shopping Summary</h2>
        <hr>
        <div class="list">
            <p>Total Shopping</p>
            <p><?= $this->config->item('currency'); ?><script>document.write(convertToNumber('<?= $this->cart->total(); ?>'))</script></p>
        </div>
            <div class="list">
                <p>Shipping Cost</p>
                <p id="paymentSendingPrice"><?= $this->config->item('currency'); ?><script>document.write(convertToNumber('0'))</script></p>
            </div>
            <hr>
            <div class="list">
                <p>Total Bill</p>
                <p id="paymentTotalAll"><?= $this->config->item('currency'); ?><script>document.write(convertToNumber('<?= $this->cart->total(); ?>'))</script></p>
            </div>
        <?php if($this->cart->total_items() > 0){ ?>
            <button class="btn btn-dark btn btn-block mt-2" id="btnPaymentNow" type="submit">Continue</button>
        <?php }else{ ?>
            <div class="alert mt-2 alert-warning">Your basket is still empty.</div>
            <a href="">
                <button class="btn btn-dark btn btn-block mt-2">Shopping First</button>
            </a>
        <?php } ?>
    </div>
</div>
</form>