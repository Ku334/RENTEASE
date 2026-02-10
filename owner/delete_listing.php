<?php
include("../includes/auth_check.php");
include("../config/db.php");

if ($_SESSION['role'] !== 'owner') {
    header("Location: ../auth/login.php");
    exit();
}

$id = $_GET['id'];
$owner_id = $_SESSION['user_id'];

mysqli_query(
    $conn,
    "DELETE FROM rooms WHERE id='$id' AND owner_id='$owner_id'"
);

header("Location: my_listings.php");
exit();