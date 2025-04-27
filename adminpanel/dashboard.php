<?php
require_once 'auth.php';
require_login();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="/assets/styling/admin.css">
</head>
<body>
    <div class="navbar">Alfazal Homeo Clinic Admin Panel</div>
    <div class="dash-box">
        <h2>Admin Dashboard</h2>
        <ul>
            <li><a href="doctors.php">Manage Doctors</a></li>
            <li><a href="patients.php">Manage Patients</a></li>
            <li><a href="appointments.php">Manage Appointments</a></li>
        </ul>
        <a href="logout.php" class="logout-link">Logout</a>
    </div>
</body>
</html> 