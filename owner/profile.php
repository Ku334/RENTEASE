<?php
include("../includes/auth_check.php");
include("../config/db.php");

if ($_SESSION['role'] !== 'owner') {
    header("Location: ../auth/login.php");
    exit();
}

include("../includes/header.php");

$user_id = $_SESSION['user_id'];

$user = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT * FROM users WHERE id='$user_id'")
);
?>

<h2>Owner Profile</h2>

<form>

    <label>Full Name</label>
    <input type="text" value="<?php echo htmlspecialchars($user['name']); ?>" disabled>

    <label>Email</label>
    <input type="email" value="<?php echo htmlspecialchars($user['email']); ?>" disabled>

    <label>Account Type</label>
    <input type="text" value="Property Owner" disabled>

    <label>KYC Status</label>
    <input type="text" value="Not Verified" disabled>

    <p style="color:#6b7280; margin-top:10px;">
        KYC verification for property owners will be available in a future phase.
    </p>

</form>

<?php include("../includes/footer.php"); ?>