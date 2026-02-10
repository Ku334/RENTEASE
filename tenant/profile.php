<?php
include("../includes/auth_check.php");
include("../config/db.php");

if ($_SESSION['role'] !== 'tenant') {
    header("Location: ../auth/login.php");
    exit();
}

include("../includes/header.php");

$user_id = $_SESSION['user_id'];

$user = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT * FROM users WHERE id='$user_id'")
);
?>

<h2>My Profile</h2>

<form>
    <label>Full Name</label>
    <input type="text" value="<?php echo $user['name']; ?>" disabled>

    <label>Email</label>
    <input type="email" value="<?php echo $user['email']; ?>" disabled>

    <label>KYC Status</label>
    <input type="text" value="Not Verified" disabled>

    <p style="color:#6b7280;">
        KYC verification will be available in the next phase.
    </p>
</form>

<?php include("../includes/footer.php"); ?>