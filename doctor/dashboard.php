<?php
session_start();
include "../includes/connection.php";

if (!isset($_SESSION['doctor_id'])) {
    header('Location: auth.html');
    exit();
}

$doctor_id = $_SESSION['doctor_id'];

// Fetch doctor info
$stmt = $con->prepare("SELECT full_name, specialization FROM doctors WHERE doctor_id = ?");
$stmt->bind_param("i", $doctor_id);
$stmt->execute();
$stmt->bind_result($full_name, $specialization);
$stmt->fetch();
$stmt->close();

// Fetch appointments for this doctor, including patient name
$appointments = [];
$appt_stmt = $con->prepare("SELECT a.appointment_id, a.appointment_date, a.appointment_time, a.patient_id, p.name AS patient_name, a.symptoms, a.treatment_history FROM appointment a JOIN patient p ON a.patient_id = p.patient_id WHERE a.doctor_id = ?");
$appt_stmt->bind_param("i", $doctor_id);
$appt_stmt->execute();
$appt_result = $appt_stmt->get_result();
while ($row = $appt_result->fetch_assoc()) {
    $appointments[] = $row;
}
$appt_stmt->close();
$con->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Alfazal Homeopathic Clinic - Doctor Portal</title>
    <link rel="stylesheet" href="../assets/styling/doctor.css">
    <style>
        body {
            background: linear-gradient(135deg, #232b2b 0%, #263238 100%);
            color: #e0f2f1;
            font-family: 'Segoe UI', Arial, sans-serif;
            min-height: 100vh;
            margin: 0;
        }
        .header {
            background: #204529;
            color: #e0f2f1;
            padding: 1.5rem 2rem 1rem 2rem;
            border-radius: 0 0 18px 18px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 4px 24px rgba(44,95,45,0.10);
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
        }
        .header .branding {
            font-size: 1.7rem;
            font-weight: 700;
            letter-spacing: 1px;
            color: #a5d6a7;
        }
        .header .tagline {
            font-size: 1.1rem;
            color: #b2dfdb;
            margin-left: 1.5rem;
        }
        .header .menu {
            display: flex;
            gap: 1.2rem;
        }
        .header .menu a {
            color: #e0f2f1;
            text-decoration: none;
            font-weight: 500;
            background: #388e3c;
            padding: 0.5rem 1.2rem;
            border-radius: 6px;
            transition: background 0.2s;
        }
        .header .menu a:hover {
            background: #256024;
        }
        .dashboard-outer {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 5.5rem 0 3rem 0;
        }
        .dashboard-container {
            width: 100%;
            max-width: 900px;
            background: #263238;
            border-radius: 18px;
            box-shadow: 0 4px 24px rgba(44,95,45,0.13);
            padding: 2.5rem 2rem 2.5rem 2rem;
            margin-top: 2.5rem;
        }
        .card {
            background: #232b2b;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(44,95,45,0.10);
            padding: 2rem 1.5rem;
            margin-bottom: 2.2rem;
        }
        h1 {
            color: #a5d6a7;
            font-size: 2.2rem;
            margin-bottom: 0.5rem;
            font-weight: 700;
        }
        .info {
            margin-bottom: 0.5rem;
            font-size: 1.15rem;
        }
        .info strong {
            color: #81c784;
        }
        h2 {
            color: #b2dfdb;
            margin-bottom: 1.2rem;
            font-size: 1.5rem;
            font-weight: 600;
        }
        .appt-table-container {
            background: #232b2b;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(44,95,45,0.10);
            padding: 1.5rem 1rem;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 0.5rem;
            background: #37474f;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(44,95,45,0.06);
        }
        th, td {
            border: none;
            padding: 1rem 0.7rem;
            text-align: left;
        }
        th {
            background: #204529;
            color: #a5d6a7;
            font-size: 1.08rem;
            font-weight: 600;
        }
        tr:nth-child(even) {
            background: #263238;
        }
        tr:hover {
            background: #2e7d32;
        }
        td {
            font-size: 1.01rem;
            color: #e0f2f1;
        }
        @media (max-width: 700px) {
            .dashboard-container { padding: 1.2rem 0.2rem; }
            .card, .appt-table-container { padding: 1rem 0.3rem; }
            th, td { padding: 0.6rem 0.3rem; font-size: 0.98rem; }
            h1 { font-size: 1.3rem; }
            h2 { font-size: 1.1rem; }
        }
    </style>
</head>
<body>
    <div class="header">
        <div>
            <span class="branding">Alfazal Homeopathic Clinic</span>
            <span class="tagline">Doctor Portal</span>
        </div>
        <div class="menu">
            <a href="change_password.php">Change Password</a>
            <a href="logout.php">Logout</a>
        </div>
    </div>
    <div class="dashboard-outer">
        <div class="dashboard-container">
            <div class="card">
                <h1>Welcome, Dr. <?php echo htmlspecialchars($full_name); ?></h1>
                <div class="info">
                    <strong>Specialization:</strong> <?php echo strtoupper(htmlspecialchars($specialization)); ?>
                </div>
            </div>
            <div class="appt-table-container">
                <h2>Your Appointments</h2>
                <table>
                    <tr>
                        <th>ID</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Patient Name</th>
                        <th>Symptoms</th>
                        <th>Treatment History</th>
                    </tr>
                    <?php if (count($appointments) === 0): ?>
                        <tr><td colspan="6">No appointments found.</td></tr>
                    <?php else: foreach ($appointments as $appt): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($appt['appointment_id']); ?></td>
                            <td><?php echo htmlspecialchars($appt['appointment_date']); ?></td>
                            <td><?php echo htmlspecialchars($appt['appointment_time']); ?></td>
                            <td><?php echo htmlspecialchars($appt['patient_name']); ?></td>
                            <td><?php echo htmlspecialchars($appt['symptoms']); ?></td>
                            <td><?php echo htmlspecialchars($appt['treatment_history']); ?></td>
                        </tr>
                    <?php endforeach; endif; ?>
                </table>
            </div>
        </div>
    </div>
</body>
</html> 