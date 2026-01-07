<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard - Taxila Academy</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- CSS link -->
    <link rel="stylesheet" href="{{ asset('CSS/Student/style.css') }}">

    {{-- cdn js  --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>

<body>

    <!-- SIDEBAR -->
    <aside class="sidebar" id="mySidebar">
        <div class="sidebar-header">
            <h3 class="sidebar-brand">
                <span class="brand-gradient">Taxila</span> Academy
            </h3>
            <button class="closebtn" onclick="closeNav()">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>

        <nav class="sidebar-nav">
            <ul class="nav-list">
                <li class="nav-item">
                    <a href="" class="nav-link active">
                        <i class="bi bi-house-door"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('student#myCourse') }}" class="nav-link">
                        <i class="bi bi-book"></i>
                        <span>My Courses</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('student#browselist') }}" class="nav-link">
                        <i class="bi bi-file-earmark-text"></i>
                        <span>Browse Courses</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('student#myAssignment') }}" class="nav-link">
                        <i class="bi bi-people"></i>
                        <span>Assignments</span>
                    </a>
                </li>
                @php
                    // 1. Check if student is enrolled (Simple database check)
                    $isEnrolled = \App\Models\Enrollment::where('student_id', Auth::user()->id)->exists();

                    // 2. Count unread notifications
                    $unreadCount = \App\Models\Notification::where('receiver_id', Auth::user()->id)
                        ->where('is_read', 0)
                        ->count();
                @endphp

                @if ($isEnrolled)
                    <li class="nav-item">
                        <a href="{{ route('student#Noti') }}"
                            class="nav-link d-flex justify-content-between align-items-center">
                            <span>
                                <i class="fa-solid fa-bell me-2"></i> Notification
                            </span>

                            @if ($unreadCount > 0)
                                <span class="badge rounded-pill bg-danger" style="font-size: 0.6rem;">New</span>
                            @endif
                        </a>
                    </li>
                @endif
                <li class="nav-item">
                    <a href="{{ route('student#myGrade') }}" class="nav-link">
                        <i class="bi bi-bar-chart"></i>
                        <span>My Grades</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('student#viewReport') }}" class="nav-link">
                        <i class="bi bi-flag"></i>
                        <span>Reports</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('student#paymentHistory') }}" class="nav-link">
                        <i class="bi bi-calendar-check"></i>
                        <span>Payments</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('student#ProfileDetail') }}" class="nav-link">
                        <i class="bi bi-person"></i>
                        <span>Profile</span>
                    </a>
                </li>
            </ul>
        </nav>

        <div class="sidebar-footer">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="btn-logout">
                    <i class="bi bi-box-arrow-left"></i>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <div class="main-content" id="main">
        <!-- TOP NAVBAR -->
        <header class="top-navbar">
            <div class="d-flex align-items-center gap-3">
                <button class="menu-toggle" onclick="openNav()">
                    <i class="bi bi-list"></i>
                </button>
                <h4 class="page-title">Student Dashboard</h4>
            </div>

            <div class="dropdown">
                <button class="btn border-0 p-0 dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    @if (Auth::user()->provider == 'simple')
                        @if (Auth::user()->profile)
                            <img class="rounded-circle border border-2 shadow-sm"
                                style="width: 55px; height: 55px; object-fit: cover;" alt="profile"
                                src="{{ asset('profile/' . Auth::user()->profile) }}" alt="profile">
                        @else
                            <img class="rounded-circle border border-2 shadow-sm"
                                style="width: 55px; height: 55px; object-fit: cover;" alt="profile"
                                src="{{ asset('defaultPic/defProfile.jpg') }}" alt="default">
                        @endif
                    @else
                        @if (Auth::user()->profile)
                            <img class="rounded-circle border border-2 shadow-sm"
                                style="width: 55px; height: 55px; object-fit: cover;" alt="profile"
                                src="{{ Auth::user()->profile }}" alt="profile">
                        @else
                            <img class="rounded-circle border border-2 shadow-sm"
                                style="width: 55px; height: 55px; object-fit: cover;" alt="profile"
                                src="{{ asset('default/profilePic.jpg') }}" alt="default">
                        @endif
                    @endif
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li class="dropdown-header">
                        @if (Auth::user()->provider == 'simple')
                            @if (Auth::user()->profile)
                                <img class="rounded-circle border border-2 shadow-sm"
                                    style="width: 55px; height: 55px; object-fit: cover;" alt="profile"
                                    src="{{ asset('profile/' . Auth::user()->profile) }}" alt="profile">
                            @else
                                <img class="rounded-circle border border-2 shadow-sm"
                                    style="width: 55px; height: 55px; object-fit: cover;" alt="profile"
                                    src="{{ asset('defaultPic/defProfile.jpg') }}" alt="default">
                            @endif
                        @else
                            @if (Auth::user()->profile)
                                <img class="rounded-circle border border-2 shadow-sm"
                                    style="width: 55px; height: 55px; object-fit: cover;" alt="profile"
                                    src="{{ Auth::user()->profile }}" alt="profile">
                            @else
                                <img class="rounded-circle border border-2 shadow-sm"
                                    style="width: 55px; height: 55px; object-fit: cover;" alt="profile"
                                    src="{{ asset('default/profilePic.jpg') }}" alt="default">
                            @endif
                        @endif
                        <div>
                            <p class="dropdown-name">
                                {{ Auth::user()->name != null ? Auth::user()->name : Auth::user()->user_name }}</p>
                            <p class="dropdown-email">{{ Auth::user()->email }}</p>
                        </div>
                    </li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('student#ProfileDetail') }}">
                            <i class="bi bi-person"></i>
                            <span>My Profile</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('student#changePasswordPage') }}">
                            <i class="fa-solid fa-key"></i>
                            <span>Change Password</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="#">
                            <i class="bi bi-gear"></i>
                            <span>Settings</span>
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button class="btn-logout">
                                <i class="bi bi-box-arrow-left"></i>
                                <span>Logout</span>
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </header>

        @yield('content')

        @include('sweetalert::alert')

        @yield('js-script')
    </div>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function openNav() {
            document.body.classList.add("sidebar-open");
        }

        function closeNav() {
            document.body.classList.remove("sidebar-open");
        }

        function loadFile(event) {
            var reader = new FileReader();

            reader.onload = function() {
                var output = document.getElementById("output");
                output.src = reader.result;

            }

            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
</body>

</html>
