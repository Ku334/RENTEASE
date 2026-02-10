<?php
include("../includes/auth_check.php");
include("../config/db.php");

if ($_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit();
}

include("../includes/header.php");

$users = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) AS t FROM users"))['t'];
$listings = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) AS t FROM rooms"))['t'];
$bookings = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) AS t FROM bookings"))['t'];
?>

<h2>Admin Dashboard</h2>

<div class="category-grid">
    <div class="category-card">
        <h3>Total Users</h3>
        <p><?php echo $users; ?></p>
    </div>

    <div class="category-card">
        <h3>Total Listings</h3>
        <p><?php echo $listings; ?></p>
    </div>

    <div class="category-card">
        <h3>Total Bookings</h3>
        <p><?php echo $bookings; ?></p>
    </div>
</div>

<?php include("../includes/footer.php"); ?>