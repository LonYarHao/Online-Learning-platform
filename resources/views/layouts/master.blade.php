<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Taxila Academy</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('CSS/Admin/style.css') }}">

    {{-- cdn js  --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body>

    <!-- SIDEBAR -->
    <aside class="sidebar" id="mySidebar">
        <div class="sidebar-header">
            <h3 class="sidebar-brand">
                <span class="brand-gradient">Taxila</span> Admin
            </h3>
            <button class="closebtn" onclick="closeNav()">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>

        <nav class="sidebar-nav">
            <ul class="nav-list">
                <li class="nav-item">
                    <a href="{{ route('admin#dashboard') }}" class="nav-link active">
                        <i class="bi bi-speedometer2"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin#departmentList') }}" class="nav-link">
                        <i class="bi bi-building"></i>
                        <span>Departments</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin#courseList') }}" class="nav-link">
                        <i class="bi bi-book"></i>
                        <span>Courses</span>
                    </a>
                </li>

                <li class="nav-section">
                    <span class="section-title">User Management</span>
                </li>
                @if (Auth::user()->role == 'superadmin')
                    <li class="nav-item">
                        <a href="{{ route('account#adminList') }}" class="nav-link">
                            <i class="bi bi-shield-check"></i>
                            <span>Admin List</span>
                        </a>
                    </li>
                @endif
                <li class="nav-item">
                    <a href="{{ route('account#teacherList') }}" class="nav-link">
                        <i class="bi bi-person-video3"></i>
                        <span>Teacher List</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('account#studentList') }}" class="nav-link">
                        <i class="bi bi-people"></i>
                        <span>Student List</span>
                    </a>
                </li>

                <li class="nav-section">
                    <span class="section-title">Other</span>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin#paymentPage') }}" class="nav-link">
                        <i class="bi bi-credit-card"></i>
                        <span>Payments</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin#Noti') }}" class="nav-link d-flex align-items-center">
                        <div class="position-relative me-2">
                            <i class="bi bi-bell fs-5"></i>

                            @if ($pendingCount > 0)
                                <span
                                    class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger border border-light"
                                    style="font-size: 0.6rem; padding: 0.25em 0.45em;">
                                    {{ $pendingCount }}
                                </span>
                            @endif
                        </div>
                        <span>Notification</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin#reportList') }}" class="nav-link">
                        <i class="bi bi-flag"></i>
                        <span>Reports</span>
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
                <h4 class="page-title">Dashboard</h4>
            </div>

            <div class="navbar-right">
                <div class="dropdown">
                    <button class="btn border-0 p-0 dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <img src="{{ Auth::user()->profile != null ? asset('profile/' . Auth::user()->profile) : asset('defaultPic/defProfile.jpg') }}"
                            alt="Profile" class="user-avatar" />
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li class="dropdown-header">
                            <img src="{{ Auth::user()->profile != null ? asset('profile/' . Auth::user()->profile) : asset('defaultPic/defProfile.jpg') }}"
                                alt="Profile" class="dropdown-avatar" />
                            <div>
                                <p class="dropdown-name">
                                    {{ Auth::user()->name ? Auth::user()->name : Auth::user()->user_name }}</p>
                                <p class="dropdown-email">{{ Auth::user()->email }}</p>
                            </div>
                        </li>
                        <li>
                            <hr class="dropdown-divider" />
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('admin#ProfileDetail') }}">
                                <i class="bi bi-person"></i>
                                <span>My Profile</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('admin#changePasswordPage') }}">
                                <i class="fa-solid fa-key"></i>
                                <span>change password</span>
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
            </div>
        </header>

        @yield('content')

        @include('sweetalert::alert')


    </div>

    <!-- Bootstrap JS (Required for dropdown) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    {{-- sweer alert js  --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @yield('js-script')
</body>

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

</html>
