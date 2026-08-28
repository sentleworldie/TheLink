<?php

include '../includes/admin-auth.php';
include '../config/database.php';

$users = $conn->query("SELECT COUNT(*) AS total FROM users")->fetch_assoc();
$products = $conn->query("SELECT COUNT(*) AS total FROM products")->fetch_assoc();
$orders = $conn->query("SELECT COUNT(*) AS total FROM orders")->fetch_assoc();
$messages = $conn->query("SELECT COUNT(*) AS total FROM messages")->fetch_assoc();

$recentOrders = $conn->query("
SELECT orders.id,
       orders.status,
       products.title,
       users.fullname AS buyer_name
FROM orders
INNER JOIN products ON orders.product_id = products.id
INNER JOIN users ON orders.buyer_id = users.id
ORDER BY orders.id DESC
LIMIT 5
");

?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Dashboard - TheLink</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
<div class="container">
<a class="navbar-brand" href="index.php">
<i class="bi bi-link-45deg"></i> TheLink Admin
</a>

<div>
<a href="../dashboard.php" class="btn btn-light btn-sm">Main Dashboard</a>
<a href="logout.php" class="btn btn-danger btn-sm">Logout</a>
</div>
</div>
</nav>

<div class="container mt-5">

<h1 class="page-title">Admin Dashboard</h1>

<p>
Welcome, <strong><?php echo $_SESSION['fullname']; ?></strong>
</p>

<div class="row g-4 mb-5">

<div class="col-md-3">
<div class="dashboard-card">
<div class="icon">👥</div>
<h5>Total Users</h5>
<h2><?php echo $users['total']; ?></h2>
</div>
</div>

<div class="col-md-3">
<div class="dashboard-card">
<div class="icon">📦</div>
<h5>Total Products</h5>
<h2><?php echo $products['total']; ?></h2>
</div>
</div>

<div class="col-md-3">
<div class="dashboard-card">
<div class="icon">🧾</div>
<h5>Total Orders</h5>
<h2><?php echo $orders['total']; ?></h2>
</div>
</div>

<div class="col-md-3">
<div class="dashboard-card">
<div class="icon">💬</div>
<h5>Total Messages</h5>
<h2><?php echo $messages['total']; ?></h2>
</div>
</div>

</div>

<div class="row g-4 mb-5">

<div class="col-md-4">
<div class="dashboard-card">
<div class="icon">👥</div>
<h5>Manage Users</h5>
<p>Edit, view and remove users.</p>
<a href="users.php" class="btn btn-primary">Open</a>
</div>
</div>

<div class="col-md-4">
<div class="dashboard-card">
<div class="icon">📦</div>
<h5>Manage Products</h5>
<p>View and remove listings.</p>
<a href="products.php" class="btn btn-success">Open</a>
</div>
</div>

<div class="col-md-4">
<div class="dashboard-card">
<div class="icon">🧾</div>
<h5>Manage Orders</h5>
<p>Monitor platform orders.</p>
<a href="orders.php" class="btn btn-warning">Open</a>
</div>
</div>

</div>

<div class="card p-4">

<h3 class="mb-3">Recent Order Activity</h3>

<table class="table table-bordered">

<thead>
<tr>
<th>Order ID</th>
<th>Buyer</th>
<th>Product</th>
<th>Status</th>
</tr>
</thead>

<tbody>

<?php while($row = $recentOrders->fetch_assoc()) { ?>

<tr>

<td><?php echo $row['id']; ?></td>
<td><?php echo $row['buyer_name']; ?></td>
<td><?php echo $row['title']; ?></td>

<td>
<?php if($row['status'] == 'pending') { ?>
<span class="badge bg-warning">Pending</span>
<?php } elseif($row['status'] == 'accepted') { ?>
<span class="badge bg-success">Accepted</span>
<?php } else { ?>
<span class="badge bg-danger">Declined</span>
<?php } ?>
</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>

</body>
</html>