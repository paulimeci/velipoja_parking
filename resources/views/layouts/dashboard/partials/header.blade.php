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
                        <livewire:language-switcher />
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

                                    </div>
                                </div>
                                <ul class="admin-link ps-0 mb-0 list-unstyled">
                                    <li>
                                        <a class="dropdown-item admin-item-link d-flex align-items-center text-body" href="{{ route('profile.edit') }}">
                                            <i class="material-symbols-outlined">account_circle</i>
                                            <span class="ms-2">{{ __('My Profile') }}</span>
                                        </a>
                                    </li>
                                    @can('manage all')
                                    <li>
                                        <a class="dropdown-item admin-item-link d-flex align-items-center text-body" href="{{ route('admin.languages') }}">
                                            <i class="material-symbols-outlined">translate</i>
                                            <span class="ms-2">{{ __('Gjuhët') }}</span>
                                        </a>
                                    </li>
                                    @endcan
                                    <li>
                                        <a class="dropdown-item admin-item-link d-flex align-items-center text-body" href="{{ route('admin.change-password') }}">
                                            <i class="material-symbols-outlined">lock</i>
                                            <span class="ms-2">{{ __('Change Password') }}</span>
                                        </a>
                                    </li>
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}" id="logout-form">
                                            @csrf
                                            <button type="submit" class="dropdown-item admin-item-link d-flex align-items-center text-body w-100 border-0 bg-transparent">
                                                <i class="material-symbols-outlined">logout</i>
                                                <span class="ms-2">{{ __('Logout') }}</span>
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
