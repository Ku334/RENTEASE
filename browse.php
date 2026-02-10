<?php
include("includes/header.php");
include("config/db.php");

/* CATEGORY VALIDATION */
$category = $_GET['category'] ?? '';
$allowed = ['room', 'office', 'electronics', 'vehicle'];

if (!in_array($category, $allowed)) {
    echo "<h2>Invalid category</h2>";
    include("includes/footer.php");
    exit();
}

/* SEARCH */
$search = $_GET['q'] ?? '';

$sql = "SELECT * FROM rooms 
        WHERE status='approved'
        AND category='$category'";

if (!empty($search)) {
    $sql .= " AND (title LIKE '%$search%' OR location LIKE '%$search%')";
}

$sql .= " ORDER BY id DESC";

$result = mysqli_query($conn, $sql);
?>

<h2 style="text-transform:capitalize;">
    Browse <?php echo htmlspecialchars($category); ?>
</h2>

<!-- SEARCH FORM -->
<form method="get" style="margin:20px 0;">
    <input type="hidden" name="category" value="<?php echo htmlspecialchars($category); ?>">

    <input type="text"
        name="q"
        placeholder="Search by title or location"
        value="<?php echo htmlspecialchars($search); ?>"
        style="width:250px;">

    <button type="submit">Search</button>
</form>

<div class="category-grid">

    <?php if (mysqli_num_rows($result) == 0) { ?>

        <p>No listings found.</p>

    <?php } else { ?>

        <?php while ($row = mysqli_fetch_assoc($result)) { ?>

            <div class="category-card">

                <!-- IMAGE -->
                <?php if (!empty($row['image']) && file_exists("assets/uploads/listings/" . $row['image'])) { ?>
                    <img src="assets/uploads/listings/<?php echo htmlspecialchars($row['image']); ?>"
                        style="width:100%; height:160px; object-fit:cover; border-radius:6px; margin-bottom:10px;">
                <?php } else { ?>
                    <img src="assets/images/placeholder.png"
                        style="width:100%; height:160px; object-fit:cover; border-radius:6px; margin-bottom:10px;">
                <?php } ?>

                <!-- CATEGORY -->
                <span class="badge"><?php echo ucfirst($row['category']); ?></span>

                <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                <p><?php echo htmlspecialchars($row['location']); ?></p>
                <p><b>Price:</b> <?php echo htmlspecialchars($row['price']); ?></p>

                <!-- ACTION -->
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'tenant') { ?>
                    <a href="tenant/listing_details.php?id=<?php echo $row['id']; ?>">
                        View & Book
                    </a>
                <?php } else { ?>
                    <a href="auth/login.php">
                        Login to Book
                    </a>
                <?php } ?>

            </div>

        <?php } ?>

    <?php } ?>

</div>

<?php include("includes/footer.php"); ?>