<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alfazal Homeopathic Clinic</title>
    <link rel="stylesheet" href="assets/styling/style.css">
   
       
</head>
<body>
    <nav class="main-nav">
        <div class="nav-container">
            <div class="hamburger">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <div class="logo">
                <a href="#home">Alfazal Homeopathic Clinic</a>
            </div>
            <ul class="nav-links">
                <li><a href="#home">Home</a></li>
                <li><a href="#about">About Us</a></li>
                <li><a href="#services">Services</a></li>
                <li><a href="#doctors" target="_blank">Our Doctors</a></li>
                <li><a href="patient/booking.php">Book Appointment</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>
        </div>
    </nav>
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
            <div class="services-redisgn-grid">
                <div class="service-redisgn-card">
                    <div class="service-redisgn-bar"></div>
                    <div class="service-redisgn-title">Homeopathic Consultation</div>
                    <div class="service-redisgn-desc">Personalized consultations for holistic healing and wellness.</div>
                </div>
                <div class="service-redisgn-card">
                    <div class="service-redisgn-bar"></div>
                    <div class="service-redisgn-title">Chronic Disease Management</div>
                    <div class="service-redisgn-desc">Long-term care and support for chronic health conditions.</div>
                </div>
                <div class="service-redisgn-card">
                    <div class="service-redisgn-bar"></div>
                    <div class="service-redisgn-title">Pediatric Care</div>
                    <div class="service-redisgn-desc">Gentle and effective treatments for children and infants.</div>
                </div>
                <div class="service-redisgn-card">
                    <div class="service-redisgn-bar"></div>
                    <div class="service-redisgn-title">Women's Health</div>
                    <div class="service-redisgn-desc">Specialized care for women's unique health needs.</div>
                </div>
                <div class="service-redisgn-card">
                    <div class="service-redisgn-bar"></div>
                    <div class="service-redisgn-title">Mental Health Support</div>
                    <div class="service-redisgn-desc">Compassionate support for mental and emotional well-being.</div>
                </div>
                <div class="service-redisgn-card">
                    <div class="service-redisgn-bar"></div>
                    <div class="service-redisgn-title">Preventive Healthcare</div>
                    <div class="service-redisgn-desc">Proactive strategies to maintain and improve your health.</div>
                </div>
            </div>
        </section>
        <section id="doctors">
            <h2 class="doctors-title">Our Doctors</h2>
            <div class="doctors-subtitle">Meet our expert team of homeopathic doctors</div>
            <div class="doctors-redisgn-grid">
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
                <div class="doctor-redisgn-card">
                    <div class="doctor-redisgn-bar"></div>
                    <img src="<?= $img ?>" alt="Doctor" class="doctor-redisgn-img">
                    <div class="doctor-redisgn-name">Dr. <?= htmlspecialchars($doc['full_name']) ?></div>
                    <div class="doctor-redisgn-spec">Specialization: <?= htmlspecialchars($doc['specialization']) ?></div>
                </div>
            <?php endwhile; ?>
            </div>
        </section>
        <section id="contact">
            <h2>Contact Us</h2>
            <div class="contact-flex">
                <div class="contact-info">
                    <address>
                        <p>Address: Taxila, Pakistan</p>
                        <p>Phone: +923225230855</p>
                        <p>Email: alfzalhomeo@gmail.com</p>
                    </address>
                    <div class="contact-form">
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
                    
                </div>
                
                </div>
            </div>
        </section>
    </main>
    <footer class="main-footer">
        <div class="footer-container">
            <div class="footer-section">
                <h3>Alfazal Homeopathic Clinic</h3>
                <p>Your trusted partner in natural healing and wellness</p>
            </div>
            <div class="footer-section">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="#home">Home</a></li>
                    <li><a href="#about">About Us</a></li>
                    <li><a href="#services">Services</a></li>
                    <li><a href="#doctors">Our Doctors</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h4>Contact Us</h4>
                <p>Taxila, Pakistan</p>
                <p>Phone: +923225230855</p>
                <p>Email: alfzalhomeo@gmail.com</p>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2024 Alfazal Homeopathic Clinic. All rights reserved.</p>
        </div>
    </footer>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const hamburger = document.querySelector('.hamburger');
            const navLinks = document.querySelector('.nav-links');
            hamburger.addEventListener('click', function() {
                hamburger.classList.toggle('active');
                navLinks.classList.toggle('active');
            });
            document.addEventListener('click', function(event) {
                if (!hamburger.contains(event.target) && !navLinks.contains(event.target)) {
                    hamburger.classList.remove('active');
                    navLinks.classList.remove('active');
                }
            });
            const navItems = document.querySelectorAll('.nav-links a');
            navItems.forEach(item => {
                item.addEventListener('click', function() {
                    hamburger.classList.remove('active');
                    navLinks.classList.remove('active');
                });
            });
        });
    </script>
</body>
</html>
