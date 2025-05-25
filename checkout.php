<?php 
include 'helpers/functions.php'; 
template('header.php'); 

use Aries\MiniFrameworkStore\Models\Checkout;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$checkout = new Checkout();
$superTotal = 0;
$orderId = null;

function formatPeso($amount) {
    return '₱' . number_format($amount, 2);
}

// Get selected products sent via POST from cart.php
$selectedProductIds = $_POST['selected_products'] ?? [];

// If no products selected or cart empty, redirect back with alert
if (empty($selectedProductIds) || !isset($_SESSION['cart']) || count($_SESSION['cart']) == 0) {
    echo "<script>
        alert('No products selected or your cart is empty.');
        window.location.href = 'cart.php';
    </script>";
    exit;
}

// Filter the session cart for only the selected products
$selectedCartItems = [];
foreach ($selectedProductIds as $productId) {
    if (isset($_SESSION['cart'][$productId])) {
        $selectedCartItems[$productId] = $_SESSION['cart'][$productId];
    }
}

// Calculate total based on selected items
foreach ($selectedCartItems as $item) {
    $superTotal += $item['price'] * $item['quantity'];
}

// If form submitted (shipping details)
if (isset($_POST['submit'])) {
    $name = $_POST['name'] ?? null;
    $address = $_POST['address'] ?? null;
    $phone = $_POST['phone'] ?? null;
    $payment_method = $_POST['payment_method'] ?? 'COD';

    if (isset($_SESSION['user'])) {
        $orderId = $checkout->userCheckout([
            'user_id' => $_SESSION['user']['id'],
            'total' => $superTotal,
            'payment_method' => $payment_method
        ]);
    } else {
        $orderId = $checkout->guestCheckout([
            'name' => $name,
            'address' => $address,
            'phone' => $phone,
            'total' => $superTotal,
            'payment_method' => $payment_method
        ]);
    }

    // Save order details only for selected items
    foreach ($selectedCartItems as $item) {
        $checkout->saveOrderDetails([
            'order_id' => $orderId,
            'product_id' => $item['product_id'],
            'quantity' => $item['quantity'],
            'price' => $item['price'],
            'subtotal' => $item['price'] * $item['quantity']
        ]);

        // Remove checked-out products from cart session
        unset($_SESSION['cart'][$item['product_id']]);
    }

    echo "<script>
        alert('Order placed successfully!');
        window.location.href='dashboard.php';
    </script>";
    exit;
}
?>

<div class="container">
    <h1 class="mb-4">🛒 Checkout</h1>

    <div class="row mb-5">
        <h2 class="mb-3">Cart Summary</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Product</th>
                    <th class="text-center">Quantity</th>
                    <th class="text-end">Price</th>
                    <th class="text-end">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php if(count($selectedCartItems) > 0): ?>
                    <?php foreach ($selectedCartItems as $item): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['name']); ?></td>
                            <td class="text-center"><?php echo $item['quantity']; ?></td>
                            <td class="text-end"><?php echo formatPeso($item['price']); ?></td>
                            <td class="text-end"><?php echo formatPeso($item['price'] * $item['quantity']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="3" class="text-end"><strong>Total</strong></td>
                        <td class="text-end"><strong><?php echo formatPeso($superTotal); ?></strong></td>
                    </tr>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center">No items selected.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="row">
        <div class="col-md-12">
            <h2 class="mb-3">Shipping Details</h2>

            <?php if(count($selectedCartItems) == 0): ?>
                <p>No products selected for checkout.</p>
                <a href="cart.php" class="btn btn-primary">Back to Cart</a>
            <?php else: ?>
                <form action="checkout.php" method="POST">
                    <!-- Pass selected product IDs as hidden inputs -->
                    <?php foreach ($selectedProductIds as $productId): ?>
                        <input type="hidden" name="selected_products[]" value="<?php echo htmlspecialchars($productId); ?>">
                    <?php endforeach; ?>

                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Complete Address</label>
                        <input type="text" class="form-control" id="address" name="address" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Mobile Number</label>
                        <input type="text" class="form-control" id="phone" name="phone" required>
                    </div>
                    <div class="mb-3">
                        <p><strong>Payment Method:</strong> Cash on Delivery (COD)</p>
                        <input type="hidden" name="payment_method" value="COD">
                    </div>
                    <button type="submit" class="btn btn-success" name="submit">✅ Place Order</button>
                    <a href="cart.php" class="btn btn-primary">← View Cart</a>
                </form>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php template('footer.php'); ?>
