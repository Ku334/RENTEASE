<?php
include("../includes/auth_check.php");
include("../config/db.php");

if ($_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit();
}

/* Approve room */
if (isset($_GET['approve'])) {
    $room_id = $_GET['approve'];
    mysqli_query($conn, "UPDATE rooms SET status='approved' WHERE id='$room_id'");
}

/* Reject room */
if (isset($_GET['reject'])) {
    $room_id = $_GET['reject'];
    mysqli_query($conn, "DELETE FROM rooms WHERE id='$room_id'");
}

$result = mysqli_query($conn, "SELECT rooms.*, users.name AS owner_name 
                               FROM rooms 
                               JOIN users ON rooms.owner_id = users.id
                               WHERE status='pending'");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Approve Rooms | RENTEASE</title>
</head>
<body>

<h2>Pending Room Listings</h2>

<table border="1" cellpadding="10">
    <tr>
        <th>Owner</th>
        <th>Title</th>
        <th>Location</th>
        <th>Price</th>
        <th>Action</th>
    </tr>

<?php
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
?>
<tr>
    <td><?php echo $row['owner_name']; ?></td>
    <td><?php echo $row['title']; ?></td>
    <td><?php echo $row['location']; ?></td>
    <td><?php echo $row['price']; ?></td>
    <td>
        <a href="?approve=<?php echo $row['id']; ?>">Approve</a> |
        <a href="?reject=<?php echo $row['id']; ?>"
           onclick="return confirm('Reject this room?');">
           Reject
        </a>
    </td>
</tr>
<?php
    }
} else {
    echo "<tr><td colspan='5'>No pending rooms.</td></tr>";
}
?>
</table>

<br>
<a href="dashboard.php">Back to Dashboard</a>

</body>
</html>