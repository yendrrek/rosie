<?php
if (isset($_SESSION['noncePayPalSmartBtn'])):
    $noncePayPalSmartBtn = $_SESSION['noncePayPalSmartBtn'];
endif;
?>

<script nonce="<?php echo $noncePayPalSmartBtn; ?>">
// Smart Button's container is in 'basket-content.php'.
const isBasketPage = document.querySelector('.body__table-container')
if (isBasketPage) {
  paypal.Buttons({
    style: {
      shape: 'rect',
      color: 'gold',
      layout: 'horizontal',
      label: 'checkout',
      size: 'responsive',
      tagline: 'false'
    },
    createOrder: function (data) {
      const pleaseWaitProcessingLightbox =
        document.querySelectorAll('#modal-outer, #modal-inner')
      for (const modals of pleaseWaitProcessingLightbox) {
        modals.classList.add('please-wait-processing-visible')
        document.body.style.overflow = 'hidden'
      }
      return fetch('shop-files/create-order.php', {
        method: 'post'
      }).then(function (res) {
        return res.json()
      }).then(function (orderData) {
        return orderData.id
      })
    },
    onShippingChange: function (data, actions) {
      if (data.shipping_address.country_code !== 'GB') {
        return actions.reject()
      }
      return actions.resolve()
    },
    onCancel: function (data) {
      window.location = './basket.php'
    },
    onError: function () {
      window.location = 'views/capture-transaction-error.html'
    },
    onApprove: function (data) {
      return fetch('shop-files/capture-transaction.php', {
        method: 'post',
        headers: { 'content-type': 'application/json' },
        body: JSON.stringify({ orderID: data.orderID })
      }).then(function (res) {
        return res.json()
      }).then(function (orderData) {
        /*
          Three cases to handle:
            (1) Recoverable INSTRUMENT_DECLINED -> call actions.restart().
            (2) Other non-recoverable errors -> Show a failure message.
            (3) Successful transaction -> Show a success / thank you message.
        */
        const errorDetail = Array.isArray(orderData.details) && orderData.details[0]
        if (errorDetail && errorDetail.issue === 'INSTRUMENT_DECLINED') {
        /*
          Recoverable state, see: "Handle Funding Failures".
          https://developer.paypal.com/docs/checkout/integration-features/funding-failure/
        */
          return actions.restart()
        }
        if (errorDetail) {
          let msg = 'Sorry, your transaction could not be processed.'
          if (errorDetail.description) msg += '\n\n' + errorDetail.description
          if (orderData.debug_id) msg += ' (' + orderData.debug_id + ')'
          return alert(msg)
        }
        window.location = './purchase-completed.php?buyerName=' + orderData.payer.name.given_name
      })
    }
  }).render('#paypal-btn-container')
}
</script>