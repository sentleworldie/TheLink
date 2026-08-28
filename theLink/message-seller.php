<?php

include 'includes/auth.php';
include 'config/database.php';
include 'includes/header.php';

if(!isset($_GET['product_id']))
{
    header("Location: marketplace.php");
    exit();
}

$product_id = $_GET['product_id'];
$user_id = $_SESSION['user_id'];

$sql = "SELECT products.*, users.fullname AS seller_name
        FROM products
        INNER JOIN users ON products.user_id = users.id
        WHERE products.id='$product_id'";

$result = $conn->query($sql);

if($result->num_rows == 0)
{
    die("Product not found.");
}

$product = $result->fetch_assoc();

$seller_id = $product['user_id'];

if($seller_id == $user_id)
{
    die("You cannot message yourself about your own product.");
}

$success = "";

if(isset($_POST['send_message']))
{
    $message = $_POST['message'];

    $insert = "INSERT INTO messages
              (product_id, sender_id, receiver_id, message)
              VALUES
              ('$product_id', '$user_id', '$seller_id', '$message')";

    if($conn->query($insert))
    {
        $success = "Message sent to seller successfully.";
    }
}

?>

<div class="container mt-5">

<a href="product-details.php?id=<?php echo $product_id; ?>" class="btn btn-secondary mb-3">
← Back to Product
</a>

<div class="row justify-content-center">

<div class="col-md-7">

<div class="card p-4">

<h2 class="page-title">Message Seller</h2>

<p>
<strong>Product:</strong> <?php echo $product['title']; ?>
</p>

<p>
<strong>Seller:</strong> <?php echo $product['seller_name']; ?>
</p>

<?php if($success != "") { ?>
<div class="alert alert-success">
<?php echo $success; ?>
</div>
<?php } ?>

<form method="POST">

<label>Your Message</label>
<textarea name="message" class="form-control mb-3" rows="5" required></textarea>

<button type="submit" name="send_message" class="btn btn-primary w-100">
Send Message
</button>

</form>

</div>

</div>

</div>

</div>

<?php include 'includes/footer.php'; ?>