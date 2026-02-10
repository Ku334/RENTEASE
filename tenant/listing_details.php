<?php
include("../includes/auth_check.php");
include("../config/db.php");

if ($_SESSION['role'] !== 'tenant') {
    header("Location: ../auth/login.php");
    exit();
}

include("../includes/header.php");

if (!isset($_GET['id'])) {
    echo "<p>Invalid listing.</p>";
    include("../includes/footer.php");
    exit();
}

$id = $_GET['id'];

$result = mysqli_query(
    $conn,
    "SELECT * FROM rooms WHERE id='$id' AND status='approved'"
);

if (mysqli_num_rows($result) !== 1) {
    echo "<p>Listing not found.</p>";
    include("../includes/footer.php");
    exit();
}

$room = mysqli_fetch_assoc($result);

$tenant_id = $_SESSION['user_id'];

/* CHECK EXISTING BOOKING */
$check_booking = mysqli_query(
    $conn,
    "SELECT id FROM bookings WHERE room_id='$id' AND tenant_id='$tenant_id'"
);

/* BOOKING LOGIC */
if (isset($_POST['book']) && mysqli_num_rows($check_booking) == 0) {

    $date = $_POST['booking_date'];

    $sql = "INSERT INTO bookings (room_id, tenant_id, booking_date, status)
            VALUES ('$id', '$tenant_id', '$date', 'pending')";

    if (mysqli_query($conn, $sql)) {
        $success = "Booking request sent successfully.";
    } else {
        $error = "Failed to book.";
    }
}
?>

<h2><?php echo htmlspecialchars($room['title']); ?></h2>

<!-- LISTING IMAGE -->
<?php if (!empty($room['image']) && file_exists("../assets/uploads/listings/" . $room['image'])) { ?>
    <img src="../assets/uploads/listings/<?php echo htmlspecialchars($room['image']); ?>"
         style="width:100%; max-height:320px; object-fit:cover; border-radius:8px; margin-bottom:20px;">
<?php } else { ?>
    <img src="../assets/images/placeholder.png"
         style="width:100%; max-height:320px; object-fit:cover; border-radius:8px; margin-bottom:20px;">
<?php } ?>

<p><b>Category:</b> <?php echo ucfirst($room['category']); ?></p>
<p><b>Location:</b> <?php echo htmlspecialchars($room['location']); ?></p>
<p><b>Price:</b> <?php echo htmlspecialchars($room['price']); ?></p>

<p style="margin-top:15px;">
    <?php echo nl2br(htmlspecialchars($room['description'])); ?>
</p>

<hr style="margin:25px 0;">

<h3>Book This Listing</h3>

<?php if (isset($success)) { ?>
    <p style="color:green;"><?php echo $success; ?></p>
<?php } ?>

<?php if (isset($error)) { ?>
    <p style="color:red;"><?php echo $error; ?></p>
<?php } ?>

<?php if (mysqli_num_rows($check_booking) > 0) { ?>
    <p style="color:#6b7280;">You have already booked this listing.</p>
<?php } else { ?>

<form method="post">
    <label>Select Booking Date</label>
    <input type="date" name="booking_date" min="<?php echo date('Y-m-d'); ?>" required>

    <button type="submit" name="book">Book Now</button>
</form>

<?php } ?>

<?php include("../includes/footer.php"); ?>