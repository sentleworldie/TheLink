<?php

include 'includes/auth.php';
include 'config/database.php';
include 'includes/header.php';

if($_SESSION['role'] != 'seller')
{
    die("Only sellers can add products.");
}

$success = "";

if(isset($_POST['add_product']))
{
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category = $_POST['category'];

    $image = $_FILES['image']['name'];
    $tmp = $_FILES['image']['tmp_name'];

    move_uploaded_file($tmp, "assets/uploads/" . $image);

    $user_id = $_SESSION['user_id'];

    $sql = "INSERT INTO products
            (user_id, title, description, price, category, image, status)
            VALUES
            ('$user_id', '$title', '$description', '$price', '$category', '$image', 'available')";

    if($conn->query($sql))
    {
        $success = "Product added successfully!";
    }
}

?>

<div class="container mt-5">

<a href="dashboard.php" class="btn btn-secondary mb-3">
← Back to Dashboard
</a>

<div class="row justify-content-center">

<div class="col-md-7">

<div class="card p-4">

<h2 class="page-title">Add Product</h2>

<?php if($success != "") { ?>

<div class="alert alert-success">
<?php echo $success; ?>
</div>

<?php } ?>

<form method="POST" enctype="multipart/form-data">

<label>Product Name</label>
<input type="text" name="title" class="form-control mb-3" required>

<label>Description</label>
<textarea name="description" class="form-control mb-3" rows="4" required></textarea>

<label>Price</label>
<input type="number" step="0.01" name="price" class="form-control mb-3" required>

<label>Category</label>
<select name="category" class="form-control mb-3" required>
<option value="">Select Category</option>
<option value="Electronics">Electronics</option>
<option value="Fashion">Fashion</option>
<option value="Furniture">Furniture</option>
<option value="Vehicles">Vehicles</option>
<option value="Other">Other</option>
</select>

<label>Product Image</label>
<input type="file" name="image" class="form-control mb-3" required>

<button type="submit" name="add_product" class="btn btn-success w-100">
Add Product
</button>

</form>

</div>

</div>

</div>

</div>

<?php include 'includes/footer.php'; ?>