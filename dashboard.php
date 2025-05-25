<?php 
include 'helpers/functions.php'; 
template('header.php'); 

use Aries\MiniFrameworkStore\Models\Checkout;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$orders = new Checkout();

?>

<style>
.container.my-5 {
    max-width: 900px;
    margin: 3rem auto;
    background: #ffffff;
    padding: 2rem;
    border-radius: 12px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
    font-family: 'Poppins', sans-serif;
    color: #1e293b;
}

h2 {
    color: #2563eb;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

p {
    color: #475569;
    font-size: 1rem;
    margin-bottom: 2rem;
}

.table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0 12px;
}

.table-bordered th,
.table-bordered td {
    border: none;
    padding: 12px 15px;
    vertical-align: middle;
}

.table thead th {
    background: #2563eb;
    color: white;
    font-weight: 600;
    border-radius: 8px 8px 0 0;
    text-align: left;
    padding-left: 20px;
}

.table tbody tr {
    background: #f3f4f6;
    border-radius: 12px;
    box-shadow: 0 3px 6px rgba(37, 99, 235, 0.1);
    transition: background 0.3s ease;
}

.table tbody tr:nth-child(even) {
    background: #e0e7ff;
}

.table tbody tr:hover {
    background: #c7d2fe;
}

.table tbody tr td:first-child {
    border-top-left-radius: 12px;
    border-bottom-left-radius: 12px;
    padding-left: 20px;
}

.table tbody tr td:last-child {
    border-top-right-radius: 12px;
    border-bottom-right-radius: 12px;
}

.table tbody tr td:nth-child(5) {
    font-weight: 700;
    color: #16a34a;
}
</style>

<div class="container my-5">
    <h2>Order History</h2>
    <p>Here are past orders made on the site:</p>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>User</th>
                <th>Product</th>
                <th>Quantity</th>
                <th>Total Price</th>
                <th>Order Date</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $allOrders = $orders->getAllOrders();
            if (!empty($allOrders)) {
                foreach ($allOrders as $order) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($order['id']) . '</td>';
                    echo '<td>' . htmlspecialchars($order['user_name']) . '</td>';
                    echo '<td>' . htmlspecialchars($order['product_name']) . '</td>';
                    echo '<td>' . htmlspecialchars($order['quantity']) . '</td>';
                    echo '<td>₱' . number_format($order['total_price'], 2) . '</td>';
                    echo '<td>' . htmlspecialchars($order['order_date']) . '</td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr><td colspan="6" class="text-center">No orders found.</td></tr>';
            }
            ?>
        </tbody>
    </table>
</div>

<?php template('footer.php'); ?>
