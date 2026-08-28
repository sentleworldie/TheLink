<?php

include '../includes/admin-auth.php';
include '../config/database.php';
include 'admin-header.php';
if(!isset($_GET['id']))
{
    header("Location: users.php");
    exit();
}

$id = $_GET['id'];

$sql = "SELECT * FROM users WHERE id='$id'";
$result = $conn->query($sql);

if($result->num_rows == 0)
{
    die("User not found.");
}

$user = $result->fetch_assoc();

if($user['role'] == 'admin')
{
    die("Admin accounts cannot be edited.");
}

if(isset($_POST['update']))
{
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    $update = "UPDATE users
               SET fullname='$fullname',
                   email='$email',
                   role='$role'
               WHERE id='$id'
               AND role != 'admin'";

    if($conn->query($update))
    {
        header("Location: users.php");
        exit();
    }
    else
    {
        $error = "Update failed: " . $conn->error;
    }
}

?>

<!DOCTYPE html>
<html>
<head>
<title>Edit User - TheLink</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>

<div class="container mt-5">

<a href="users.php" class="btn btn-secondary mb-3">
← Back to Users
</a>

<div class="row justify-content-center">

<div class="col-md-6">

<div class="card p-4">

<h2 class="page-title">Edit User</h2>

<?php if(isset($error)) { ?>
<div class="alert alert-danger"><?php echo $error; ?></div>
<?php } ?>

<form method="POST">

<label>Full Name</label>
<input type="text"
       name="fullname"
       value="<?php echo $user['fullname']; ?>"
       class="form-control mb-3"
       required>

<label>Email</label>
<input type="email"
       name="email"
       value="<?php echo $user['email']; ?>"
       class="form-control mb-3"
       required>

<label>Role</label>
<select name="role" class="form-control mb-3">

<option value="buyer" <?php if($user['role']=='buyer') echo 'selected'; ?>>
Buyer
</option>

<option value="seller" <?php if($user['role']=='seller') echo 'selected'; ?>>
Seller
</option>

</select>

<button type="submit" name="update" class="btn btn-success w-100">
Update User
</button>

</form>

</div>

</div>

</div>

</div>

<?php include 'admin-footer.php'; ?>