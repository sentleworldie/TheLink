<?php

include '../includes/admin-auth.php';
include '../config/database.php';
include 'admin-header.php';
$sql = "SELECT products.*, users.fullname
        FROM products
        INNER JOIN users ON products.user_id = users.id
        ORDER BY products.id DESC";

$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html>
<head>
<title>Manage Products - TheLink</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>

<div class="container mt-5">

<a href="index.php" class="btn btn-secondary mb-3">
← Back to Admin Dashboard
</a>

<h2 class="page-title">Manage Products</h2>

<table class="table table-bordered">

<thead>
<tr>
<th>ID</th>
<th>Product</th>
<th>Seller</th>
<th>Price</th>
<th>Status</th>
<th>Action</th>
</tr>
</thead>

<tbody>

<?php while($row = $result->fetch_assoc()) { ?>

<tr>

<td><?php echo $row['id']; ?></td>
<td><?php echo $row['title']; ?></td>
<td><?php echo $row['fullname']; ?></td>
<td>R<?php echo number_format($row['price'], 2); ?></td>

<td>
<?php if($row['status'] == 'available') { ?>
<span class="badge bg-success">Available</span>
<?php } elseif($row['status'] == 'pending') { ?>
<span class="badge bg-warning">Pending</span>
<?php } else { ?>
<span class="badge bg-danger">Sold</span>
<?php } ?>
</td>

<td>
<a href="delete-product.php?id=<?php echo $row['id']; ?>"
   class="btn btn-danger btn-sm"
   onclick="return confirm('Delete this product?')">
Delete
</a>
</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

<?php include 'admin-footer.php'; ?>