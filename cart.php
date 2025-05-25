<?php 
include 'helpers/functions.php'; 
template('header.php'); 

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_GET['remove'])) {
    $productId = $_GET['remove'];
    if (isset($_SESSION['cart'][$productId])) {
        unset($_SESSION['cart'][$productId]);
        echo "<script>alert('Product removed from cart');</script>";
    }
}

function formatPeso($amount) {
    return '₱' . number_format($amount, 2);
}
?>

<style>
    .cart-checkbox {
        margin-right: 15px;
        width: 20px;
        height: 20px;
    }
    .cart-img {
        width: 80px;
        height: auto;
        margin-right: 10px;
    }
    .cart-item {
        margin-bottom: 15px;
    }
</style>

<div class="container my-5">
    <h1 class="mb-4">🛒 Your Cart</h1>
    
    <?php if (empty($_SESSION['cart']) || count($_SESSION['cart']) === 0): ?>
        <div class="alert alert-info">Your cart is empty.</div>
        <a href="index.php" class="btn btn-primary">Continue Shopping</a>
    <?php else: ?>
        <form action="checkout.php" method="post" id="cart-form">
            <?php 
            $superTotal = 0;
            foreach ($_SESSION['cart'] as $productId => $item): 
                $subtotal = $item['price'] * $item['quantity'];
                $superTotal += $subtotal;
            ?>
            <div class="cart-item d-flex align-items-center">
                <input 
                    type="checkbox" 
                    name="selected_products[]" 
                    value="<?php echo htmlspecialchars($productId); ?>" 
                    class="cart-checkbox" 
                    checked 
                    data-subtotal="<?php echo $subtotal; ?>"
                >
                <img src="<?php echo htmlspecialchars($item['image_path']); ?>" alt="" class="cart-img">
                <div class="flex-grow-1">
                    <div class="cart-title"><?php echo htmlspecialchars($item['name']); ?></div>
                    <div>Quantity: <strong><?php echo (int)$item['quantity']; ?></strong></div>
                    <div>Price: <span class="cart-price"><?php echo formatPeso($item['price']); ?></span></div>
                    <div>Subtotal: <span class="text-success fw-bold"><?php echo formatPeso($subtotal); ?></span></div>
                </div>
                <div>
                    <a href="cart.php?remove=<?php echo urlencode($productId); ?>" class="btn btn-remove">Remove</a>
                </div>
            </div>
            <?php endforeach; ?>

            <div class="card p-3 mt-4">
                <div class="cart-summary mb-3">Total: <span id="cart-total"><?php echo formatPeso($superTotal); ?></span></div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success">Proceed to Checkout</button>
                    <a href="index.php" class="btn btn-outline-primary">Continue Shopping</a>
                </div>
            </div>
        </form>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const checkboxes = document.querySelectorAll('.cart-checkbox');
                const totalDisplay = document.getElementById('cart-total');

                function updateTotal() {
                    let total = 0;
                    checkboxes.forEach(cb => {
                        if (cb.checked) {
                            total += parseFloat(cb.getAttribute('data-subtotal'));
                        }
                    });
                    totalDisplay.textContent = '₱' + total.toFixed(2);
                }

                checkboxes.forEach(cb => cb.addEventListener('change', updateTotal));
            });
        </script>
    <?php endif; ?>
</div>

<?php template('footer.php'); ?>
