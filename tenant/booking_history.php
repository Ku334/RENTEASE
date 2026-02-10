<?php
include("../includes/auth_check.php");
include("../config/db.php");

if ($_SESSION['role'] !== 'tenant') {
    header("Location: ../auth/login.php");
    exit();
}

include("../includes/header.php");

$tenant_id = $_SESSION['user_id'];

/* CANCEL BOOKING */
if (isset($_POST['cancel_id'])) {
    $cancel_id = $_POST['cancel_id'];

    mysqli_query(
        $conn,
        "DELETE FROM bookings 
         WHERE id='$cancel_id' AND tenant_id='$tenant_id'"
    );
}

/* FETCH BOOKING HISTORY */
$result = mysqli_query(
    $conn,
    "SELECT 
        b.id AS booking_id,
        b.booking_date,
        b.status,
        r.title,
        r.category,
        r.location
     FROM bookings b
     JOIN rooms r ON b.room_id = r.id
     WHERE b.tenant_id='$tenant_id'
     ORDER BY b.id DESC"
);
?>

<h2>My Booking History</h2>

<?php if (mysqli_num_rows($result) == 0) { ?>

    <p>You have not made any bookings yet.</p>

<?php } else { ?>

<table border="1" cellpadding="10" cellspacing="0" width="100%">
    <tr>
        <th>Listing</th>
        <th>Category</th>
        <th>Location</th>
        <th>Booking Date</th>
        <th>Status</th>
        <th>Action</th>
    </tr>

<?php while ($row = mysqli_fetch_assoc($result)) { ?>
    <tr>
        <td><?php echo htmlspecialchars($row['title']); ?></td>
        <td><?php echo ucfirst($row['category']); ?></td>
        <td><?php echo htmlspecialchars($row['location']); ?></td>
        <td><?php echo $row['booking_date']; ?></td>
        <td><?php echo ucfirst($row['status']); ?></td>
        <td>
            <?php if ($row['status'] === 'pending') { ?>
                <form method="post" style="display:inline;">
                    <input type="hidden" name="cancel_id" value="<?php echo $row['booking_id']; ?>">
                    <button type="submit">
                        Cancel
                    </button>
                </form>
            <?php } else { ?>
                —
            <?php } ?>
        </td>
    </tr>
<?php } ?>

</table>

<?php } ?>

<?php include("../includes/footer.php"); ?>