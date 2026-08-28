<?php

include 'includes/auth.php';
include 'config/database.php';
include 'includes/header.php';

$user_id = $_SESSION['user_id'];

if(isset($_POST['reply']))
{
    $product_id = $_POST['product_id'];
    $receiver_id = $_POST['receiver_id'];
    $message = $_POST['message'];

    if($receiver_id != $user_id)
    {
        $insert = "INSERT INTO messages
                  (product_id, sender_id, receiver_id, message)
                  VALUES
                  ('$product_id', '$user_id', '$receiver_id', '$message')";

        $conn->query($insert);
    }
}

$sql = "
SELECT messages.*,
       products.title AS product_title,
       sender.fullname AS sender_name,
       receiver.fullname AS receiver_name
FROM messages
INNER JOIN products ON messages.product_id = products.id
INNER JOIN users AS sender ON messages.sender_id = sender.id
INNER JOIN users AS receiver ON messages.receiver_id = receiver.id
WHERE messages.sender_id='$user_id'
   OR messages.receiver_id='$user_id'
ORDER BY messages.created_at DESC
";

$result = $conn->query($sql);

?>

<div class="container mt-5">

<a href="dashboard.php" class="btn btn-secondary mb-3">
← Back to Dashboard
</a>

<h2 class="page-title">Messages</h2>

<?php while($row = $result->fetch_assoc()) { ?>

<div class="card p-4 mb-3">

<h5><?php echo $row['product_title']; ?></h5>

<p>
<strong>From:</strong> <?php echo $row['sender_name']; ?><br>
<strong>To:</strong> <?php echo $row['receiver_name']; ?><br>
<strong>Date:</strong> <?php echo $row['created_at']; ?>
</p>

<p>
<?php echo $row['message']; ?>
</p>

<?php
if($row['sender_id'] == $user_id)
{
    $reply_to = $row['receiver_id'];
}
else
{
    $reply_to = $row['sender_id'];
}
?>

<form method="POST">

<input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">
<input type="hidden" name="receiver_id" value="<?php echo $reply_to; ?>">

<textarea name="message"
          class="form-control mb-2"
          rows="2"
          placeholder="Write a reply..."
          required></textarea>

<button type="submit"
        name="reply"
        class="btn btn-primary btn-sm">
Reply
</button>

</form>

</div>

<?php } ?>

</div>

<?php include 'includes/footer.php'; ?>