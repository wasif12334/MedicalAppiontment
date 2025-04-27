<?php
session_start();
include "../includes/connection.php";

if (!isset($_SESSION['doctor_id'])) {
    header('Location: auth.html');
    exit();
}

$doctor_id = $_SESSION['doctor_id'];
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password !== $confirm_password) {
        $message = '<span style="color:#e57373">New passwords do not match.</span>';
    } else {
        $stmt = $con->prepare("SELECT password FROM doctors WHERE doctor_id = ?");
        $stmt->bind_param("i", $doctor_id);
        $stmt->execute();
        $stmt->bind_result($current_hash);
        $stmt->fetch();
        $stmt->close();

        if (!password_verify($old_password, $current_hash)) {
            $message = '<span style="color:#e57373">Old password is incorrect.</span>';
        } else {
            $new_hash = password_hash($new_password, PASSWORD_DEFAULT);
            $update = $con->prepare("UPDATE doctors SET password = ? WHERE doctor_id = ?");
            $update->bind_param("si", $new_hash, $doctor_id);
            if ($update->execute()) {
                $message = '<span style="color:#81c784">Password changed successfully!</span>';
            } else {
                $message = '<span style="color:#e57373">Failed to update password.</span>';
            }
            $update->close();
        }
    }
}
$con->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Change Password - Doctor Portal</title>
    <link rel="stylesheet" href="../assets/styling/doctor.css">
    <style>
        body { background: #232b2b; color: #e0f2f1; font-family: 'Segoe UI', Arial, sans-serif; }
        .change-container { max-width: 400px; margin: 5.5rem auto 0 auto; background: #263238; border-radius: 14px; box-shadow: 0 4px 24px rgba(44,95,45,0.13); padding: 2.5rem 2rem; }
        h2 { color: #a5d6a7; text-align: center; margin-bottom: 2rem; }
        form { display: flex; flex-direction: column; gap: 1.2rem; }
        label { color: #b2dfdb; font-weight: 500; margin-bottom: 0.3rem; }
        input[type='password'] { padding: 0.8rem 1rem; border-radius: 6px; border: 1px solid #b2dfdb; background: #37474f; color: #e0f2f1; font-size: 1rem; }
        .btn { background: #388e3c; color: #fff; border: none; border-radius: 6px; padding: 0.9rem; font-size: 1.1rem; font-weight: 600; cursor: pointer; margin-top: 1rem; transition: background 0.2s; }
        .btn:hover { background: #256024; }
        .msg { text-align: center; margin-bottom: 1rem; font-size: 1.05rem; }
        .back-link { display: block; text-align: center; margin-top: 1.5rem; color: #a5d6a7; text-decoration: underline; }
        .back-link:hover { color: #81c784; }
    </style>
</head>
<body>
    <div class="change-container">
        <h2>Change Password</h2>
        <?php if ($message) echo '<div class="msg">' . $message . '</div>'; ?>
        <form method="post" action="">
            <label for="old_password">Old Password</label>
            <input type="password" id="old_password" name="old_password" required>
            <label for="new_password">New Password</label>
            <input type="password" id="new_password" name="new_password" required>
            <label for="confirm_password">Confirm New Password</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
            <button type="submit" class="btn">Change Password</button>
        </form>
        <a href="dashboard.php" class="back-link">&larr; Back to Dashboard</a>
    </div>
</body>
</html> 