<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<h2>Complete Your Payment</h2>
<div id="payment-container">
    <p>Loading payment gateway...</p>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $.ajax({
        url: "/checkout/<?= $orderId ?>",
        method: "GET",
        success: function(response) {
            $("#payment-container").html('<iframe id="paytabs-iframe" src="' + response.iframe_url + '" width="100%" height="600px"></iframe>');
        },
        error: function() {
            $("#payment-container").html('<p>Failed to load payment gateway. Please try again.</p>');
        }
    });
});
</script>
<?= $this->endSection() ?>
