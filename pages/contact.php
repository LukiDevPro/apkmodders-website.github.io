<?php require_once '../header.php'; ?>
    <main class="main-content">
        <div class="contact-container">
            <div class="contact-header">
                <h2>Get In Touch</h2>
                <p>Have questions or feedback? We'd love to hear from you! Fill out the form below or use our contact information to reach out to us.</p>
            </div>

            <div class="contact-content">
                <div class="contact-info">
                    <div class="info-item">
                        <div class="info-icon">
                            <i>📍</i>
                        </div>
                        <div class="info-text">
                            <h3>Our Location</h3>
                            <p>123 Mod Street, Cyber City</p>
                            <p>Berlin, Germany</p>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-icon">
                            <i>📧</i>
                        </div>
                        <div class="info-text">
                            <h3>Email Us</h3>
                            <p><a href="mailto:contact@apkmodders.com">contact@apkmodders.com</a></p>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-icon">
                            <i>📱</i>
                        </div>
                        <div class="info-text">
                            <h3>Call Us</h3>
                            <p><a href="tel:+491234567890">+49 123 456 7890</a></p>
                        </div>
                    </div>

                    <div class="social-links">
                        <a href="#" class="social-link" aria-label="Telegram">
                            <i>📱</i>
                        </a>
                        <a href="#" class="social-link" aria-label="Discord">
                            <i>💬</i>
                        </a>
                        <a href="#" class="social-link" aria-label="Twitter">
                            <i>🐦</i>
                        </a>
                        <a href="#" class="social-link" aria-label="GitHub">
                            <i>💻</i>
                        </a>
                    </div>
                </div>

                <form class="contact-form" id="contactForm">
                    <div class="form-group">
                        <label for="name">Your Name</label>
                        <input type="text" id="name" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="subject">Subject</label>
                        <input type="text" id="subject" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="message">Your Message</label>
                        <textarea id="message" class="form-control" required></textarea>
                    </div>

                    <button type="submit" class="submit-btn">Send Message</button>
                </form>
            </div>
        </div>
    </main>

    <footer>
        <p>&copy; 2025 APK Modders. All rights reserved.</p>
    </footer>

    <script>
        // Form submission handling
        document.getElementById('contactForm').addEventListener('submit', function(e) {
            e.preventDefault();

            // Get form values
            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const subject = document.getElementById('subject').value;
            const message = document.getElementById('message').value;

            // Here you would typically send this data to a server
            console.log('Form submitted:', { name, email, subject, message });

            // Show success message
            alert('Thank you for your message! We will get back to you soon.');

            // Reset form
            this.reset();
        });
    </script>
</body>
</html>
