<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<h2>Order Details: #<?= esc($order['id']) ?></h2>

<h3>Order Information</h3>
<p><strong>Customer Name:</strong> <?= esc($order['customer_name']) ?></p>
<p><strong>Email:</strong> <?= esc($order['customer_email']) ?></p>
<p><strong>Total Amount:</strong> $<?= esc($order['total_amount']) ?></p>
<p><strong> Order Status:</strong> <?= esc($order['status']) ?></p>
<p><strong>Payment Status:</strong> <?= esc($payment['status']) ?></p>

<h3>Payment Request & Response</h3>
<?php if ($payment): ?>
    <h4>Payment Request:</h4>
    <pre><?= esc(json_encode(json_decode($payment['request']), JSON_PRETTY_PRINT)) ?></pre>
    <h4>Payment Response:</h4>
    <pre><?= esc(json_encode(json_decode($payment['response']), JSON_PRETTY_PRINT)) ?></pre>
<?php else: ?>
    <p>No payment information available.</p>
<?php endif; ?>



<?= $this->endSection() ?>
