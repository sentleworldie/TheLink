<?php

include 'includes/auth.php';
include 'config/database.php';
include 'includes/header.php';

$id = $_GET['id'];

$sql = "SELECT products.*, users.fullname
        FROM products
        INNER JOIN users ON products.user_id = users.id
        WHERE products.id='$id'";

$result = $conn->query($sql);

if($result->num_rows == 0)
{
    die("Product not found.");
}

$product = $result->fetch_assoc();

if(isset($_POST['buy']))
{
    $buyer_id = $_SESSION['user_id'];

    if($product['user_id'] == $buyer_id)
    {
        $message = "You cannot purchase your own product.";
        $alert = "danger";
    }
    else
    {
        $insert = "INSERT INTO orders (buyer_id, product_id, status)
                   VALUES ('$buyer_id', '$id', 'pending')";

        if($conn->query($insert))
        {
            $conn->query("UPDATE products SET status='pending' WHERE id='$id'");
            $message = "Purchase request sent to seller.";
            $alert = "success";
        }
    }
}

?>

<div class="container mt-5">

<a href="marketplace.php" class="btn btn-secondary mb-4">
← Back to Marketplace
</a>

<div class="row g-4">

<div class="col-md-6">

<img src="assets/uploads/<?php echo $product['image']; ?>"
     class="product-image">

</div>

<div class="col-md-6">

<h1 class="page-title">
<?php echo $product['title']; ?>
</h1>

<div class="mb-3">

<span class="badge bg-primary">
Category: <?php echo $product['category']; ?>
</span>

<span class="badge bg-secondary">
Seller: <?php echo $product['fullname']; ?>
</span>

<span class="badge bg-info">
Status: <?php echo ucfirst($product['status']); ?>
</span>

</div>

<p class="lead">
<?php echo $product['description']; ?>
</p>

<h2 class="price-text mb-4">
R<?php echo number_format($product['price'], 2); ?>
</h2>
<?php if($product['user_id'] != $_SESSION['user_id']) { ?>

<a href="message-seller.php?product_id=<?php echo $product['id']; ?>"
   class="btn btn-primary btn-lg w-100 mt-3">
Message Seller
</a>

<?php } ?>
<?php if(isset($message)) { ?>

<div class="alert alert-<?php echo $alert; ?>">
<?php echo $message; ?>
</div>

<?php } ?>

<?php if($product['status'] == 'available') { ?>

<form method="POST">

<button type="submit"
        name="buy"
        class="btn btn-success btn-lg w-100">
Buy Now
</button>

</form>

<?php } else { ?>

<div class="alert alert-warning">
This product is currently unavailable.
</div>

<?php } ?>

</div>

</div>

</div>

<?php include 'includes/footer.php'; ?>