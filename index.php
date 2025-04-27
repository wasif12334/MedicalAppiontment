<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alfazal Homeopathic Clinic</title>
    <link rel="stylesheet" href="assets/styling/style.css">
</head>
<body>
    <header>
        <h1>Alfazal Homeopathic Clinic</h1>
        <nav>
            <ul>
                <li><a href="#home">Home</a></li>
                <li><a href="#about">About Us</a></li>
                <li><a href="#services">Services</a></li>
                <li><a href="#doctors" target="_blank">Our Doctors</a></li>
                <li><a href="/patient/booking.php">Book Appiontment</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section id="home">
            <h2>Welcome to Alfazal Homeopathic Clinic</h2>
            <p>Shifa from Allah, Care from Us</p>
        </section>

        <section id="about">
            <h2>About Us</h2>
            <p>Alfazal Homeopathic Clinic is dedicated to providing natural and holistic healthcare solutions. Our experienced practitioners combine traditional homeopathic wisdom with modern medical knowledge to offer personalized treatment plans.</p>
        </section>

        <section id="services">
            <h2>Our Services</h2>
            <ul>
                <li>Homeopathic Consultation</li>
                <li>Chronic Disease Management</li>
                <li>Pediatric Care</li>
                <li>Women's Health</li>
                <li>Mental Health Support</li>
                <li>Preventive Healthcare</li>
            </ul>
        </section>

        <section id="doctors">
            <h2 style="text-align:center; color:#29b6f6; margin-bottom:0.5rem;">Our Doctors</h2>
            <div style="text-align:center; color:#333; margin-bottom:1.2rem; font-size:1.08rem;">Meet our expert team of homeopathic doctors</div>
            <style>
                .doctors-list-basic {
                    display: flex;
                    flex-wrap: wrap;
                    gap: 1.2rem;
                    justify-content: center;
                }
                .doctor-basic-item {
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    min-width: 100px;
                    max-width: 140px;
                }
                .doctor-basic-img {
                    width: 60px;
                    height: 60px;
                    border-radius: 50%;
                    object-fit: cover;
                    margin-bottom: 0.4rem;
                }
                .doctor-basic-name {
                    font-size: 1rem;
                    font-weight: 600;
                    margin-bottom: 0.1rem;
                    text-align: center;
                }
                .doctor-basic-spec {
                    font-size: 0.93rem;
                    text-align: center;
                }
                @media (max-width: 700px) {
                    .doctors-list-basic { flex-direction: column; align-items: center; }
                }
            </style>
            <div class="doctors-list-basic">
            <?php
            include "includes/connection.php";
            $doctors = $con->query("SELECT full_name, specialization FROM doctors");
            $dummy_imgs = [
                'https://randomuser.me/api/portraits/women/44.jpg',
                'https://randomuser.me/api/portraits/men/32.jpg',
                'https://randomuser.me/api/portraits/women/68.jpg',
                'https://randomuser.me/api/portraits/men/65.jpg',
                'https://randomuser.me/api/portraits/women/12.jpg',
                'https://randomuser.me/api/portraits/men/23.jpg',
            ];
            $i = 0;
            while($doc = $doctors->fetch_assoc()):
                $img = $dummy_imgs[$i % count($dummy_imgs)];
                $i++;
            ?>
                <div class="doctor-basic-item">
                    <img src="<?= $img ?>" alt="Doctor" class="doctor-basic-img">
                    <div class="doctor-basic-name">Dr. <?= htmlspecialchars($doc['full_name']) ?></div>
                    <div class="doctor-basic-spec">Specialization: <?= htmlspecialchars($doc['specialization']) ?></div>
                </div>
            <?php endwhile; ?>
            </div>
        </section>

        <section id="contact">
            <h2>Contact Us</h2>
            <address>
                <p>Address:Taxila,Pakistan</p>
                <p>Phone: +923225230855</p>
                <p>Email: alfzalhomeo@gmail.com</p>
            </address>
            <form>
                <div>
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name">
                </div>
                <div>
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email">
                </div>
                <div>
                    <label for="message">Message:</label>
                    <textarea id="message" name="message"></textarea>
                </div>
                <button type="submit">Send Message</button>
            </form>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 Alfazal Homeopathic Clinic. All rights reserved.</p>
    </footer>
</body>
</html>
