<?php

include 'includes/auth.php';
include 'config/database.php';
include 'includes/header.php';

if($_SESSION['role'] != 'seller')
{
    die("Only sellers can view listings.");
}

$user_id = $_SESSION['user_id'];

$sql = "
SELECT p.*, o.id AS order_id, o.status AS order_status, u.fullname AS buyer_name
FROM products p
LEFT JOIN orders o ON p.id = o.product_id AND o.status='pending'
LEFT JOIN users u ON o.buyer_id = u.id
WHERE p.user_id='$user_id'
ORDER BY p.id DESC
";

$result = $conn->query($sql);

?>

<div class="container mt-5">

<a href="dashboard.php" class="btn btn-secondary mb-3">
← Back to Dashboard
</a>

<h2 class="page-title">My Listings</h2>

<table class="table table-bordered">

<thead>
<tr>
<th>Product</th>
<th>Price</th>
<th>Status</th>
<th>Buyer Request</th>
<th>Actions</th>
</tr>
</thead>

<tbody>

<?php while($row = $result->fetch_assoc()) { ?>

<tr>

<td><?php echo $row['title']; ?></td>

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
<?php if($row['order_status'] == 'pending') { ?>
Pending request from <strong><?php echo $row['buyer_name']; ?></strong>
<?php } else { ?>
No pending request
<?php } ?>
</td>

<td>

<?php if($row['order_status'] == 'pending') { ?>

<a href="accept-order.php?id=<?php echo $row['order_id']; ?>"
   class="btn btn-success btn-sm">
Accept
</a>

<a href="decline-order.php?id=<?php echo $row['order_id']; ?>"
   class="btn btn-warning btn-sm">
Decline
</a>

<?php } ?>

<?php if($row['status'] == 'available') { ?>

<a href="delete-product.php?id=<?php echo $row['id']; ?>"
   class="btn btn-danger btn-sm"
   onclick="return confirm('Delete this listing?')">
Delete
</a>

<?php } else { ?>

<span class="badge bg-secondary">Cannot Delete</span>

<?php } ?>

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

<?php include 'includes/footer.php'; ?>