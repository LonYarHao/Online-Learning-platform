// Modern Landing Page JavaScript
// Author: Claude
// Date: 2025

document.addEventListener("DOMContentLoaded", () => {
    console.log("🚀 Taxila Academy - Front page loaded successfully!");

    // ==================== NAVBAR SCROLL EFFECT ====================
    const navbar = document.querySelector(".navbar");
    const navLinks = document.querySelectorAll(".nav-link");

    window.addEventListener("scroll", () => {
        if (window.scrollY > 50) {
            navbar.classList.add("scrolled");
        } else {
            navbar.classList.remove("scrolled");
        }

        // Update active nav link based on scroll position
        updateActiveNavLink();
    });

    // ==================== SMOOTH SCROLL ====================
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener("click", function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute("href"));
            if (target) {
                const offsetTop = target.offsetTop - 80;
                window.scrollTo({
                    top: offsetTop,
                    behavior: "smooth"
                });

                // Close mobile menu if open
                const navCollapse = document.querySelector(".navbar-collapse");
                if (navCollapse.classList.contains("show")) {
                    const bsCollapse = new bootstrap.Collapse(navCollapse);
                    bsCollapse.hide();
                }
            }
        });
    });

    // ==================== UPDATE ACTIVE NAV LINK ====================
    function updateActiveNavLink() {
        const sections = document.querySelectorAll("section[id]");
        const scrollPosition = window.scrollY + 100;

        sections.forEach(section => {
            const sectionTop = section.offsetTop;
            const sectionHeight = section.offsetHeight;
            const sectionId = section.getAttribute("id");

            if (scrollPosition >= sectionTop && scrollPosition < sectionTop + sectionHeight) {
                navLinks.forEach(link => {
                    link.classList.remove("active");
                    if (link.getAttribute("href") === `#${sectionId}`) {
                        link.classList.add("active");
                    }
                });
            }
        });
    }

    // ==================== FADE-IN ANIMATION ====================
    const fadeElements = document.querySelectorAll(".fade-in");

    const fadeObserver = new IntersectionObserver(
        entries => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add("visible");
                }
            });
        },
        {
            threshold: 0.15,
            rootMargin: "0px 0px -50px 0px"
        }
    );

    fadeElements.forEach(el => fadeObserver.observe(el));

    // ==================== ANIMATED COUNTER ====================
    const statNumbers = document.querySelectorAll(".stat-number");
    let hasAnimated = false;

    const counterObserver = new IntersectionObserver(
        entries => {
            entries.forEach(entry => {
                if (entry.isIntersecting && !hasAnimated) {
                    hasAnimated = true;
                    statNumbers.forEach(stat => {
                        animateCounter(stat);
                    });
                }
            });
        },
        { threshold: 0.5 }
    );

    if (statNumbers.length > 0) {
        counterObserver.observe(statNumbers[0].parentElement);
    }

    function animateCounter(element) {
        const target = parseInt(element.getAttribute("data-target"));
        const duration = 2000; // 2 seconds
        const increment = target / (duration / 16); // 60fps
        let current = 0;

        const updateCounter = () => {
            current += increment;
            if (current < target) {
                element.textContent = Math.floor(current).toLocaleString();
                requestAnimationFrame(updateCounter);
            } else {
                element.textContent = target.toLocaleString();
                // Add "+" for certain stats
                if (target === 10000 || target === 50) {
                    element.textContent += "+";
                } else if (target === 98) {
                    element.textContent += "%";
                }
            }
        };

        updateCounter();
    }

    // ==================== PARALLAX EFFECT (HERO) ====================
    const heroSection = document.querySelector(".hero-section");
    const heroParticles = document.querySelector(".hero-particles");

    window.addEventListener("scroll", () => {
        if (heroSection) {
            const scrolled = window.pageYOffset;
            const rate = scrolled * 0.5;

            if (heroParticles) {
                heroParticles.style.transform = `translateY(${rate}px)`;
            }
        }
    });

    // ==================== COURSE CARD TILT EFFECT ====================
    const courseCards = document.querySelectorAll(".course-card");

    courseCards.forEach(card => {
        card.addEventListener("mousemove", (e) => {
            const rect = card.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;

            const centerX = rect.width / 2;
            const centerY = rect.height / 2;

            const rotateX = (y - centerY) / 20;
            const rotateY = (centerX - x) / 20;

            card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) translateY(-10px)`;
        });

        card.addEventListener("mouseleave", () => {
            card.style.transform = "perspective(1000px) rotateX(0) rotateY(0) translateY(0)";
        });
    });

    // ==================== BUTTON RIPPLE EFFECT ====================
    const buttons = document.querySelectorAll(".btn");

    buttons.forEach(button => {
        button.addEventListener("click", function(e) {
            const ripple = document.createElement("span");
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;

            ripple.style.width = ripple.style.height = size + "px";
            ripple.style.left = x + "px";
            ripple.style.top = y + "px";
            ripple.classList.add("ripple");

            this.appendChild(ripple);

            setTimeout(() => {
                ripple.remove();
            }, 600);
        });
    });

    // Add ripple CSS dynamically
    const style = document.createElement("style");
    style.textContent = `
        .btn {
            position: relative;
            overflow: hidden;
        }
        .ripple {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.6);
            transform: scale(0);
            animation: ripple-animation 0.6s ease-out;
            pointer-events: none;
        }
        @keyframes ripple-animation {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }
    `;
    document.head.appendChild(style);

    // ==================== LAZY LOAD IMAGES ====================
    const images = document.querySelectorAll("img[data-src]");

    const imageObserver = new IntersectionObserver(
        entries => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.removeAttribute("data-src");
                    imageObserver.unobserve(img);
                }
            });
        },
        { rootMargin: "50px" }
    );

    images.forEach(img => imageObserver.observe(img));

    // ==================== TESTIMONIAL ROTATION ====================
    // Optional: Auto-rotate testimonials (you can remove if not needed)
    const testimonialCards = document.querySelectorAll(".testimonial-card");
    let currentTestimonial = 0;

    function rotateTestimonials() {
        if (window.innerWidth < 768) { // Only on mobile
            testimonialCards.forEach((card, index) => {
                if (index === currentTestimonial) {
                    card.style.display = "block";
                } else {
                    card.style.display = "none";
                }
            });

            currentTestimonial = (currentTestimonial + 1) % testimonialCards.length;
        } else {
            testimonialCards.forEach(card => {
                card.style.display = "block";
            });
        }
    }

    // Run on load and resize
    rotateTestimonials();
    window.addEventListener("resize", rotateTestimonials);

    // ==================== FORM VALIDATION (if you add forms later) ====================
    const forms = document.querySelectorAll(".needs-validation");

    forms.forEach(form => {
        form.addEventListener("submit", event => {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add("was-validated");
        }, false);
    });

    // ==================== SCROLL TO TOP BUTTON ====================
    // Create scroll to top button
    const scrollToTopBtn = document.createElement("button");
    scrollToTopBtn.innerHTML = '<i class="bi bi-arrow-up"></i>';
    scrollToTopBtn.className = "scroll-to-top";
    scrollToTopBtn.setAttribute("aria-label", "Scroll to top");
    document.body.appendChild(scrollToTopBtn);

    // Add styles for scroll to top button
    const scrollBtnStyle = document.createElement("style");
    scrollBtnStyle.textContent = `
        .scroll-to-top {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: white;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            z-index: 1000;
            box-shadow: 0 10px 30px rgba(99, 102, 241, 0.3);
        }
        .scroll-to-top.visible {
            opacity: 1;
            visibility: visible;
        }
        .scroll-to-top:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(99, 102, 241, 0.4);
        }
    `;
    document.head.appendChild(scrollBtnStyle);

    // Show/hide scroll to top button
    window.addEventListener("scroll", () => {
        if (window.scrollY > 300) {
            scrollToTopBtn.classList.add("visible");
        } else {
            scrollToTopBtn.classList.remove("visible");
        }
    });

    // Scroll to top functionality
    scrollToTopBtn.addEventListener("click", () => {
        window.scrollTo({
            top: 0,
            behavior: "smooth"
        });
    });

    // ==================== PERFORMANCE OPTIMIZATION ====================
    // Debounce function for scroll events
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    // Apply debounce to scroll-heavy functions
    const debouncedScroll = debounce(() => {
        updateActiveNavLink();
    }, 100);

    window.addEventListener("scroll", debouncedScroll);

    // ==================== ACCESSIBILITY ====================
    // Add keyboard navigation support
    document.addEventListener("keydown", (e) => {
        if (e.key === "Escape") {
            const navCollapse = document.querySelector(".navbar-collapse");
            if (navCollapse.classList.contains("show")) {
                const bsCollapse = new bootstrap.Collapse(navCollapse);
                bsCollapse.hide();
            }
        }
    });

    // ==================== EASTER EGG ====================
    // Fun little easter egg - konami code
    let konamiCode = [];
    const konamiPattern = ["ArrowUp", "ArrowUp", "ArrowDown", "ArrowDown", "ArrowLeft", "ArrowRight", "ArrowLeft", "ArrowRight", "b", "a"];

    document.addEventListener("keydown", (e) => {
        konamiCode.push(e.key);
        if (konamiCode.length > konamiPattern.length) {
            konamiCode.shift();
        }
        if (JSON.stringify(konamiCode) === JSON.stringify(konamiPattern)) {
            document.body.style.animation = "rainbow 2s ease infinite";
            const rainbowStyle = document.createElement("style");
            rainbowStyle.textContent = `
                @keyframes rainbow {
                    0% { filter: hue-rotate(0deg); }
                    100% { filter: hue-rotate(360deg); }
                }
            `;
            document.head.appendChild(rainbowStyle);
            setTimeout(() => {
                document.body.style.animation = "";
            }, 5000);
        }
    });

    console.log("✨ All features loaded! Happy learning! 🎓");
});


