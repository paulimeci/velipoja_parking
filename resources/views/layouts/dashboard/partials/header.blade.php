<header class="header-area bg-white mb-4 rounded-bottom-15" id="header-area">
    <div class="row align-items-center">
        <div class="col-lg-4 col-sm-6">
            <div class="left-header-content">
                <ul class="d-flex align-items-center ps-0 mb-0 list-unstyled justify-content-center justify-content-sm-start">
                    <li>
                        <button class="header-burger-menu bg-transparent p-0 border-0" id="header-burger-menu">
                            <span class="material-symbols-outlined">menu</span>
                        </button>
                    </li>
                    <li>
                        <form class="src-form position-relative">
                            <input type="text" class="form-control" placeholder="Search here.....">
                            <button type="submit" class="src-btn position-absolute top-50 end-0 translate-middle-y bg-transparent p-0 border-0">
                                <span class="material-symbols-outlined">search</span>
                            </button>
                        </form>
                    </li>
                    <li>
                        <!-- Apps Dropdown -->
                        <div class="dropdown notifications apps">
                            <button class="btn btn-secondary border-0 p-0 position-relative" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="material-symbols-outlined">apps</span>
                            </button>
                            <div class="dropdown-menu dropdown-lg p-0 border-0 py-4 px-3 max-h-312" data-simplebar>
                                <div class="notification-menu d-flex flex-wrap justify-content-between gap-4">
                                    <a href="https://www.figma.com/" target="_blank" class="dropdown-item p-0 text-center">
                                        <img src="{{ asset('assets/images/figma.svg') }}" class="wh-25" alt="figma">
                                        <span>Figma</span>
                                    </a>
                                    <a href="https://www.dribbble.com/" target="_blank" class="dropdown-item p-0 text-center">
                                        <img src="{{ asset('assets/images/dribbble.svg') }}" class="wh-25" alt="dribbble">
                                        <span>Dribbble</span>
                                    </a>
                                    <!-- Më shumë aplikacione -->
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <div class="col-lg-8 col-sm-6">
            <div class="right-header-content mt-2 mt-sm-0">
                <ul class="d-flex align-items-center justify-content-center justify-content-sm-end ps-0 mb-0 list-unstyled">
                    <!-- Dark/Light Mode -->
                    <li class="header-right-item">
                        <div class="light-dark">
                            <button class="switch-toggle settings-btn dark-btn p-0 bg-transparent border-0" id="switch-toggle">
                                <span class="dark"><i class="material-symbols-outlined">light_mode</i></span>
                                <span class="light"><i class="material-symbols-outlined">dark_mode</i></span>
                            </button>
                        </div>
                    </li>

                    <!-- Language Dropdown -->
                    <li class="header-right-item">
                        <div class="dropdown notifications language">
                            <button class="btn btn-secondary dropdown-toggle border-0 p-0 position-relative" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="material-symbols-outlined">translate</span>
                            </button>
                            <div class="dropdown-menu dropdown-lg p-0 border-0 dropdown-menu-end">
                                <!-- Language options -->
                            </div>
                        </div>
                    </li>

                    <!-- Fullscreen -->
                    <li class="header-right-item">
                        <button class="fullscreen-btn bg-transparent p-0 border-0" id="fullscreen-button">
                            <i class="material-symbols-outlined text-body">fullscreen</i>
                        </button>
                    </li>

                    <!-- Notifications -->
                    <li class="header-right-item">
                        <div class="dropdown notifications noti">
                            <button class="btn btn-secondary border-0 p-0 position-relative badge" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="material-symbols-outlined">notifications</span>
                            </button>
                            <div class="dropdown-menu dropdown-lg p-0 border-0 p-0 dropdown-menu-end">
                                <!-- Notifications content -->
                            </div>
                        </div>
                    </li>

                    <!-- User Profile -->
                    <li class="header-right-item">
                        <div class="dropdown admin-profile">
                            <div class="d-xxl-flex align-items-center bg-transparent border-0 text-start p-0 cursor dropdown-toggle" data-bs-toggle="dropdown">
                                <div class="flex-shrink-0">
                                    @if(Auth::user()->image)
                                        <img class="rounded-circle wh-40 administrator"
                                             src="{{ asset('storage/' . Auth::user()->image) }}"
                                             alt="{{ Auth::user()->name }}">
                                    @else
                                        @php
                                            $nameParts = explode(' ', trim(Auth::user()->name));
                                            $firstName = $nameParts[0] ?? '';
                                            $lastName = $nameParts[1] ?? '';
                                            $initials = strtoupper(substr($firstName, 0, 1) . substr($lastName, 0, 1));
                                        @endphp
                                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center administrator"
                                             style="width: 40px; height: 40px; font-weight: 500; font-size: 16px;">
                                            {{ $initials }}
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-grow-1 ms-2">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="d-none d-xxl-block">
                                            <div class="d-flex align-content-center">
                                                <h3 class="fs-14 mb-0">{{ explode(' ', Auth::user()->name)[0] }}</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="dropdown-menu border-0 bg-white dropdown-menu-end">
                                <div class="d-flex align-items-center info">
                                    <div class="flex-shrink-0">
                                        @if(Auth::user()->image)
                                            <img class="rounded-circle wh-30 administrator"
                                                 src="{{ asset('storage/' . Auth::user()->image) }}"
                                                 alt="{{ Auth::user()->name }}">
                                        @else
                                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center"
                                                 style="width: 30px; height: 30px; font-weight: 500; font-size: 14px;">
                                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-grow-1 ms-2">
                                        <h3 class="fw-medium fs-14 mb-0">{{ Auth::user()->name }}</h3>
                                        <span class="fs-12">Marketing Manager</span>
                                    </div>
                                </div>
                                <ul class="admin-link ps-0 mb-0 list-unstyled">
                                    <li>
                                        <a class="dropdown-item admin-item-link d-flex align-items-center text-body" href="#">
                                            <i class="material-symbols-outlined">account_circle</i>
                                            <span class="ms-2">My Profile</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item admin-item-link d-flex align-items-center text-body" href="#">
                                            <i class="material-symbols-outlined">chat</i>
                                            <span class="ms-2">Messages</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item admin-item-link d-flex align-items-center text-body" href="#">
                                            <i class="material-symbols-outlined">format_list_bulleted</i>
                                            <span class="ms-2">My Task</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item admin-item-link d-flex align-items-center text-body" href="#">
                                            <i class="material-symbols-outlined">credit_card</i>
                                            <span class="ms-2">Billing</span>
                                        </a>
                                    </li>
                                </ul>
                                <ul class="admin-link ps-0 mb-0 list-unstyled">
                                    <li>
                                        <a class="dropdown-item admin-item-link d-flex align-items-center text-body" href="#">
                                            <i class="material-symbols-outlined">settings</i>
                                            <span class="ms-2">Settings</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item admin-item-link d-flex align-items-center text-body" href="#">
                                            <i class="material-symbols-outlined">support</i>
                                            <span class="ms-2">Support</span>
                                        </a>
                                    </li>
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}" id="logout-form">
                                            @csrf
                                            <button type="submit" class="dropdown-item admin-item-link d-flex align-items-center text-body w-100 border-0 bg-transparent">
                                                <i class="material-symbols-outlined">logout</i>
                                                <span class="ms-2">Logout</span>
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>

                    <!-- Settings -->
                    <li class="header-right-item">
                        <button class="theme-settings-btn p-0 border-0 bg-transparent" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasScrolling">
                            <i class="material-symbols-outlined">settings</i>
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>
