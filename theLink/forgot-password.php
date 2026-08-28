<?php

include 'config/database.php';
include 'includes/header.php';

$message = "";
$error = "";

if(isset($_POST['reset']))
{
    $email = $_POST['email'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if($new_password != $confirm_password)
    {
        $error = "Passwords do not match.";
    }
    else
    {
        $check = "SELECT * FROM users WHERE email='$email'";
        $result = $conn->query($check);

        if($result->num_rows > 0)
        {
            $hashedPassword = password_hash($new_password, PASSWORD_DEFAULT);

            $update = "UPDATE users
                       SET password='$hashedPassword'
                       WHERE email='$email'";

            if($conn->query($update))
            {
                $message = "Password reset successful. You can now login.";
            }
            else
            {
                $error = "Password reset failed.";
            }
        }
        else
        {
            $error = "No account found with that email address.";
        }
    }
}

?>

<div class="container mt-5">

<div class="row justify-content-center">

<div class="col-md-5">

<div class="card p-4">

<h2 class="text-center mb-4">Reset Password</h2>

<?php if($message != "") { ?>
<div class="alert alert-success">
<?php echo $message; ?>
</div>
<?php } ?>

<?php if($error != "") { ?>
<div class="alert alert-danger">
<?php echo $error; ?>
</div>
<?php } ?>

<form method="POST">

<label>Email Address</label>
<input type="email"
       name="email"
       class="form-control mb-3"
       required>

<label>New Password</label>
<input type="password"
       name="new_password"
       class="form-control mb-3"
       required>

<label>Confirm New Password</label>
<input type="password"
       name="confirm_password"
       class="form-control mb-3"
       required>

<button type="submit"
        name="reset"
        class="btn btn-primary w-100">
Reset Password
</button>

</form>

<p class="text-center mt-3">
<a href="login.php">Back to Login</a>
</p>

</div>

</div>

</div>

</div>

<?php include 'includes/footer.php'; ?>