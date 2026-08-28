<?php

include 'config/database.php';
include 'includes/header.php';

$category = isset($_GET['category']) ? $conn->real_escape_string($_GET['category']) : '';
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';

$sql = "SELECT * FROM products WHERE status='available'";

if($category != '')
{
    $sql .= " AND category='$category'";
}

if($search != '')
{
    $sql .= " AND title LIKE '%$search%'";
}

$sql .= " ORDER BY created_at DESC";

$result = $conn->query($sql);

$countSql = str_replace("SELECT *", "SELECT COUNT(*) AS total", $sql);
$countResult = $conn->query($countSql);
$count = $countResult->fetch_assoc();

?>

<div class="container mt-5">

<a href="dashboard.php" class="btn btn-secondary mb-3">
← Back to Dashboard
</a>

<h1 class="page-title">TheLink Marketplace</h1>

<div class="alert alert-primary">
Available Products: <strong><?php echo $count['total']; ?></strong>
</div>

<form method="GET" class="row mb-4">

<div class="col-md-6 mb-2">
<input type="text"
       name="search"
       class="form-control"
       placeholder="Search products..."
       value="<?php echo $search; ?>">
</div>

<div class="col-md-4 mb-2">
<select name="category" class="form-control">
<option value="">All Categories</option>

<option value="Electronics" <?php if($category == 'Electronics') echo 'selected'; ?>>
Electronics
</option>

<option value="Fashion" <?php if($category == 'Fashion') echo 'selected'; ?>>
Clothing
</option>

<option value="Furniture" <?php if($category == 'Furniture') echo 'selected'; ?>>
Furniture
</option>

<option value="Vehicles" <?php if($category == 'Vehicles') echo 'selected'; ?>>
Vehicles
</option>

<option value="Other" <?php if($category == 'Other') echo 'selected'; ?>>
Other
</option>
</select>
</div>

<div class="col-md-2 mb-2">
<button type="submit" class="btn btn-primary w-100">
Search
</button>
</div>

</form>

<div class="row g-4">

<?php while($row = $result->fetch_assoc()) { ?>

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
   class="btn btn-primary w-100 mt-2">
View Product
</a>

</div>

</div>

</div>

<?php } ?>

</div>

</div>

<?php include 'includes/footer.php'; ?>