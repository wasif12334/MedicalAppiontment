<?php
require_once '../includes/connection.php';

if (isset($_POST['submit'])) {

    $name = $_POST['fullName'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $phone_number = $_POST['phone'];
    $email = $_POST['email'];
    $preferredDate = $_POST['preferredDate'];
    $preferredTime = $_POST['preferredTime'];
    $symptoms = $_POST['symptoms'];
    $previousTreatment = $_POST['previousTreatment'];

    // ✅ CORRECT table name: appointment (not appionment)
    $sql = "INSERT INTO appointment (full_name, age, gender, phone_number, email, preferred_date, preferred_time, symptoms, previous_treatment)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $con->prepare($sql);
    if (!$stmt) {
        die("Prepare failed: (" . $con->errno . ") " . $con->error);
    }

    $stmt->bind_param(
        "sisssssss",
        $name, 
        $age, 
        $gender, 
        $phone_number, 
        $email,
        $preferredDate,
        $preferredTime,
        $symptoms,
        $previousTreatment
    );

    if ($stmt->execute()) {
        echo "<script>alert('Data successfully inserted into the database');</script>";
    } else {
        echo "<script>alert('Execute Error: " . $stmt->error . "');</script>";
    }

    $stmt->close();
}
?>
