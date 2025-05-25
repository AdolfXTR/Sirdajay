<?php 
include 'helpers/functions.php'; 
template('header.php'); 

use Aries\MiniFrameworkStore\Models\Product;

$products = new Product();
$category = $_GET['name'] ?? '';

function formatPeso($amount) {
    return '₱' . number_format($amount, 2);
}
?>

<style>
body {
    margin: 0;
    padding: 0;
    font-family: 'Poppins', sans-serif;
    background: #ffffff; /* pure white background */
    color: #1e293b;
}

.container {
    max-width: 1100px;  /* slightly narrower for better focus */
    margin: 3rem auto;
    padding: 0 1rem;
}

h1.text-center {
    font-size: 2.8rem;
    font-weight: 700;
    text-align: center;
    margin-bottom: 1.5rem;
    color: #2563eb; /* blue heading */
    letter-spacing: -1px;
}

h2 {
    font-size: 1.4rem;
    font-weight: 600;
    color: #475569; /* Medium slate gray */
    margin: 1.5rem 0 1rem;
}

/* Grid layout */
.row {
    display: flex;
    flex-wrap: wrap;
    gap: 1.5rem; /* consistent gap between cards */
    justify-content: center;
}

.col-md-4, .col-sm-6 {
    flex: 1 1 280px; /* flexible, min 280px width */
    max-width: 320px; /* max width for card */
}

/* Card */
.card {
    background: #fff;
    border-radius: 15px;
    box-shadow: 0 3px 12px rgba(0,0,0,0.07);
    overflow: hidden;
    display: flex;
    flex-direction: column;
    height: 100%;
    border: 1px solid #d1d5db; /* soft gray border */
    transition: transform 0.25s ease, box-shadow 0.25s ease;
}

.card:hover {
    transform: translateY(-6px);
    box-shadow: 0 12px 24px rgba(37, 99, 235, 0.15);
}

.card-img-top {
    height: 180px;  /* smaller height */
    width: 100%;
    object-fit: cover;
    background: #f9fafb; /* very light gray */
}

/* Card body */
.card-body {
    padding: 1.2rem 1.5rem;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.card-title {
    font-size: 1.15rem;
    font-weight: 600;
    color: #111827;
    margin-bottom: 0.3rem;
    flex-shrink: 0;
}

.card-subtitle {
    font-size: 1rem;
    color: #10b981; /* green */
    font-weight: 700;
    margin-bottom: 0.7rem;
    flex-shrink: 0;
}

.card-text {
    color: #4b5563;
    font-size: 0.9rem;
    margin-bottom: 1.2rem;
    flex-grow: 1;
}

/* Buttons */
.btn-primary,
.btn-success {
    padding: 11px 18px;
    font-size: 0.88rem;
    font-weight: 600;
    border-radius: 40px;
    border: none;
    text-decoration: none;
    cursor: pointer;
    display: inline-block;
    transition: all 0.25s ease;
    color: white;
    text-align: center;
    user-select: none;
    margin-right: 10px;
}

.btn-primary {
    background: #2563eb; /* blue */
}

.btn-primary:hover {
    background: #1e40af;
}

.btn-success {
    background: #10b981; /* green */
}

.btn-success:hover {
    background: #047857;
}

/* Responsive */
@media (max-width: 768px) {
    .card-img-top {
        height: 140px;
    }
    .col-md-4, .col-sm-6 {
        max-width: 100%;
        flex-basis: 100%;
    }
}
</style>

<div class="container">
    <h1 class="text-center"><?php echo htmlspecialchars($category); ?></h1>
    
    <div class="row">
        <h2>Products</h2>
        <?php foreach($products->getByCategory($category) as $product): ?>
        <div class="col-md-4 col-sm-6">
            <div class="card">
                <img src="<?php echo htmlspecialchars($product['image_path']); ?>" class="card-img-top" alt="Product Image">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title"><?php echo htmlspecialchars($product['name']); ?></h5>
                    <h6 class="card-subtitle"><?php echo formatPeso($product['price']); ?></h6>
                    <p class="card-text"><?php echo htmlspecialchars($product['description']); ?></p>
                    <div class="mt-auto">
                        <a href="product.php?id=<?php echo $product['id']; ?>" class="btn btn-primary">View Product</a>
                        <a href="cart.php?product_id=<?php echo $product['id']; ?>" class="btn btn-success">Add to Cart</a>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<?php template('footer.php'); ?>
