<?php

include '../includes/admin-auth.php';
include '../config/database.php';
include 'admin-header.php';
$sql = "SELECT * FROM users ORDER BY id DESC";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html>
<head>
<title>Manage Users - TheLink</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>

<div class="container mt-5">

<a href="index.php" class="btn btn-secondary mb-3">
← Back to Admin Dashboard
</a>

<h2 class="page-title">Manage Users</h2>

<table class="table table-bordered">

<thead>
<tr>
<th>ID</th>
<th>Name</th>
<th>Email</th>
<th>Role</th>
<th>Action</th>
</tr>
</thead>

<tbody>

<?php while($row = $result->fetch_assoc()) { ?>

<tr>

<td><?php echo $row['id']; ?></td>
<td><?php echo $row['fullname']; ?></td>
<td><?php echo $row['email']; ?></td>

<td>
<?php if($row['role'] == 'admin') { ?>
<span class="badge bg-dark">Admin</span>
<?php } elseif($row['role'] == 'seller') { ?>
<span class="badge bg-success">Seller</span>
<?php } else { ?>
<span class="badge bg-primary">Buyer</span>
<?php } ?>
</td>

<td>

<?php if($row['role'] != 'admin') { ?>

<a href="edit-user.php?id=<?php echo $row['id']; ?>"
   class="btn btn-warning btn-sm">
Edit
</a>

<a href="delete-user.php?id=<?php echo $row['id']; ?>"
   class="btn btn-danger btn-sm"
   onclick="return confirm('Delete this user?')">
Delete
</a>

<?php } else { ?>

<span class="badge bg-secondary">Protected Admin</span>

<?php } ?>

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

<?php include 'admin-footer.php'; ?>