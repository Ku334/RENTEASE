<?php
include("../includes/auth_check.php");
include("../config/db.php");

if ($_SESSION['role'] !== 'owner') {
    header("Location: ../auth/login.php");
    exit();
}

include("../includes/header.php");

$owner_id = $_SESSION['user_id'];

$result = mysqli_query(
    $conn,
    "SELECT * FROM rooms 
     WHERE owner_id='$owner_id'
     ORDER BY id DESC"
);
?>

<h2>My Listings</h2>

<div class="category-grid">

<?php if (mysqli_num_rows($result) > 0) { ?>
    <?php while ($row = mysqli_fetch_assoc($result)) { ?>

        <div class="category-card">

            <!-- IMAGE -->
            <?php if (!empty($row['image']) && file_exists("../assets/uploads/listings/" . $row['image'])) { ?>
                <img src="../assets/uploads/listings/<?php echo htmlspecialchars($row['image']); ?>"
                     style="width:100%; height:160px; object-fit:cover; border-radius:6px; margin-bottom:10px;">
            <?php } else { ?>
                <img src="../assets/images/placeholder.png"
                     style="width:100%; height:160px; object-fit:cover; border-radius:6px; margin-bottom:10px;">
            <?php } ?>

            <!-- CATEGORY + STATUS -->
            <span class="badge"><?php echo ucfirst($row['category']); ?></span>
            <p><b>Status:</b> <?php echo ucfirst($row['status']); ?></p>

            <h3><?php echo htmlspecialchars($row['title']); ?></h3>
            <p><?php echo htmlspecialchars($row['location']); ?></p>
            <p><b>Price:</b> <?php echo htmlspecialchars($row['price']); ?></p>

            <!-- ACTIONS -->
            <div style="margin-top:10px;">
                <a href="edit_listing.php?id=<?php echo $row['id']; ?>">Edit</a> |
                <a href="delete_listing.php?id=<?php echo $row['id']; ?>"
                   onclick="return confirm('Are you sure you want to delete this listing?');">
                   Delete
                </a>
            </div>

        </div>

    <?php } ?>
<?php } else { ?>
    <p>You have not added any listings yet.</p>
<?php } ?>

</div>

<?php include("../includes/footer.php"); ?>