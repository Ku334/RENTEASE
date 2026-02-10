<?php
include("../config/db.php");
session_start();

if (isset($_SESSION['user_id'])) {
    // Already logged in
    if ($_SESSION['role'] === 'tenant') {
        header("Location: ../tenant/dashboard.php");
    } elseif ($_SESSION['role'] === 'owner') {
        header("Location: ../owner/dashboard.php");
    } else {
        header("Location: ../admin/dashboard.php");
    }
    exit();
}

if (isset($_POST['login'])) {

    $email = $_POST['email'];
    $password = md5($_POST['password']); // exam-level hashing

    $sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['name']    = $user['name'];
        $_SESSION['role']    = $user['role'];

        // Role-based redirect
        if ($user['role'] === 'tenant') {
            header("Location: ../tenant/dashboard.php");
        } elseif ($user['role'] === 'owner') {
            header("Location: ../owner/dashboard.php");
        } else {
            header("Location: ../admin/dashboard.php");
        }
        exit();

    } else {
        $error = "Invalid email or password";
    }
}

include("../includes/header.php");
?>

<h2>Login</h2>

<?php if (isset($error)) { ?>
    <p style="color:red;"><?php echo $error; ?></p>
<?php } ?>

<form method="post">

    <label>Email</label>
    <input type="email" name="email" required>

    <label>Password</label>
    <input type="password" name="password" required>

    <button type="submit" name="login">Login</button>
</form>

<p style="margin-top:15px;">
    Don’t have an account?
    <a href="register_choice.php">Register here</a>
</p>

<?php include("../includes/footer.php"); ?>