<?php
require_once 'auth.php';
require_login();
include '../includes/connection.php';

// Add doctor
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_doctor'])) {
    $name = trim($_POST['full_name'] ?? '');
    $spec = trim($_POST['specialization'] ?? '');
    if ($name && $spec) {
        $stmt = $con->prepare('INSERT INTO doctors (full_name, specialization) VALUES (?, ?)');
        $stmt->bind_param('ss', $name, $spec);
        $stmt->execute();
        $stmt->close();
    }
    header('Location: doctors.php');
    exit();
}
// Delete doctor
if (isset($_GET['delete'])) {
    $doctor_id = intval($_GET['delete']);
    if ($doctor_id > 0) {
        $stmt = $con->prepare('DELETE FROM doctors WHERE doctor_id = ?');
        $stmt->bind_param('i', $doctor_id);
        if ($stmt->execute()) {
            header('Location: doctors.php?success=1');
        } else {
            header('Location: doctors.php?error=1');
        }
        $stmt->close();
        exit();
    }
}
$doctors = $con->query('SELECT doctor_id, full_name, specialization FROM doctors ORDER BY doctor_id DESC');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Doctors</title>
    <link rel="stylesheet" href="../assets/styling/admin.css">
</head>
<body>
    <div class="navbar">Alfazal Homeo Clinic Admin Panel</div>
    <div class="box">
        <a href="dashboard.php" class="back">&larr; Back to Dashboard</a>
        <h2>Manage Doctors</h2>
        <form method="post">
            <input type="text" name="full_name" placeholder="Full Name" required>
            <input type="text" name="specialization" placeholder="Specialization" required>
            <button type="submit" name="add_doctor">Add Doctor</button>
        </form>
        <table>
            <tr><th>ID</th><th>Name</th><th>Specialization</th><th>Action</th></tr>
            <?php while($doc = $doctors->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($doc['doctor_id']) ?></td>
                <td><?= htmlspecialchars($doc['full_name']) ?></td>
                <td><?= htmlspecialchars($doc['specialization']) ?></td>
                <td><a href="?delete=<?= $doc['doctor_id'] ?>" class="del-btn" onclick="return confirm('Delete this doctor?')">Delete</a></td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html> 