<?php
include("../includes/auth_check.php");
include("../config/db.php");

if ($_SESSION['role'] !== 'owner') {
    header("Location: ../auth/login.php");
    exit();
}

include("../includes/header.php");

if (isset($_POST['submit'])) {

    $owner_id   = $_SESSION['user_id'];
    $category   = $_POST['category'];
    $title      = $_POST['title'];
    $location   = $_POST['location'];
    $price      = $_POST['price'];
    $description= $_POST['description'];

    /* IMAGE UPLOAD */
    $image_name = $_FILES['image']['name'];
    $tmp_name   = $_FILES['image']['tmp_name'];

    $ext = pathinfo($image_name, PATHINFO_EXTENSION);
    $new_name = time() . "_" . rand(1000,9999) . "." . $ext;

    $upload_path = "../assets/uploads/listings/" . $new_name;
    move_uploaded_file($tmp_name, $upload_path);

    /* INSERT QUERY */
    $sql = "INSERT INTO rooms 
            (owner_id, category, title, location, price, description, image, status)
            VALUES 
            ('$owner_id','$category','$title','$location','$price','$description','$new_name','pending')";

    if (mysqli_query($conn, $sql)) {
        echo "<p style='color:green;'>Listing added successfully</p>";
    } else {
        echo "<p style='color:red;'>Error adding listing</p>";
    }
}
?>

<h2>Add New Listing</h2>

<form method="post" enctype="multipart/form-data">

    <label>Category</label>
    <select name="category" required>
        <option value="">Select</option>
        <option value="room">Room</option>
        <option value="office">Office</option>
        <option value="electronics">Electronics</option>
        <option value="vehicle">Vehicle</option>
    </select>

    <label>Title</label>
    <input type="text" name="title" required>

    <label>Location</label>
    <input type="text" name="location" required>

    <label>Price</label>
    <input type="number" name="price" required>

    <label>Description</label>
    <textarea name="description" required></textarea>

    <label>Listing Image</label>
    <input type="file" name="image" accept="image/*" required>

    <button type="submit" name="submit">Add Listing</button>
</form>

<?php include("../includes/footer.php"); ?>