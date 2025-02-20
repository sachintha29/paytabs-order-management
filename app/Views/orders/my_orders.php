<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<h2>My Orders</h2>
<table>
    <thead>
        <tr>
            <th>Order ID</th>
            <th>Customer Name</th>
            <th>Total Amount</th>
            <th>Order Status</th>
            <th>Details</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($orders as $order): ?>
            <tr>
                <td><?= esc($order['id']) ?></td>
                <td><?= esc($order['customer_name']) ?></td>
                <td>$<?= esc($order['total_amount']) ?></td>
                <td><?= esc($order['status']) ?></td>
                <td><a href="/order/details/<?= esc($order['id']) ?>">View Details</a></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?= $this->endSection() ?>
