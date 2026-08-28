<?php

include 'includes/auth.php';
include 'config/database.php';
include 'includes/header.php';

$user_id = $_SESSION['user_id'];

$messageCountResult = $conn->query(
    "SELECT COUNT(*) AS total
     FROM messages
     WHERE receiver_id='$user_id'"
);

$messageCount = $messageCountResult->fetch_assoc();

?>

<div class="container mt-5">

<h1 class="page-title">
Welcome, <?php echo $_SESSION['fullname']; ?>
</h1>

<p class="mb-4">
Role: <span class="badge bg-primary"><?php echo ucfirst($_SESSION['role']); ?></span>
</p>

<div class="row g-4">

<?php if($_SESSION['role'] == 'buyer') { ?>

<div class="col-md-4">
<div class="dashboard-card">
<div class="icon">🛒</div>
<h5>Marketplace</h5>
<p>Browse available products.</p>
<a href="marketplace.php" class="btn btn-primary">Open</a>
</div>
</div>

<div class="col-md-4">
<div class="dashboard-card">
<div class="icon">📦</div>
<h5>My Orders</h5>
<p>View your purchase requests.</p>
<a href="orders.php" class="btn btn-success">View</a>
</div>
</div>

<?php } ?>

<?php if($_SESSION['role'] == 'seller') { ?>

<div class="col-md-4">
<div class="dashboard-card">
<div class="icon">➕</div>
<h5>Add Product</h5>
<p>Create a new listing for buyers.</p>
<a href="add-product.php" class="btn btn-success">Add</a>
</div>
</div>

<div class="col-md-4">
<div class="dashboard-card">
<div class="icon">📋</div>
<h5>My Listings</h5>
<p>Manage your products and orders.</p>
<a href="my-products.php" class="btn btn-primary">Open</a>
</div>
</div>

<div class="col-md-4">
<div class="dashboard-card">
<div class="icon">🛍️</div>
<h5>Marketplace</h5>
<p>View other available products.</p>
<a href="marketplace.php" class="btn btn-warning">Browse</a>
</div>
</div>

<?php } ?>

<?php if($_SESSION['role'] == 'admin') { ?>

<div class="col-md-4">
<div class="dashboard-card">
<div class="icon">🛠️</div>
<h5>Admin Panel</h5>
<p>Manage users, products and orders.</p>
<a href="admin/index.php" class="btn btn-dark">Open</a>
</div>
</div>

<div class="col-md-4">
<div class="dashboard-card">
<div class="icon">🛒</div>
<h5>Marketplace</h5>
<p>View public marketplace.</p>
<a href="marketplace.php" class="btn btn-primary">Browse</a>
</div>
</div>

<?php } ?>

<div class="col-md-4">
<div class="dashboard-card">
<div class="icon">💬</div>
<h5>
Messages
<?php if($messageCount['total'] > 0) { ?>
<span class="badge bg-danger">
<?php echo $messageCount['total']; ?>
</span>
<?php } ?>
</h5>
<p>View buyer and seller messages.</p>
<a href="messages.php" class="btn btn-primary">Open</a>
</div>
</div>

<div class="col-md-4">
<div class="dashboard-card">
<div class="icon">🚪</div>
<h5>Logout</h5>
<p>End your session safely.</p>
<a href="logout.php" class="btn btn-danger">Logout</a>
</div>
</div>

</div>

</div>

<?php include 'includes/footer.php'; ?>