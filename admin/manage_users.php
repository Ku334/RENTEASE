<?php
include("../includes/auth_check.php");
include("../config/db.php");
include("../includes/header.php");

if ($_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit();
}

/* Delete user (except admin) */
if (isset($_GET['delete'])) {
    $user_id = $_GET['delete'];

    // Prevent deleting admin
    $check = mysqli_query($conn, "SELECT role FROM users WHERE id='$user_id'");
    $user  = mysqli_fetch_assoc($check);

    if ($user && $user['role'] != 'admin') {
        mysqli_query($conn, "DELETE FROM users WHERE id='$user_id'");
    }
}

$result = mysqli_query($conn, "SELECT * FROM users");
?>

<h2>Manage Users</h2>

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Role</th>
        <th>Action</th>
    </tr>

<?php
while ($row = mysqli_fetch_assoc($result)) {
?>
<tr>
    <td><?php echo $row['id']; ?></td>
    <td><?php echo $row['name']; ?></td>
    <td><?php echo $row['email']; ?></td>
    <td><?php echo ucfirst($row['role']); ?></td>
    <td>
        <?php if ($row['role'] != 'admin') { ?>
            <a href="?delete=<?php echo $row['id']; ?>"
               onclick="return confirm('Delete this user?');">
               Delete
            </a>
        <?php } else { ?>
            -
        <?php } ?>
    </td>
</tr>
<?php } ?>
</table>

<?php include("../includes/footer.php"); ?>