<?php
require_once 'auth.php';
require_login();
include '../includes/connection.php';

// Delete appointment
if (isset($_GET['delete'])) {
    $Appointment_id = intval($_GET['delete']);
    $con->query('DELETE FROM appointment WHERE Appointment_id=' . $Appointment_id);
    header('Location: appointments.php');
    exit();
}
// Join with patient and doctors to get names
$apps = $con->query('
    SELECT a.Appointment_id, a.Appointment_Date, a.Appointment_Time, a.Symptoms, a.Treatment_history, 
           p.name AS patient_name, d.full_name AS doctor_name
    FROM appointment a
    LEFT JOIN patient p ON a.Patient_id = p.Patient_id
    LEFT JOIN doctors d ON a.Doctor_id = d.doctor_id
    ORDER BY a.Appointment_id DESC
');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Appointments</title>
    <link rel="stylesheet" href="../assets/styling/admin.css">
</head>
<body>
    <div class="navbar">Alfazal Homeo Clinic Admin Panel</div>
    <div class="box">
        <a href="dashboard.php" class="back">&larr; Back to Dashboard</a>
        <h2>Manage Appointments</h2>
        <table>
            <tr><th>ID</th><th>Patient</th><th>Doctor</th><th>Date</th><th>Time</th><th>Symptoms</th><th>Treatment History</th><th>Action</th></tr>
            <?php while($app = $apps->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($app['Appointment_id']) ?></td>
                <td><?= htmlspecialchars($app['patient_name'] ?? '-') ?></td>
                <td><?= htmlspecialchars($app['doctor_name'] ?? '-') ?></td>
                <td><?= htmlspecialchars($app['Appointment_Date']) ?></td>
                <td><?= htmlspecialchars($app['Appointment_Time']) ?></td>
                <td><?= htmlspecialchars($app['Symptoms']) ?></td>
                <td><?= htmlspecialchars($app['Treatment_history']) ?></td>
                <td><a href="?delete=<?= $app['Appointment_id'] ?>" class="del-btn" onclick="return confirm('Delete this appointment?')">Delete</a></td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html> 