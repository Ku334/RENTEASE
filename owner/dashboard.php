<?php
include("../includes/auth_check.php");
include("../config/db.php");

if ($_SESSION['role'] !== 'owner') {
    header("Location: ../auth/login.php");
    exit();
}

include("../includes/header.php");

$owner_id = $_SESSION['user_id'];

/* Total listings */
$total_listings = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS total FROM rooms WHERE owner_id='$owner_id'")
)['total'];

/* Listings by category */
$room_count = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS total FROM rooms WHERE owner_id='$owner_id' AND category='room'")
)['total'];

$office_count = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS total FROM rooms WHERE owner_id='$owner_id' AND category='office'")
)['total'];

$electronics_count = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS total FROM rooms WHERE owner_id='$owner_id' AND category='electronics'")
)['total'];

$vehicle_count = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS total FROM rooms WHERE owner_id='$owner_id' AND category='vehicle'")
)['total'];
?>

<h2>Owner Dashboard</h2>
<p>Welcome, <?php echo $_SESSION['name']; ?></p>

<div class="category-grid">

    <div class="category-card">
        <h3>Total Listings</h3>
        <p><?php echo $total_listings; ?></p>
    </div>

    <div class="category-card">
        <h3>🏠 Rooms</h3>
        <p><?php echo $room_count; ?> Listings</p>
    </div>

    <div class="category-card">
        <h3>🏢 Offices</h3>
        <p><?php echo $office_count; ?> Listings</p>
    </div>

    <div class="category-card">
        <h3>💻 Electronics</h3>
        <p><?php echo $electronics_count; ?> Listings</p>
    </div>

    <div class="category-card">
        <h3>🚗 Vehicles</h3>
        <p><?php echo $vehicle_count; ?> Listings</p>
    </div>

    <div class="category-card">
        <h3>Add New Listing</h3>
        <a href="add_listing.php">Add Listing</a>
    </div>

    <div class="category-card">
        <h3>My Listings</h3>
        <a href="my_listings.php">View Listings</a>
    </div>

    <div class="category-card">
        <h3>Booking Requests</h3>
        <a href="booking_requests.php">View Requests</a>
    </div>

</div>

<?php include("../includes/footer.php"); ?>