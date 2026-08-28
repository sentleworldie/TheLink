<?php
if(session_status() == PHP_SESSION_NONE)
{
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>TheLink</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<link rel="stylesheet" href="assets/css/style.css">

</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">

<div class="container">

<a class="navbar-brand" href="index.php">
<i class="bi bi-link-45deg"></i> TheLink
</a>

<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
<span class="navbar-toggler-icon"></span>
</button>

<div class="collapse navbar-collapse" id="navbarNav">

<ul class="navbar-nav ms-auto">

<li class="nav-item">
<a class="nav-link" href="index.php">
<i class="bi bi-house-door"></i> Home
</a>
</li>

<li class="nav-item">
<a class="nav-link" href="marketplace.php">
<i class="bi bi-shop"></i> Marketplace
</a>
</li>

<?php if(isset($_SESSION['user_id'])) { ?>

<li class="nav-item">
<a class="nav-link" href="dashboard.php">
<i class="bi bi-speedometer2"></i> Dashboard
</a>
</li>

<li class="nav-item">
<a class="nav-link" href="logout.php">
<i class="bi bi-box-arrow-right"></i> Logout
</a>
</li>

<?php } else { ?>

<li class="nav-item">
<a class="nav-link" href="login.php">
<i class="bi bi-box-arrow-in-right"></i> Login
</a>
</li>

<li class="nav-item">
<a class="nav-link" href="register.php">
<i class="bi bi-person-plus"></i> Register
</a>
</li>

<?php } ?>
<li class="nav-item">
<button id="darkModeToggle" class="btn btn-light btn-sm ms-2">
🌙 Dark Mode
</button>
</li>
</ul>

</div>

</div>

</nav>