<?php

include 'config/database.php';

$error = "";
$success = "";

if(isset($_POST['register']))
{
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    $check = "SELECT id FROM users WHERE email='$email'";
    $result = $conn->query($check);

    if($result->num_rows > 0)
    {
        $error = "This email is already registered.";
    }
    else
    {
        $sql = "INSERT INTO users (fullname, email, password, role)
                VALUES ('$fullname', '$email', '$password', '$role')";

        if($conn->query($sql))
        {
            $success = "Registration successful. You can now login.";
        }
        else
        {
            $error = "Registration failed.";
        }
    }
}

include 'includes/header.php';

?>

<div class="container mt-5">

<div class="row justify-content-center">

<div class="col-md-6">

<div class="card p-4">

<h2 class="text-center mb-4">Create Account</h2>

<?php if($error != "") { ?>
<div class="alert alert-danger"><?php echo $error; ?></div>
<?php } ?>

<?php if($success != "") { ?>
<div class="alert alert-success"><?php echo $success; ?></div>
<?php } ?>

<form method="POST">

<label>Full Name</label>
<input type="text" name="fullname" class="form-control mb-3" required>

<label>Email</label>
<input type="email" name="email" class="form-control mb-3" required>

<label>Password</label>
<input type="password" name="password" class="form-control mb-3" required>

<label>Account Type</label>
<select name="role" class="form-control mb-3" required>
<option value="">Select Account Type</option>
<option value="buyer">Buyer</option>
<option value="seller">Seller</option>
</select>

<button type="submit" name="register" class="btn btn-success w-100">
Register
</button>

</form>

<p class="text-center mt-3">
Already have an account?
<a href="login.php">Login here</a>
</p>

</div>

</div>

</div>

</div>

<?php include 'includes/footer.php'; ?>