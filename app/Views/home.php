<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div class="container">
    <!-- Product Ordering Form (left side) -->
    <div class="order-form">
        <h2>Products</h2>
        <form id="orderForm" action="/order/create" method="post">
            <input type="text" name="name" placeholder="Your Name" required>
            <input type="email" name="email" placeholder="Your Email" required>
            
            <!-- Dynamically generate products and allow selection of quantity -->
            <div id="productContainer">
                <?php foreach ($products as $product): ?>
                    <div class="product">
                        <label><?= esc($product['name']) ?> - $<?= esc($product['price']) ?></label>
                        <input type="number" name="products[<?= esc($product['id']) ?>][quantity]" value="0" min="0">
                        <input type="hidden" name="products[<?= esc($product['id']) ?>][price]" value="<?= esc($product['price']) ?>">
                    </div>
                <?php endforeach; ?>
            </div>
            <p><strong>Total Amount: $<span id="totalAmount">0.00</span></strong></p>


            <button type="submit">Order Now</button>
        </form>
    </div>

    <!-- PayTabs Iframe (right side) -->
    <div class="iframe-container">
        <div id="iframeContainer"></div>
    </div>
</div>

<!-- jQuery (make sure jQuery is included in your layout) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {
    $('#orderForm').submit(function(event) {
        event.preventDefault();  // Prevent the default form submission
        
        // Calculate total price
        var totalAmount = 0;
        $("input[name^='products']").each(function() {
            if ($(this).attr('name').includes('[quantity]')) {
                var productId = $(this).attr('name').split('[')[1].split(']')[0];
                var quantity = $(this).val();
                var price = $("input[name='products[" + productId + "][price]']").val();
                totalAmount += quantity * price;
            }
        });

        $("#totalAmount").text(totalAmount.toFixed(2)); 


        // Append total to form data before sending
        var formData = $(this).serialize() + '&total=' + totalAmount;

        $.ajax({
            url: '/order/create',
            type: 'POST',
            data: formData,  // Send the form data along with total amount
            dataType: 'json',
            success: function(response) {
                if (response.iframe_url) {
                    // If iframe URL is returned, inject it into the container
                    $('#iframeContainer').html('<iframe src="' + response.iframe_url + '" width="100%" height="600px"></iframe>');
                } else {
                    alert('Error: ' + response.error);
                }
            },
            error: function() {
                alert('There was an error processing your request.');
            }
        });
    });
});
</script>

<style>
.container {
    display: flex;
    justify-content: space-between;
    margin: 20px;
}

.order-form {
    width: 45%;
    padding: 20px;
    background-color: #f9f9f9;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.order-form input,
.order-form select,
.order-form button {
    width: 100%;
    padding: 10px;
    margin: 10px 0;
    border: 1px solid #ccc;
    border-radius: 4px;
}

.order-form button {
    background-color: #4CAF50;
    color: white;
    cursor: pointer;
}

.order-form button:hover {
    background-color: #45a049;
}

.iframe-container {
    width: 45%;
    padding: 20px;
}

#iframeContainer iframe {
    width: 100%;
    height: 600px;
    border: none;
}
</style>

<?= $this->endSection() ?>
