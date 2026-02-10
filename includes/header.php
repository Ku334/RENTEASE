<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>RENTEASE</title>
    <link rel="stylesheet" href="/RENTEASE/assets/css/style.css">
</head>
<body>

<header>

    <!-- LEFT NAV : ROLE BASED -->
    <div class="nav-left">

        <?php if (!isset($_SESSION['user_id'])) { ?>
            <!-- GUEST -->
            <a href="/RENTEASE/index.php">Home</a>
            <a href="/RENTEASE/browse.php?category=room">Rooms</a>
            <a href="/RENTEASE/browse.php?category=office">Office</a>
            <a href="/RENTEASE/browse.php?category=electronics">Electronics</a>
            <a href="/RENTEASE/browse.php?category=vehicle">Vehicles</a>
            <a href="/RENTEASE/about.php">About</a>

        <?php } elseif ($_SESSION['role'] === 'tenant') { ?>
            <!-- TENANT -->
            <a href="/RENTEASE/tenant/dashboard.php">Home</a>
            <a href="/RENTEASE/browse.php?category=room">Rooms</a>
            <a href="/RENTEASE/browse.php?category=office">Office</a>
            <a href="/RENTEASE/browse.php?category=electronics">Electronics</a>
            <a href="/RENTEASE/browse.php?category=vehicle">Vehicles</a>
            <a href="/RENTEASE/about.php">About</a>

        <?php } elseif ($_SESSION['role'] === 'owner') { ?>
            <!-- OWNER -->
            <a href="/RENTEASE/owner/dashboard.php">Dashboard</a>
            <a href="/RENTEASE/owner/add_listing.php">Add Listing</a>
            <a href="/RENTEASE/owner/my_listings.php">My Listings</a>
            <a href="/RENTEASE/owner/booking_requests.php">Booking Requests</a>
            <a href="/RENTEASE/about.php">About</a>

        <?php } elseif ($_SESSION['role'] === 'admin') { ?>
            <!-- ADMIN -->
            <a href="/RENTEASE/admin/dashboard.php">Dashboard</a>
            <a href="/RENTEASE/admin/manage_users.php">Manage Users</a>
            <a href="/RENTEASE/admin/approve_listings.php">Approvals</a>
            <a href="/RENTEASE/admin/reports.php">Reports</a>
        <?php } ?>

    </div>

    <!-- RIGHT NAV : ROLE BASED -->
    <div class="nav-right">

        <?php if (!isset($_SESSION['user_id'])) { ?>
            <!-- GUEST -->
            <a href="/RENTEASE/auth/login.php">Login</a>
            <a href="/RENTEASE/auth/register_choice.php">Register</a>

        <?php } elseif ($_SESSION['role'] === 'tenant') { ?>
            <!-- TENANT -->
            <a href="/RENTEASE/tenant/booking_history.php">My Bookings</a>
            <a href="/RENTEASE/tenant/profile.php">Profile</a>
            <a href="/RENTEASE/auth/logout.php">Logout</a>

        <?php } elseif ($_SESSION['role'] === 'owner') { ?>
            <!-- OWNER -->
            <a href="/RENTEASE/owner/profile.php">Profile</a>
            <a href="/RENTEASE/auth/logout.php">Logout</a>

        <?php } elseif ($_SESSION['role'] === 'admin') { ?>
            <!-- ADMIN -->
            <a href="/RENTEASE/auth/logout.php">Logout</a>
        <?php } ?>

    </div>

</header>

<div class="container">