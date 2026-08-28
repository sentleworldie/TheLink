<?php

session_start();
include '../config/database.php';

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
            if($user['role'] == 'admin')
            {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['fullname'] = $user['fullname'];
                $_SESSION['role'] = $user['role'];

                header("Location: index.php");
                exit();
            }
            else
            {
                $error = "Access denied. Admin users only.";
            }
        }
        else
        {
            $error = "Incorrect password.";
        }
    }
    else
    {
        $error = "Admin account not found.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Admin Login - TheLink</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<link rel="stylesheet" href="../assets/css/style.css">

</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">

<div class="container">

<a class="navbar-brand" href="../index.php">
<i class="bi bi-link-45deg"></i> TheLink Admin
</a>

<a href="../login.php" class="btn btn-light btn-sm">
User Login
</a>

</div>

</nav>

<div class="container mt-5">

<div class="row justify-content-center">

<div class="col-md-5">

<div class="card p-4">

<div class="text-center mb-3">

<h1>🛠️</h1>

<h2>Admin Login</h2>

<p class="text-muted">
Access the TheLink management portal.
</p>

</div>

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
       placeholder="admin@thelink.com"
       required>

<label>Password</label>
<input type="password"
       name="password"
       class="form-control mb-3"
       placeholder="Enter password"
       required>

<button type="submit"
        name="login"
        class="btn btn-primary w-100">
<i class="bi bi-shield-lock"></i> Login as Admin
</button>

</form>

<p class="text-center mt-3">
<a href="../index.php">← Back to Website</a>
</p>

</div>

</div>

</div>

</div>

<footer>

<div class="container">

<h5>TheLink Admin</h5>

<p>Secure administration portal.</p>

<small>
&copy; <?php echo date("Y"); ?> TheLink. All rights reserved.
</small>

</div>

</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script src="../assets/js/app.js"></script>

</body>
</html>