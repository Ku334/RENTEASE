<?php
include("../config/db.php");
session_start();

$role = $_GET['role'] ?? '';

if (!in_array($role, ['tenant', 'owner'])) {
    header("Location: register_choice.php");
    exit();
}

if (isset($_POST['register'])) {

    $name     = $_POST['name'];
    $email    = $_POST['email'];
    $password = md5($_POST['password']); // exam-level hashing

    $check = mysqli_query($conn, "SELECT id FROM users WHERE email='$email'");
    if (mysqli_num_rows($check) > 0) {
        $error = "Email already exists";
    } else {
        $sql = "INSERT INTO users (name, email, password, role)
                VALUES ('$name','$email','$password','$role')";

        if (mysqli_query($conn, $sql)) {
            header("Location: login.php");
            exit();
        } else {
            $error = "Registration failed";
        }
    }
}

include("../includes/header.php");
?>

<h2>Register as <?php echo ucfirst($role); ?></h2>

<?php if (isset($error)) { ?>
    <p style="color:red;"><?php echo $error; ?></p>
<?php } ?>

<form method="post">

    <label>Full Name</label>
    <input type="text" name="name" required>

    <label>Email</label>
    <input type="email" name="email" required>

    <label>Password</label>
    <input type="password" name="password" required>

    <button type="submit" name="register">Create Account</button>
</form>

<p style="margin-top:15px;">
    Already registered?
    <a href="login.php">Login here</a>
</p>

<?php include("../includes/footer.php"); ?>