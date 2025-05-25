<?php include 'helpers/functions.php'; ?>
<?php template('header.php'); ?>
<?php

use Aries\MiniFrameworkStore\Models\User;

if(!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

if(isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'] ?? null;
    $phone = $_POST['phone'] ?? null;
    $birthdate = $_POST['birthdate'] ?? null;

    $userModel = new User();
    $userModel->update([
        'id' => $_SESSION['user']['id'],
        'name' => $name,
        'email' => $email,
        'address' => $address,
        'phone' => $phone,
        'birthdate' => Carbon\Carbon::createFromFormat('Y-m-d', $birthdate)->format('Y-m-d')
    ]);

    $_SESSION['user']['name'] = $name;
    $_SESSION['user']['email'] = $email;
    $_SESSION['user']['address'] = $address;
    $_SESSION['user']['phone'] = $phone;
    $_SESSION['user']['birthdate'] = $birthdate;

    echo "<script>alert('Account details updated successfully!');</script>";
}
?>

<style>
    body {
        background: #f9fafb;
        color: #111827;
        font-family: 'Inter', sans-serif;
    }

    .account-wrapper {
        background: #f5f9fa; /* soft light gray-blue instead of white */
        border-radius: 15px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
        padding: 30px;
        max-width: 600px;
        margin: 0 auto;
    }

    .account-header {
        background: #256d85; /* deep teal */
        color: #ffffff;
        padding: 24px 30px;
        border-radius: 15px 15px 0 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .account-header h2 {
        margin: 0;
        font-weight: 700;
    }

    .account-header small {
        opacity: 0.8;
        font-weight: 500;
    }

    .btn-primary {
        background-color: #0d9488; /* teal */
        border-color: #0d9488;
        font-weight: 600;
        padding: 10px 22px;
        border-radius: 10px;
        transition: background-color 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #14b8a6; /* lighter teal */
        border-color: #14b8a6;
    }

    .btn-danger {
        background-color: #dc2626; /* soft red */
        border: none;
        padding: 10px 22px;
        border-radius: 10px;
        font-weight: 600;
        transition: background-color 0.3s ease;
    }

    .btn-danger:hover {
        background-color: #b91c1c; /* deeper red */
    }

    input.form-control {
        border-radius: 10px;
        border: 1.5px solid #d1d5db; /* light border */
        padding: 12px 14px;
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }

    input.form-control:focus {
        border-color: #14b8a6; /* teal focus */
        box-shadow: 0 0 8px rgba(20, 184, 166, 0.3);
        outline: none;
    }

    label.form-label {
        font-weight: 600;
        color: #374151; /* dark gray */
        margin-bottom: 6px;
    }

    h4 {
        margin-bottom: 2rem;
        font-weight: 700;
        color: #256d85;
    }
</style>

<div class="container my-5">
    <div class="account-wrapper">
        <div class="account-header d-flex justify-content-between align-items-center">
            <div>
                <h2 class="mb-0">My Account</h2>
                <small>Welcome, <?php echo $_SESSION['user']['name']; ?></small>
            </div>
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>
        <div class="p-4">
            <h4>Edit Account Details</h4>
            <form action="my-account.php" method="POST">
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo $_SESSION['user']['name']; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo $_SESSION['user']['email']; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">Address</label>
                    <input type="text" class="form-control" id="address" name="address" value="<?php echo $_SESSION['user']['address'] ?? ''; ?>">
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $_SESSION['user']['phone'] ?? ''; ?>">
                </div>
                <div class="mb-3">
                    <label for="birthdate" class="form-label">Birthdate</label>
                    <input type="date" class="form-control" id="birthdate" name="birthdate" value="<?php echo $_SESSION['user']['birthdate'] ?? ''; ?>">
                </div>
                <button type="submit" class="btn btn-primary" name="submit">Save Changes</button>
            </form>
        </div>
    </div>
</div>

<?php template('footer.php'); ?>
