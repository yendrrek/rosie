<script nonce="<?php echo $_SESSION['noncePayPalSmartBtn'] ?? false; ?>" id="paypal-smart-button-script">
const basketPage = document.querySelector('.table-container');
if (basketPage) {
  paypal.Buttons({
    style: {
      shape: 'rect',
      color: 'gold',
      layout: 'horizontal',
      label: 'checkout',
      size: 'responsive',
      tagline: 'false'
    },
    createOrder(data) {
      const pleaseWaitProcessingLightbox =
        document.querySelectorAll('#modal-outer, #modal-inner');
      for (const modals of pleaseWaitProcessingLightbox) {
        modals.classList.add('please-wait-processing-visible');
        document.body.style.overflow = 'hidden';
      }
      return fetch('scripts/pay-pal/create-order.php', {
        method: 'post'
      }).then(function (res) {
        return res.json();
      }).then(function (orderData) {
        return orderData.id;
      })
    },
    onShippingChange(data, actions) {
      if (data.shipping_address.country_code !== 'GB') {
        return actions.reject();
      }
      return actions.resolve();
    },
    onCancel(data) {
      window.location = './basket.php';
    },
    onError() {
      window.location = '../../views/capture-transaction-error.html';
    },
    onApprove(data) {
      return fetch('scripts/pay-pal/capture-transaction.php', {
        method: 'post',
        headers: { 'content-type': 'application/json' },
        body: JSON.stringify({ orderID: data.orderID })
      }).then(function (res) {
        return res.json();
      }).then(function (orderData) {
        const errorDetail = Array.isArray(orderData.details) && orderData.details[0];
        if (errorDetail && errorDetail.issue === 'INSTRUMENT_DECLINED') {
          return actions.restart();
        }
        if (errorDetail) {
          let msg = 'Sorry, your transaction could not be processed.';
          if (errorDetail.description) msg += '\n\n' + errorDetail.description;
          if (orderData.debug_id) msg += ' (' + orderData.debug_id + ')';
          return alert(msg);
        }
        window.location = './purchase-completed.php?buyerName=' + orderData.payer.name.given_name;
      })
    }
  }).render('#paypal-btn-container');
}
</script>