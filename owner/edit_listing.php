<?php
include("../includes/auth_check.php");
include("../config/db.php");

if ($_SESSION['role'] !== 'owner') {
    header("Location: ../auth/login.php");
    exit();
}

$id = $_GET['id'];
$owner_id = $_SESSION['user_id'];

$result = mysqli_query(
    $conn,
    "SELECT * FROM rooms WHERE id='$id' AND owner_id='$owner_id'"
);

if (mysqli_num_rows($result) !== 1) {
    die("Listing not found.");
}

$room = mysqli_fetch_assoc($result);

if (isset($_POST['update'])) {

    $title = $_POST['title'];
    $location = $_POST['location'];
    $price = $_POST['price'];
    $description = $_POST['description'];

    mysqli_query(
        $conn,
        "UPDATE rooms 
         SET title='$title', location='$location', price='$price', description='$description'
         WHERE id='$id' AND owner_id='$owner_id'"
    );

    header("Location: my_listings.php");
    exit();
}

include("../includes/header.php");
?>

<h2>Edit Listing</h2>

<form method="post">
    <label>Title</label>
    <input type="text" name="title" value="<?php echo $room['title']; ?>" required>

    <label>Location</label>
    <input type="text" name="location" value="<?php echo $room['location']; ?>" required>

    <label>Price</label>
    <input type="number" name="price" value="<?php echo $room['price']; ?>" required>

    <label>Description</label>
    <textarea name="description" required><?php echo $room['description']; ?></textarea>

    <button type="submit" name="update">Update Listing</button>
</form>

<?php include("../includes/footer.php"); ?>