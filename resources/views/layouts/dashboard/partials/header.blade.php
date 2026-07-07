<header class="header-area bg-white mb-4 rounded-bottom-15 p-3" id="header-area">
    {{-- Zëvendësuam row/col me flexbox që të qëndrojnë gjithmonë në një rresht horizontal --}}
    <div class="d-flex align-items-center justify-content-between w-100">

        {{-- PJESA E MAJTË: BURGER MENU --}}
        <div class="left-header-content">
            <button class="header-burger-menu bg-transparent p-0 border-0 d-flex align-items-center" id="header-burger-menu">
                <span class="material-symbols-outlined">menu</span>
            </button>
        </div>

        {{-- PJESA E DJATHTË: DARK MODE, GJUHA DHE PROFILI (Të gjitha në një rresht) --}}
        <div class="right-header-content">
            <ul class="d-flex align-items-center gap-3 ps-0 mb-0 list-unstyled">

                <li class="header-right-item">
                    <div class="light-dark">
                        <button class="switch-toggle settings-btn dark-btn p-0 bg-transparent border-0 d-flex align-items-center" id="switch-toggle">
                            <span class="dark"><i class="material-symbols-outlined">light_mode</i></span>
                            <span class="light"><i class="material-symbols-outlined">dark_mode</i></span>
                        </button>
                    </div>
                </li>

                <li class="header-right-item">
                    <livewire:language-switcher />
                </li>

                <li class="header-right-item">
                    <div class="dropdown admin-profile">
                        <div class="d-flex align-items-center bg-transparent border-0 text-start p-0 cursor dropdown-toggle" data-bs-toggle="dropdown">
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
                            {{-- Fshehim emrin me tekst në mobile që të mos zërë vend dhe të krijojë thyerje --}}
                            <div class="flex-grow-1 ms-2 d-none d-md-block">
                                <h3 class="fs-14 mb-0">{{ explode(' ', Auth::user()->name)[0] }}</h3>
                            </div>
                        </div>

                        <div class="dropdown-menu border-0 bg-white dropdown-menu-end shadow">
                            <div class="d-flex align-items-center info p-3">
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

            </ul>
        </div>

    </div>
</header>
