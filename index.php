<?php include 'helpers/functions.php'; ?>
<?php template('header.php'); ?>

<?php
use Aries\MiniFrameworkStore\Models\Product;

$products = new Product();

function formatPeso($amount) {
    return '₱' . number_format($amount, 2);
}
?>

<style>
body {
    margin: 0;
    padding: 0;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: linear-gradient(135deg, #e0c3fc 0%, #8ec5fc 100%);
    color: #2d3748;
    min-height: 100vh;
}

.container {
    max-width: 1140px;
    margin: 3rem auto 6rem;
    padding: 0 1rem;
}

h1.text-center {
    font-weight: 800;
    color: #fff;
    margin-bottom: 0.5rem;
    text-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
}

p.text-center {
    font-weight: 500;
    font-size: 1.1rem;
    color: #f1f5f9;
    margin-bottom: 3rem;
    text-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
}

h2 {
    font-weight: 700;
    color: #fff;
    margin-bottom: 1.5rem;
    text-shadow: 0 1px 5px rgba(0,0,0,0.2);
}

.row > .col-md-4 {
    margin-bottom: 2rem;
}

.card {
    background: rgba(255, 255, 255, 0.95);
    border-radius: 18px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    display: flex;
    flex-direction: column;
    height: 100%;
}

.card:hover {
    transform: translateY(-10px);
    box-shadow: 0 18px 35px rgba(0, 0, 0, 0.15);
}

.card-img-top {
    border-radius: 18px 18px 0 0;
    height: 240px;
    object-fit: cover;
    border: 4px solid #fff;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease;
}

.card:hover .card-img-top {
    transform: scale(1.02);
}

.card-body {
    flex: 1;
    display: flex;
    flex-direction: column;
    padding: 1.5rem 2rem;
}

.card-title {
    font-weight: 700;
    font-size: 1.35rem;
    margin-bottom: 0.5rem;
    color: #1a202c;
}

.card-subtitle {
    font-weight: 600;
    color: #6f42c1;
    font-size: 1.1rem;
    margin-bottom: 1rem;
}

.card-text {
    flex-grow: 1;
    color: #4a5568;
    font-size: 1rem;
    margin-bottom: 1.25rem;
}

.btn-primary, .btn-success {
    font-weight: 700;
    padding: 12px 28px;
    border-radius: 30px;
    text-decoration: none;
    text-align: center;
    cursor: pointer;
    border: none;
    transition: all 0.3s ease;
    letter-spacing: 0.05em;
    display: inline-block;
}

.btn-primary {
    background: linear-gradient(45deg, #ff6a00, #ee0979);
    color: white;
    box-shadow: 0 6px 20px rgba(238, 9, 121, 0.4);
    margin-right: 10px;
}

.btn-primary:hover {
    background: linear-gradient(45deg, #ee0979, #ff6a00);
    box-shadow: 0 8px 24px rgba(238, 9, 121, 0.6);
    transform: translateY(-3px);
    color: white;
}

.btn-success {
    background: linear-gradient(45deg, #11998e, #38ef7d);
    color: white;
    box-shadow: 0 6px 20px rgba(56, 239, 125, 0.4);
}

.btn-success:hover {
    background: linear-gradient(45deg, #38ef7d, #11998e);
    box-shadow: 0 8px 24px rgba(56, 239, 125, 0.6);
    transform: translateY(-3px);
    color: white;
}

@media (max-width: 767px) {
    .card-img-top {
        height: 180px;
        border: 3px solid #fff;
    }
}
</style>

<div class="container my-5">
    <div class="row align-items-center">
        <div class="col-md-12">
            <h1 class="text-center">Welcome to Your Online Shop</h1>
            <p class="text-center">Find the best products at unbeatable prices!</p>
        </div>
    </div>

    <div class="row">
        <h2>Products</h2>

        <?php foreach($products->getAll() as $product): ?>
        <div class="col-md-4 mb-4">
            <div class="card">
                <img src="<?php echo htmlspecialchars($product['image_path']); ?>" class="card-img-top" alt="Product Image">
                <div class="card-body">
                    <h5 class="card-title"><?php echo htmlspecialchars($product['name']); ?></h5>
                    <h6 class="card-subtitle mb-2"><?php echo formatPeso($product['price']); ?></h6>
                    <p class="card-text"><?php echo htmlspecialchars($product['description']); ?></p>
                    <a href="product.php?id=<?php echo $product['id']; ?>" class="btn btn-primary">View Product</a>
                    <a href="#" class="btn btn-success add-to-cart" data-productid="<?php echo $product['id']; ?>" data-quantity="1">Add to Cart</a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<?php template('footer.php'); ?>
