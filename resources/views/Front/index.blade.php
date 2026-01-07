<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Taxila Academy - Modern Online Learning</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/front.css') }}">
</head>

<body>

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">
                <span class="brand-gradient">Taxila</span> Academy
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navMenu">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li><a class="nav-link px-3 active" href="#home">Home</a></li>
                    <li><a class="nav-link px-3" href="#about">About</a></li>
                    <li><a class="nav-link px-3" href="#departments">Courses</a></li>
                    <li><a class="nav-link px-3" href="#testimonials">Reviews</a></li>
                    <li><a class="nav-link px-3" href="#contact">Contact</a></li>
                </ul>
                <div class="d-flex gap-2">
                    <a href="/login" class="btn btn-outline-primary rounded-pill px-4">Login</a>
                    <a href="/register" class="btn btn-primary rounded-pill px-4">Get Started</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- HERO SECTION -->
    <section class="hero-section d-flex align-items-center" id="home">
        <div class="hero-particles"></div>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 text-lg-start text-center mb-5 mb-lg-0">
                    <div class="badge-pill mb-3">
                        <i class="bi bi-star-fill text-warning"></i> Trusted by 10,000+ Students
                    </div>
                    <h1 class="hero-title mb-4">
                        Empower Your Future with
                        <span class="text-gradient">World-Class</span> Education
                    </h1>
                    <p class="hero-subtitle mb-4">
                        Learn anywhere, anytime with flexible online courses designed by industry experts.
                        Start your journey today and unlock endless opportunities.
                    </p>
                    <div class="d-flex gap-3 justify-content-lg-start justify-content-center flex-wrap">
                        <a href="#departments" class="btn btn-hero btn-lg rounded-pill px-5">
                            <i class="bi bi-rocket-takeoff me-2"></i>Explore Courses
                        </a>
                        <a href="#about" class="btn btn-outline-hero btn-lg rounded-pill px-5">
                            <i class="bi bi-play-circle me-2"></i>Watch Demo
                        </a>
                    </div>
                    <div class="hero-stats mt-5 d-flex gap-4 justify-content-lg-start justify-content-center">
                        <div>
                            <h3 class="stat-number mb-0" data-target="10000">0</h3>
                            <p class="stat-label mb-0">Students</p>
                        </div>
                        <div class="stat-divider"></div>
                        <div>
                            <h3 class="stat-number mb-0" data-target="50">0</h3>
                            <p class="stat-label mb-0">Courses</p>
                        </div>
                        <div class="stat-divider"></div>
                        <div>
                            <h3 class="stat-number mb-0" data-target="98">0</h3>
                            <p class="stat-label mb-0">Success Rate</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="hero-image-wrapper">
                        <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=800"
                            alt="Students learning" class="img-fluid rounded-4 hero-image">
                        <div class="floating-card card-1">
                            <i class="bi bi-trophy-fill text-warning fs-4"></i>
                            <div class="ms-3">
                                <p class="mb-0 fw-bold">Top Rated</p>
                                <small class="text-muted">Industry Leaders</small>
                            </div>
                        </div>
                        <div class="floating-card card-2">
                            <i class="bi bi-people-fill text-primary fs-4"></i>
                            <div class="ms-3">
                                <p class="mb-0 fw-bold">500+ Online</p>
                                <small class="text-muted">Active Learners</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ABOUT SECTION -->
    <section class="about-section py-5" id="about">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <div class="about-image-grid">
                        <img src="https://images.unsplash.com/photo-1497633762265-9d179a990aa6?w=400" alt="Learning"
                            class="img-fluid rounded-4 shadow-lg">
                    </div>
                </div>
                <div class="col-lg-6">
                    <h2 class="section-title mb-4 fade-in">
                        Why Choose <span class="text-gradient">Taxila Academy?</span>
                    </h2>
                    <p class="text-muted mb-4 fade-in">
                        We're committed to providing high-quality education that's accessible, affordable,
                        and designed to help you succeed in today's competitive world.
                    </p>
                    <div class="feature-list">
                        <div class="feature-item fade-in">
                            <div class="feature-icon">
                                <i class="bi bi-check-circle-fill"></i>
                            </div>
                            <div>
                                <h5 class="mb-1">Expert Instructors</h5>
                                <p class="text-muted mb-0">Learn from industry professionals with years of experience
                                </p>
                            </div>
                        </div>
                        <div class="feature-item fade-in">
                            <div class="feature-icon">
                                <i class="bi bi-check-circle-fill"></i>
                            </div>
                            <div>
                                <h5 class="mb-1">Flexible Learning</h5>
                                <p class="text-muted mb-0">Study at your own pace, whenever and wherever you want</p>
                            </div>
                        </div>
                        <div class="feature-item fade-in">
                            <div class="feature-icon">
                                <i class="bi bi-check-circle-fill"></i>
                            </div>
                            <div>
                                <h5 class="mb-1">Certification</h5>
                                <p class="text-muted mb-0">Get recognized certificates upon course completion</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- COURSES / DEPARTMENTS -->
    <section class="departments-section py-5" id="departments">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title fade-in">Explore Our <span class="text-gradient">Departments</span></h2>
                <p class="text-muted fade-in">Choose from our diverse range of courses across multiple disciplines</p>
            </div>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6 fade-in">
                    <div class="course-card h-100">
                        <div class="course-card-header">
                            <div class="course-icon gradient-1">
                                <i class="bi bi-code-slash"></i>
                            </div>
                            <span class="course-badge">Popular</span>
                        </div>
                        <h4 class="course-title">Web Development</h4>
                        <p class="course-department">IT Department</p>
                        <p class="course-text">Master modern web technologies including HTML, CSS, JavaScript, React,
                            and backend development.</p>
                        <ul class="course-features">
                            <li><i class="bi bi-check2"></i> 12 Courses Available</li>
                            <li><i class="bi bi-check2"></i> Beginner to Advanced</li>
                            <li><i class="bi bi-check2"></i> Job Ready Skills</li>
                        </ul>
                        <a href="#" class="btn btn-course w-100 mt-3">View Courses <i
                                class="bi bi-arrow-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 fade-in">
                    <div class="course-card h-100">
                        <div class="course-card-header">
                            <div class="course-icon gradient-2">
                                <i class="bi bi-graph-up"></i>
                            </div>
                            <span class="course-badge badge-new">New</span>
                        </div>
                        <h4 class="course-title">Business & Finance</h4>
                        <p class="course-department">Economy Department</p>
                        <p class="course-text">Learn strategic thinking, financial analysis, management, and
                            entrepreneurship from industry leaders.</p>
                        <ul class="course-features">
                            <li><i class="bi bi-check2"></i> 8 Courses Available</li>
                            <li><i class="bi bi-check2"></i> Real-World Cases</li>
                            <li><i class="bi bi-check2"></i> Career Guidance</li>
                        </ul>
                        <a href="#" class="btn btn-course w-100 mt-3">View Courses <i
                                class="bi bi-arrow-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 fade-in">
                    <div class="course-card h-100">
                        <div class="course-card-header">
                            <div class="course-icon gradient-3">
                                <i class="bi bi-palette"></i>
                            </div>
                        </div>
                        <h4 class="course-title">Design & Creativity</h4>
                        <p class="course-department">Art Department</p>
                        <p class="course-text">Unlock your creative potential with UI/UX design, graphic design, and
                            digital illustration courses.</p>
                        <ul class="course-features">
                            <li><i class="bi bi-check2"></i> 10 Courses Available</li>
                            <li><i class="bi bi-check2"></i> Portfolio Projects</li>
                            <li><i class="bi bi-check2"></i> Industry Tools</li>
                        </ul>
                        <a href="#" class="btn btn-course w-100 mt-3">View Courses <i
                                class="bi bi-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- TESTIMONIALS -->
    <section class="testimonials-section py-5" id="testimonials">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title fade-in">What Our <span class="text-gradient">Students Say</span></h2>
                <p class="text-muted fade-in">Real success stories from our amazing community</p>
            </div>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6 fade-in">
                    <div class="testimonial-card">
                        <div class="stars mb-3">
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                        </div>
                        <p class="testimonial-text">"The web development course transformed my career. I went from
                            complete beginner to landing my dream job in just 6 months!"</p>
                        <div class="testimonial-author">
                            <div class="author-avatar">S</div>
                            <div>
                                <p class="author-name mb-0">Sarah Johnson</p>
                                <small class="text-muted">Full Stack Developer</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 fade-in">
                    <div class="testimonial-card">
                        <div class="stars mb-3">
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                        </div>
                        <p class="testimonial-text">"Excellent instructors and well-structured content. The business
                            courses gave me the confidence to start my own company."</p>
                        <div class="testimonial-author">
                            <div class="author-avatar">M</div>
                            <div>
                                <p class="author-name mb-0">Michael Chen</p>
                                <small class="text-muted">Entrepreneur</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 fade-in">
                    <div class="testimonial-card">
                        <div class="stars mb-3">
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                        </div>
                        <p class="testimonial-text">"As a designer, these courses helped me stay updated with the
                            latest trends and tools. Highly recommend!"</p>
                        <div class="testimonial-author">
                            <div class="author-avatar">E</div>
                            <div>
                                <p class="author-name mb-0">Emma Williams</p>
                                <small class="text-muted">UI/UX Designer</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA SECTION -->
    <section class="cta-section py-5">
        <div class="container">
            <div class="cta-card text-center">
                <h2 class="mb-4">Ready to Start Learning?</h2>
                <p class="mb-4">Join thousands of students already learning on Taxila Academy</p>
                <a href="/register" class="btn btn-light btn-lg rounded-pill px-5">
                    Get Started for Free <i class="bi bi-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="footer" id="contact">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <h5 class="fw-bold mb-3"><span class="brand-gradient">Taxila</span> Academy</h5>
                    <p class="text-muted">Empowering learners worldwide with quality online education.</p>
                    <div class="social-links mt-3">
                        <a href="#"><i class="bi bi-facebook"></i></a>
                        <a href="#"><i class="bi bi-twitter"></i></a>
                        <a href="#"><i class="bi bi-instagram"></i></a>
                        <a href="#"><i class="bi bi-linkedin"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6">
                    <h6 class="fw-bold mb-3">Quick Links</h6>
                    <ul class="footer-links">
                        <li><a href="#home">Home</a></li>
                        <li><a href="#about">About Us</a></li>
                        <li><a href="#departments">Courses</a></li>
                        <li><a href="#contact">Contact</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h6 class="fw-bold mb-3">Departments</h6>
                    <ul class="footer-links">
                        <li><a href="#">Web Development</a></li>
                        <li><a href="#">Business</a></li>
                        <li><a href="#">Design</a></li>
                        <li><a href="#">All Courses</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h6 class="fw-bold mb-3">Contact Us</h6>
                    <ul class="footer-contact">
                        <li><i class="bi bi-envelope me-2"></i>info@taxilaacademy.com</li>
                        <li><i class="bi bi-phone me-2"></i>+1 (555) 123-4567</li>
                        <li><i class="bi bi-geo-alt me-2"></i>123 Education St, Learning City</li>
                    </ul>
                </div>
            </div>
            <hr class="my-4 border-secondary">
            <div class="text-center">
                <p class="mb-0 text-muted">&copy; 2025 Taxila Academy. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="{{ asset('js/front.js') }}"></script>
</body>

</html>
