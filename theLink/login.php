<?php

session_start();
include 'config/database.php';

$error = "";

if(isset($_POST['login']))
{
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if($result->num_rows > 0)
    {
        $user = $result->fetch_assoc();

        if(password_verify($password, $user['password']))
        {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['fullname'] = $user['fullname'];
            $_SESSION['role'] = $user['role'];

            header("Location: dashboard.php");
            exit();
        }
        else
        {
            $error = "Incorrect password.";
        }
    }
    else
    {
        $error = "Email not found.";
    }
}

include 'includes/header.php';

?>

<div class="container mt-5">

<div class="row justify-content-center">

<div class="col-md-5">

<div class="card p-4">

<h2 class="text-center mb-4">Login to TheLink</h2>

<?php if($error != "") { ?>
<div class="alert alert-danger">
<?php echo $error; ?>
</div>
<?php } ?>

<form method="POST">

<label>Email</label>
<input type="email" name="email" class="form-control mb-3" required>

<label>Password</label>
<input type="password" name="password" class="form-control mb-3" required>

<button type="submit" name="login" class="btn btn-primary w-100">
Login
</button>

</form>

<p class="text-center mt-3">
Don't have an account?
<a href="register.php">Register here</a>
</p>
<p class="text-center mt-3">
<a href="forgot-password.php">Forgot Password?</a>
</p>
    
<p class="text-center mt-3">
Login as Admin?
<a href="admin/login.php">Login here</a>
</p>

</div>

</div>

</div>

</div>

<?php include 'includes/footer.php'; ?>