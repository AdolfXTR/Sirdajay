<?php include 'helpers/functions.php'; ?>
<?php template('header.php'); ?>
<?php

use Aries\MiniFrameworkStore\Models\Category;
use Aries\MiniFrameworkStore\Models\Product;
use Carbon\Carbon;

$categories = new Category();
$product = new Product();

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $image = $_FILES['image'];

    if ($image['error'] === UPLOAD_ERR_OK) {
        $targetDir = "uploads/";
        $targetFile = $targetDir . basename($image["name"]);
        move_uploaded_file($image["tmp_name"], $targetFile);
    }

    $product->insert([
        'name' => $name,
        'description' => $description,
        'price' => $price,
        'slug' => strtolower(str_replace(' ', '-', $name)),
        'image_path' => $targetFile,
        'category_id' => $category,
        'created_at' => Carbon::now('Asia/Manila'),
        'updated_at' => Carbon::now()
    ]);

    $message = "Product added successfully!";
}
?>

<!-- Modern color styling -->
<style>
    body {
        background: linear-gradient(to right, #e0c3fc, #8ec5fc);
        font-family: 'Segoe UI', sans-serif;
    }

    .form-container {
        background: #ffffff;
        padding: 40px;
        border-radius: 16px;
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.1);
        margin-top: 60px;
    }

    h1, p, label {
        color: #343a40;
    }

    .form-control,
    .form-select {
        border-radius: 10px;
        border: 1px solid #ccc;
        transition: border 0.3s ease, box-shadow 0.3s ease;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #6f42c1;
        box-shadow: 0 0 0 0.2rem rgba(111, 66, 193, 0.25);
    }

    .btn-primary {
        background-color: #6f42c1;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        padding: 10px 20px;
        transition: background 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #5936a1;
    }

    .alert-success {
        background-color: #d1e7dd;
        color: #0f5132;
        border: 1px solid #badbcc;
        border-radius: 10px;
    }
</style>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 form-container">
            <h1 class="text-center mb-3">Add Product</h1>
            <p class="text-center mb-4">Fill in the details below to add a new product.</p>
            <?php if (isset($message)): ?>
                <div class="alert alert-success" role="alert">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>
            <form action="add-product.php" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="product-name">Product Name</label>
                    <input type="text" class="form-control" id="product-name" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="5"></textarea>
                </div>
                <div class="mb-3">
                    <label for="price">Price</label>
                    <input type="text" class="form-control" id="price" name="price" required>
                </div>
                <div class="mb-3">
                    <label for="category">Category</label>
                    <select class="form-select" id="category" name="category" required>
                        <option selected disabled>Select category</option>
                        <?php foreach($categories->getAll() as $category): ?>
                            <option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="formFile" class="form-label">Image</label>
                    <input class="form-control" type="file" id="formFile" name="image" accept="image/*">
                </div>
                <div class="d-grid">
                    <button class="btn btn-primary" type="submit" name="submit">Add Product</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php template('footer.php'); ?>
