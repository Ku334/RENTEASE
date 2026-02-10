<?php
include("../includes/auth_check.php");

if ($_SESSION['role'] !== 'tenant') {
    header("Location: ../auth/login.php");
    exit();
}

include("../includes/header.php");
?>

<section class="hero">
    <h1>Welcome, <?php echo $_SESSION['name']; ?></h1>
    <p>Browse rentals and manage your bookings</p>
</section>

<h2>Browse Categories</h2>

<div class="category-grid">

    <div class="category-card">
        <span class="badge">Room</span>
        <h3>🏠 Rooms</h3>
        <p>Comfortable living spaces</p>
        <a href="../browse.php?category=room">Browse Rooms</a>
    </div>

    <div class="category-card">
        <span class="badge">Office</span>
        <h3>🏢 Office Spaces</h3>
        <p>Work-ready offices</p>
        <a href="../browse.php?category=office">Browse Offices</a>
    </div>

    <div class="category-card">
        <span class="badge">Electronics</span>
        <h3>💻 Electronics</h3>
        <p>Devices for rent</p>
        <a href="../browse.php?category=electronics">Browse Electronics</a>
    </div>

    <div class="category-card">
        <span class="badge">Vehicle</span>
        <h3>🚗 Vehicles</h3>
        <p>Cars & transport</p>
        <a href="../browse.php?category=vehicle">Browse Vehicles</a>
    </div>

</div>

<h2 style="margin-top:40px;">My Account</h2>

<div class="category-grid">

    <div class="category-card">
        <h3>📖 My Booking History</h3>
        <p>Track your bookings</p>
        <a href="booking_history.php">View Bookings</a>
    </div>

    <div class="category-card">
        <h3>👤 My Profile</h3>
        <p>KYC & personal info</p>
        <a href="profile.php">View Profile</a>
    </div>

</div>

<?php include("../includes/footer.php"); ?>