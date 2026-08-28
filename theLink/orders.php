<?php

include 'includes/auth.php';
include 'config/database.php';
include 'includes/header.php';

$user_id = $_SESSION['user_id'];

$sql = "
SELECT orders.id,
       products.title,
       products.price,
       orders.status
FROM orders
INNER JOIN products ON orders.product_id = products.id
WHERE orders.buyer_id='$user_id'
ORDER BY orders.id DESC
";

$result = $conn->query($sql);

?>

<div class="container mt-5">

<a href="dashboard.php" class="btn btn-secondary mb-3">
← Back to Dashboard
</a>

<h2 class="page-title">My Orders</h2>

<table class="table table-bordered">

<thead>
<tr>
<th>Order ID</th>
<th>Product</th>
<th>Price</th>
<th>Status</th>
</tr>
</thead>

<tbody>

<?php while($row = $result->fetch_assoc()) { ?>

<tr>

<td><?php echo $row['id']; ?></td>

<td><?php echo $row['title']; ?></td>

<td>R<?php echo number_format($row['price'], 2); ?></td>

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

<?php include 'includes/footer.php'; ?>