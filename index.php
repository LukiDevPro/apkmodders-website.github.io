<?php
require_once 'header.php';
?>

    <!-- Main Content -->
    <main class="main-content">
        <section class="hero" id="home">
            <h2>Welcome to APK Modders</h2>
            <p>Your ultimate destination for modified APKs and game hacks</p>
            <a href="#downloads" class="cta-button">Get Started</a>
        </section>

        <section id="features">
            <h2 style="text-align: center; margin-bottom: 2rem;">Our Features</h2>
            <div class="features">
                <div class="feature-card">
                    <h3>Premium Unlocked</h3>
                    <p>Access premium features for free with our modified APKs.</p>
                </div>
                <div class="feature-card">
                    <h3>Ad-Free Experience</h3>
                    <p>Enjoy your favorite apps without annoying advertisements.</p>
                </div>
                <div class="feature-card">
                    <h3>Regular Updates</h3>
                    <p>We keep our mods updated with the latest versions.</p>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer>
        <p>&copy; 2025 APK Modders. All rights reserved.</p>
    </footer>

    <!-- JavaScript -->
    <script>
        // Language translations
        const translations = {
            en: {
                welcome: "Welcome to APK Modders",
                tagline: "Your ultimate destination for modified APKs and game hacks",
                getStarted: "Get Started",
                features: "Our Features",
                premium: "Premium Unlocked",
                premiumDesc: "Access premium features for free with our modified APKs.",
                adfree: "Ad-Free Experience",
                adfreeDesc: "Enjoy your favorite apps without annoying advertisements.",
                updates: "Regular Updates",
                updatesDesc: "We keep our mods updated with the latest versions.",
                navHome: "Home",
                navFeatures: "Features",
                navDownloads: "Downloads",
                navTutorials: "Tutorials",
                navContact: "Contact"
            },
            de: {
                welcome: "Willkommen bei APK Modders",
                tagline: "Ihr ultimativer Ort für modifizierte APKs und Game-Hacks",
                getStarted: "Loslegen",
                features: "Unsere Funktionen",
                premium: "Premium freigeschaltet",
                premiumDesc: "Greifen Sie mit unseren modifizierten APKs kostenlos auf Premium-Funktionen zu.",
                adfree: "Werbefreies Erlebnis",
                adfreeDesc: "Genießen Sie Ihre Lieblings-Apps ohne störende Werbung.",
                updates: "Regelmäßige Updates",
                updatesDesc: "Wir halten unsere Mods mit den neuesten Versionen aktuell.",
                navHome: "Startseite",
                navFeatures: "Funktionen",
                navDownloads: "Downloads",
                navTutorials: "Anleitungen",
                navContact: "Kontakt"
            },
            ru: {
                welcome: "Добро пожаловать в APK Modders",
                tagline: "Ваш лучший источник модифицированных APK и игровых читов",
                getStarted: "Начать",
                features: "Наши возможности",
                premium: "Премиум разблокирован",
                premiumDesc: "Доступ к премиум-функциям бесплатно с нашими модифицированными APK.",
                adfree: "Без рекламы",
                adfreeDesc: "Наслаждайтесь любимыми приложениями без назойливой рекламы.",
                updates: "Регулярные обновления",
                updatesDesc: "Мы регулярно обновляем наши моды до последних версий.",
                navHome: "Главная",
                navFeatures: "Функции",
                navDownloads: "Загрузки",
                navTutorials: "Гайды",
                navContact: "Контакты"
            }
        };

        // Set default language
        let currentLang = localStorage.getItem('language') || 'en';

        // Function to update content based on language
        function updateContent() {
            const lang = translations[currentLang];
            
            // Update navigation
            document.querySelector('a[href="index.php"]').textContent = lang.navHome;
            document.querySelector('a[href="#features"]').textContent = lang.navFeatures;
            document.querySelector('a[href="pages/downloads.html"]').textContent = lang.navDownloads;
            document.querySelector('a[href="pages/tutorials.html"]').textContent = lang.navTutorials;
            document.querySelector('a[href="pages/contact.html"]').textContent = lang.navContact;
            
            // Update hero section
            const hero = document.querySelector('.hero');
            if (hero) {
                hero.querySelector('h2').textContent = lang.welcome;
                hero.querySelector('p').textContent = lang.tagline;
                hero.querySelector('.cta-button').textContent = lang.getStarted;
            }
            
            // Update features section
            const featuresSection = document.querySelector('#features');
            if (featuresSection) {
                featuresSection.querySelector('h2').textContent = lang.features;
                
                const featureCards = document.querySelectorAll('.feature-card');
                if (featureCards.length >= 3) {
                    featureCards[0].querySelector('h3').textContent = lang.premium;
                    featureCards[0].querySelector('p').textContent = lang.premiumDesc;
                    
                    featureCards[1].querySelector('h3').textContent = lang.adfree;
                    featureCards[1].querySelector('p').textContent = lang.adfreeDesc;
                    
                    featureCards[2].querySelector('h3').textContent = lang.updates;
                    featureCards[2].querySelector('p').textContent = lang.updatesDesc;
                }
            }
        }

        // Initialize language buttons
        function initLanguageSwitcher() {
            const langButtons = document.querySelectorAll('.lang-btn');
            
            // Set active button
            langButtons.forEach(btn => {
                if (btn.dataset.lang === currentLang) {
                    btn.classList.add('active');
                }
                
                // Add click event
                btn.addEventListener('click', () => {
                    currentLang = btn.dataset.lang;
                    localStorage.setItem('language', currentLang);
                    
                    // Update active button
                    langButtons.forEach(b => b.classList.remove('active'));
                    btn.classList.add('active');
                    
                    // Update content
                    updateContent();
                });
            });
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', () => {
            // Parallax effect for moon
            document.addEventListener('mousemove', (e) => {
                const moon = document.querySelector('.moon');
                const x = (window.innerWidth / 2 - e.pageX) / 50;
                const y = (window.innerHeight / 2 - e.pageY) / 50;
                moon.style.transform = `translate(calc(-50% + ${x}px), calc(-50% + ${y}px))`;
            });

            // Smooth scrolling for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth'
                        });
                    }
                });
            });

            // Initialize animations
            const observerOptions = {
                threshold: 0.1
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = 1;
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, observerOptions);

            // Observe all feature cards
            document.querySelectorAll('.feature-card').forEach((card, index) => {
                card.style.opacity = 0;
                card.style.transform = 'translateY(20px)';
                card.style.transition = `opacity 0.5s ease ${index * 0.2}s, transform 0.5s ease ${index * 0.2}s`;
                observer.observe(card);
            });

            // Initialize language switcher
            initLanguageSwitcher();
            updateContent();
        });
    </script>
</body>
</html>
