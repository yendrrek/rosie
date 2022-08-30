<head>
<style>
    
.purchase-confirmation-email {
  color: #1a1a1a;
  font-size: 1.063rem;
}

</style>
</head>

<br>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td align="center">
            <div>
                <td align="left">
                    <div class="purchase-confirmation-email">
                        Dear <?php echo $this->orderCapture->buyerFirstName; ?>,<br>
                        Thank you for your purchase.<br><br>
                        Order details:<br><br>

                        <?php
                        $qtyOfTypesOfProductsPurchased = count($items[0]);
                        for ($i = 0; $i < $qtyOfTypesOfProductsPurchased; $i++) :
                            $totalPriceOfSingleProduct[$i] = $items[0][$i]['value'] * $items[0][$i]['qty'];
                            ?>

                        <i><?php echo $items[0][$i]['name']; ?></i><br>
                        Price: &pound; <?php echo $items[0][$i]['value']; ?><br>
                        Quantity: <?php echo $items[0][$i]['qty']; ?><br>
                        Subtotal: &pound; <?php echo number_format($totalPriceOfSingleProduct[$i], 2); ?><br><br>

                            <?php
                            $totalQtyOfSingleProduct[$i] = $items[0][$i]['qty'];
                        endfor;
                        $totalQtyOfAllProducts = array_sum($totalQtyOfSingleProduct);
                        ?>

                        Total quantity purchased: <?php echo $totalQtyOfAllProducts; ?><br> 
                        <strong>Total price: &pound; <?php echo $this->orderCapture->totalPrice; ?></strong><br>
                        Postage included<br><br>
                        You will receive a separate email when your order has been posted to<br> 
                        <?php echo $this->orderCapture->buyerFullAddress; ?><br><br>
                        In the meantime, if you have any questions, please do not hesitate to 
                        <a href="https://rosiepiontek.com/contact.php">contact me</a><br><br>
                        Best wishes,<br><br>
                        <i>Rosie Piontek</i><br>
                        <?php echo $sellerPhone; ?><br>
                        <?php echo $sellerMobile; ?><br>
                        www.rosiepiontek.com
                    </div>
                </td>
            </div>
        </td>
    </tr>
</table>