<?php

include '../includes/admin-auth.php';
include '../config/database.php';
include 'admin-header.php';
$sql = "
SELECT orders.id,
       orders.status,
       products.title,
       users.fullname AS buyer_name
FROM orders
INNER JOIN products ON orders.product_id = products.id
INNER JOIN users ON orders.buyer_id = users.id
ORDER BY orders.id DESC
";

$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html>
<head>
<title>Manage Orders - TheLink</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>

<div class="container mt-5">

<a href="index.php" class="btn btn-secondary mb-3">
← Back to Admin Dashboard
</a>

<h2 class="page-title">Manage Orders</h2>

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

<?php while($row = $result->fetch_assoc()) { ?>

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

<?php include 'admin-footer.php'; ?>