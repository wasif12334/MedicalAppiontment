<?php
require_once 'auth.php';
require_login();
include '../includes/connection.php';

// Add patient
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_patient'])) {
    $name = trim($_POST['full_name'] ?? '');
    $phone = trim($_POST['contact'] ?? '');
    if ($name && $phone) {
        $stmt = $con->prepare('INSERT INTO patient (name, phone_no) VALUES (?, ?)');
        $stmt->bind_param('ss', $name, $phone);
        $stmt->execute();
        $stmt->close();
    }
    header('Location: patients.php');
    exit();
}
// Delete patient
if (isset($_GET['delete'])) {
    $Patient_id = intval($_GET['delete']);
    $con->query('DELETE FROM patient WHERE Patient_id=' . $Patient_id);
    header('Location: patients.php');
    exit();
}
$patients = $con->query('SELECT Patient_id, name, phone_no FROM patient ORDER BY Patient_id DESC');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Patients</title>
    <link rel="stylesheet" href="../assets/styling/admin.css">
</head>
<body>
    <div class="navbar">Alfazal Homeo Clinic Admin Panel</div>
    <div class="box">
        <a href="dashboard.php" class="back">&larr; Back to Dashboard</a>
        <h2>Manage Patients</h2>
        <form method="post">
            <input type="text" name="full_name" placeholder="Full Name" required>
            <input type="text" name="contact" placeholder="Phone Number" required>
            <button type="submit" name="add_patient">Add Patient</button>
        </form>
        <table>
            <tr><th>ID</th><th>Name</th><th>Phone</th><th>Action</th></tr>
            <?php while($pat = $patients->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($pat['Patient_id']) ?></td>
                <td><?= htmlspecialchars($pat['name']) ?></td>
                <td><?= htmlspecialchars($pat['phone_no']) ?></td>
                <td><a href="?delete=<?= $pat['Patient_id'] ?>" class="del-btn" onclick="return confirm('Delete this patient?')">Delete</a></td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html> 