<?php
include("../includes/auth_check.php");
include("../config/db.php");

if ($_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit();
}

include("../includes/header.php");

$categories = ['room','office','electronics','vehicle'];
?>

<h2>System Reports (By Category)</h2>

<table>
<tr>
    <th>Category</th>
    <th>Total Listings</th>
    <th>Total Bookings</th>
</tr>

<?php
foreach ($categories as $cat) {

    $listings = mysqli_fetch_assoc(
        mysqli_query($conn, "SELECT COUNT(*) AS t FROM rooms WHERE category='$cat'")
    )['t'];

    $bookings = mysqli_fetch_assoc(
        mysqli_query(
            $conn,
            "SELECT COUNT(*) AS t 
             FROM bookings b 
             JOIN rooms r ON b.room_id=r.id 
             WHERE r.category='$cat'"
        )
    )['t'];
?>
<tr>
    <td><?php echo ucfirst($cat); ?></td>
    <td><?php echo $listings; ?></td>
    <td><?php echo $bookings; ?></td>
</tr>
<?php } ?>
</table>

<?php include("../includes/footer.php"); ?>