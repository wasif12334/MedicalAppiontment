<?php
//for error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "../includes/connection.php";

if (isset($_POST['submit'])) {
    // Patient Table Data
    $name = $_POST['name'];
    $DOB = $_POST['dob'];
    $gender = $_POST['gender'];
    $phone_no = $_POST['phone'];
    $email = $_POST['email'];

    // Appointment Table Data
    $Appointment_Date = $_POST['appointment_date'];
    $Appointment_Time = $_POST['appointment_time'];
    $symptoms = $_POST['symptoms'];
    $treatmentHistory = $_POST['previousTreatment'];
    $doctor_id = $_POST['doctor_id'];

    // First Step: Insert into patient table
    $stmt = $con->prepare("INSERT INTO patient (name, DOB, gender, phone_no, email) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssis", $name, $DOB, $gender, $phone_no, $email);

    if ($stmt->execute()) {
        $patient_id = $con->insert_id; 

        $stmt2 = $con->prepare("INSERT INTO appointment (Appointment_Date, Appointment_Time, Symptoms, Treatment_history, Patient_id, doctor_id) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt2->bind_param("ssssii", $Appointment_Date, $Appointment_Time, $symptoms, $treatmentHistory, $patient_id, $doctor_id);

        if ($stmt2->execute()) {
            echo "<script>alert('Appointment successfully booked');</script>";
        } else {
            echo "<script>alert('Failed to book appointment');</script>";
        }
        $stmt2->close();
    } else {
        echo "<script>alert('Failed to save patient data');</script>";
    }
    $stmt->close();
    $con->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Appointment - Alfazal Homeopathic Clinic</title>
    <link rel="stylesheet" href="../assets/styling/patient.css">
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="main-nav">
        <div class="nav-container">
            <div class="logo">
                <a href="../index.php">Alfazal Homeopathic Clinic</a>
            </div>
            <ul class="nav-links">
                <li><a href="../index.php">Home</a></li>
                <li><a href="../index.php#about">About</a></li>
                <li><a href="../index.php#services">Services</a></li>
                <li><a href="../index.php#doctors">Doctors</a></li>
                <li><a href="../index.php#contact">Contact</a></li>
            </ul>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1>Book Your Appointment</h1>
            <p>Experience personalized homeopathic care with our expert practitioners</p>
            <div class="hero-stats">
                <div class="stat-item">
                    <span class="stat-number">15+</span>
                    <span class="stat-label">Years of Experience</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">5000+</span>
                    <span class="stat-label">Happy Patients</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">98%</span>
                    <span class="stat-label">Success Rate</span>
                </div>
            </div>
        </div>
        <div class="hero-image">
            <div class="image-overlay"></div>
        </div>
    </section>

    <div class="booking-container">
        <div class="form-header">
            <h1>Book Your Appointment</h1>
            <p>Please fill in the details below to schedule your consultation</p>
        </div>

        <form class="booking-form" method="post" action="booking.php">
            <div class="form-group">
                <label for="fullName">Full Name</label>
                <input type="text" id="fullName" name="name" required placeholder="Enter your full name">
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="age">Date Of Birth</label>
                    <input type="date" id="age" name="dob" required min="0" max="150" placeholder="Your age">
                </div>
                <div class="form-group">
                    <label for="gender">Gender</label>
                    <select id="gender" name="gender" required>
                        <option value="">Select gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="tel" id="phone" name="phone" required placeholder="Your contact number">
            </div>

            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" required placeholder="Your email address">
            </div>

            <?php
            $doctors = $con->query("SELECT doctor_id, full_name, specialization FROM doctors");
            ?>
            <div class="form-group">
                <label for="doctor_id">Select Doctor</label>
                <select id="doctor_id" name="doctor_id" required>
                    <option value="">Select Doctor</option>
                    <?php while($doc = $doctors->fetch_assoc()): ?>
                        <option value="<?= $doc['doctor_id'] ?>">
                            Dr. <?= htmlspecialchars($doc['full_name']) ?> (<?= htmlspecialchars($doc['specialization']) ?>)
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="preferredDate">Appointment Date</label>
                <input type="date" id="appointment_date" name="appointment_date" required>
            </div>

            <div class="form-group">
                <label for="preferredTime">Appointment Time</label>
                <select id="preferredTime" name="appointment_time" required>
                    <option value="">Select preferred time</option>
                    <option value="morning">Morning (9:00 AM - 12:00 PM)</option>
                    <option value="afternoon">Afternoon (2:00 PM - 5:00 PM)</option>
                    <option value="evening">Evening (6:00 PM - 9:00 PM)</option>
                </select>
            </div>

            <div class="form-group">
                <label for="symptoms">Primary Symptoms</label>
                <textarea id="symptoms" name="symptoms" required placeholder="Please describe your main symptoms or health concerns"></textarea>
            </div>

            <div class="form-group">
                <label for="previousTreatment">Previous Treatments (if any)</label>
                <textarea id="previousTreatment" name="previousTreatment" placeholder="Any previous treatments or medications"></textarea>
            </div>

            <div class="form-actions">
                <button type="submit" class="submit-btn" value="submit" name="submit">Book Appointment</button>
                <button type="reset" class="reset-btn">Clear Form</button>
            </div>
        </form>

        <div class="form-footer">
            <p>Need help? Contact us at <a href="tel:+1234567890">123-456-7890</a></p>
            <a href="../index.php" class="back-link">← Back to Home</a>
        </div>
    </div>

    <!-- Footer -->
    <footer class="main-footer">
        <div class="footer-container">
            <div class="footer-section">
                <h3>Alfazal Homeopathic Clinic</h3>
                <p>Your trusted partner in natural healing and wellness</p>
            </div>
            <div class="footer-section">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="../index.php">Home</a></li>
                    <li><a href="../index.php#about">About Us</a></li>
                    <li><a href="../index.php#services">Services</a></li>
                    <li><a href="../index.php#doctors">Our Doctors</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h4>Contact Us</h4>
                <p>123 Clinic Street</p>
                <p>City, State 12345</p>
                <p>Phone: 123-456-7890</p>
                <p>Email: info@alfazalclinic.com</p>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2024 Alfazal Homeopathic Clinic. All rights reserved.</p>
        </div>
    </footer>
</body>
</html> 