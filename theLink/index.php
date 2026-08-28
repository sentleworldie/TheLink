<?php

include 'config/database.php';
include 'includes/header.php';

$featured = $conn->query(
    "SELECT * FROM products
     WHERE status='available'
     ORDER BY id DESC
     LIMIT 3"
);

$totalUsers = $conn->query("SELECT COUNT(*) AS total FROM users")->fetch_assoc();
$totalProducts = $conn->query("SELECT COUNT(*) AS total FROM products")->fetch_assoc();
$totalOrders = $conn->query("SELECT COUNT(*) AS total FROM orders")->fetch_assoc();

?>

<div class="container mt-5">

<div class="hero-box">

<h1>Welcome to <span>TheLink</span></h1>

<p>
South Africa's trusted marketplace for buying and selling products safely.
</p>

<a href="marketplace.php" class="btn btn-primary btn-lg">
Browse Marketplace
</a>

<a href="register.php" class="btn btn-success btn-lg ms-2">
Start Selling
</a>

</div>

<div class="row mt-5 g-4">

<div class="col-md-4">
<div class="dashboard-card">
<div class="icon">👥</div>
<h5>Registered Users</h5>
<h2 class="counter" data-target="<?php echo $totalUsers['total']; ?>">0</h2>
</div>
</div>

<div class="col-md-4">
<div class="dashboard-card">
<div class="icon">📦</div>
<h5>Products Listed</h5>
<h2 class="counter" data-target="<?php echo $totalProducts['total']; ?>">0</h2>
</div>
</div>

<div class="col-md-4">
<div class="dashboard-card">
<div class="icon">🧾</div>
<h5>Orders Created</h5>
<h2 class="counter" data-target="<?php echo $totalOrders['total']; ?>">0</h2>
</div>
</div>

</div>

<h2 class="page-title mt-5">Featured Products</h2>

<div class="row g-4">

<?php while($row = $featured->fetch_assoc()) { ?>

<div class="col-md-4">

<div class="card h-100">

<img src="assets/uploads/<?php echo $row['image']; ?>"
     class="card-img-top"
     height="250">

<div class="card-body">

<h5><?php echo $row['title']; ?></h5>

<span class="badge bg-primary mb-2">
<?php echo $row['category']; ?>
</span>

<h4 class="text-success">
R<?php echo number_format($row['price'], 2); ?>
</h4>

<a href="product-details.php?id=<?php echo $row['id']; ?>"
   class="btn btn-primary w-100">
View Product
</a>

</div>

</div>

</div>

<?php } ?>

</div>

<div class="row mt-5 g-4">

<div class="col-md-4">
<div class="dashboard-card">
<div class="icon">🔒</div>
<h5>Secure Trading</h5>
<p>Buy and sell through verified accounts.</p>
</div>
</div>

<div class="col-md-4">
<div class="dashboard-card">
<div class="icon">🛒</div>
<h5>Easy Marketplace</h5>
<p>Browse products and send purchase requests.</p>
</div>
</div>

<div class="col-md-4">
<div class="dashboard-card">
<div class="icon">🇿🇦</div>
<h5>Local Economy</h5>
<p>Supporting South African informal traders.</p>
</div>
</div>

</div>

</div>

<?php include 'includes/footer.php'; ?>