<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "../includes/connection.php";

if (isset($_POST['signup'])) {
    echo "Signup button pressed<br>";

    $full_name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $specialization = $_POST['specialization'];
    $phone_number = $_POST['phone_number'];
   
    // Check email
    $check_email = $con->prepare("SELECT * FROM doctors WHERE email = ?");
    $check_email->bind_param("s", $email);
    $check_email->execute();
    $result = $check_email->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('Email already exists');</script>";
    } else {
        $sql = "INSERT INTO doctors (full_name, email, password, specialization, phone_number) VALUES (?, ?, ?, ?, ?)";
        $stmt = $con->prepare($sql);

        if (!$stmt) {
            die("Prepare failed: (" . $con->errno . ") " . $con->error);
        }

        $stmt->bind_param("sssss", $full_name, $email, $password, $specialization, $phone_number);

        if ($stmt->execute()) {
            echo "<script>alert('Data successfully inserted into the database');</script>";
        } else {
            echo "<script>alert('Registration failed');</script>";
        }

        $stmt->close();
    }

    $con->close();
}
?>
