<?php
include("../includes/auth_check.php");
include("../config/db.php");

if ($_SESSION['role'] !== 'owner') {
    header("Location: ../auth/login.php");
    exit();
}

include("../includes/header.php");

$owner_id = $_SESSION['user_id'];

/* HANDLE ACTIONS */
if (isset($_POST['action'], $_POST['booking_id'])) {

    $booking_id = $_POST['booking_id'];
    $action = $_POST['action'];

    if ($action === 'approve') {
        $status = 'approved';
    } elseif ($action === 'reject') {
        $status = 'rejected';
    }

    mysqli_query(
        $conn,
        "UPDATE bookings 
         SET status='$status' 
         WHERE id='$booking_id'"
    );
}

/* FETCH BOOKING REQUESTS */
$result = mysqli_query(
    $conn,
    "SELECT 
        b.id AS booking_id,
        b.booking_date,
        b.status,
        u.name AS tenant_name,
        r.title AS listing_title,
        r.category
     FROM bookings b
     JOIN rooms r ON b.room_id = r.id
     JOIN users u ON b.tenant_id = u.id
     WHERE r.owner_id='$owner_id'
     ORDER BY b.id DESC"
);
?>

<h2>Booking Requests</h2>

<?php if (mysqli_num_rows($result) === 0) { ?>

    <p>No booking requests found.</p>

<?php } else { ?>

<table border="1" cellpadding="10" cellspacing="0" width="100%">
    <tr>
        <th>Listing</th>
        <th>Category</th>
        <th>Tenant</th>
        <th>Booking Date</th>
        <th>Status</th>
        <th>Action</th>
    </tr>

<?php while ($row = mysqli_fetch_assoc($result)) { ?>

    <tr>
        <td><?php echo htmlspecialchars($row['listing_title']); ?></td>
        <td><?php echo ucfirst($row['category']); ?></td>
        <td><?php echo htmlspecialchars($row['tenant_name']); ?></td>
        <td><?php echo $row['booking_date']; ?></td>
        <td><?php echo ucfirst($row['status']); ?></td>
        <td>
            <?php if ($row['status'] === 'pending') { ?>
                <form method="post" style="display:inline;">
                    <input type="hidden" name="booking_id" value="<?php echo $row['booking_id']; ?>">
                    <button name="action" value="approve"
                            style="background:#16a34a;color:white;">
                        Approve
                    </button>
                    <button name="action" value="reject"
                            style="background:#dc2626;color:white;">
                        Reject
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