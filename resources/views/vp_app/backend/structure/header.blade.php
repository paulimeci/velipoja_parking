@php
    use App\Models\GjuhetByUser;
   use App\Models\Gjuhet;
   use Illuminate\Support\Facades\Auth;
       $Gjuhet = new Gjuhet();
       $data = Auth::user();
@endphp
<header class="header-main">
    <div class="container-fluid">
        <div class="row">
            <div class="col-6 col-sm-4 d-flex align-items-center header-left p-0">
                <span class="header-toggle me-3">
                  <i class="ph ph-circles-four"></i>
                </span>
            </div>

            <div class="col-6 col-sm-8 d-flex align-items-center justify-content-end header-right p-0">

                <ul class="d-flex align-items-center">

                    <li class="header-cloud">
                        <a href="#" class="head-icon" role="button" data-bs-toggle="offcanvas"
                           data-bs-target="#cloudoffcanvasTops" aria-controls="cloudoffcanvasTops">
                            <i class="ph-duotone  ph-cloud-sun text-primary f-s-26 me-1"></i>
                            <span>26 <sup class="f-s-10">°C</sup></span>
                        </a>

                    </li>

                    <li class="header-language">
                        <div id="lang_selector" class="flex-shrink-0 dropdown">
                            <a href="#" class="d-block head-icon ps-0" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="lang-flag">
                <span class="flag rounded-circle overflow-hidden">
                    <!-- Dynamically display the current language using its class -->
                    <i class="flag-icon flag-icon-{{ strtolower(GjuhetByUser::My_Default_Lang()->Datti_Gjuha->inicialet) }} flag-icon-squared b-r-10 f-s-22"></i>
                </span>
                                </div>
                            </a>
                            <ul class="dropdown-menu language-dropdown header-card border-0">
                                @foreach($Gjuhet->Gjuhet() as $gj)
                                    <li class="lang dropdown-item p-2" data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="{{ $gj->emri }}">
                                        <form action="{{ route('nderro_gjuhe') }}" method="POST"
                                              class="d-flex align-items-center">
                                            @csrf
                                            <input type="hidden" name="gjuha_zgjedhur" value="{{ $gj->id }}">
                                            <button type="submit" class="btn p-0 d-flex align-items-center w-100">
                                                <span class="flag-icon flag-icon-{{ strtolower($gj->inicialet) }} flag-icon-squared b-r-10 f-s-22 me-2"></span>
                                                <span class="ps-2">{{ $gj->emri }}</span>
                                            </button>
                                        </form>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </li>
                    <li class="header-dark">
                        <div class="sun-logo head-icon">
                            <i class="ph ph-moon-stars"></i>
                        </div>
                        <div class="moon-logo head-icon">
                            <i class="ph ph-sun-dim"></i>
                        </div>
                    </li>

                    <li class="header-notification">
                        <a href="#" class="d-block head-icon position-relative" role="button" data-bs-toggle="offcanvas"
                           data-bs-target="#notificationcanvasRight" aria-controls="notificationcanvasRight">
                            <i class="ph ph-bell"></i>
                            <span
                                    class="position-absolute translate-middle p-1 bg-success border border-light rounded-circle animate__animated animate__fadeIn animate__infinite animate__slower"></span>
                        </a>
                        <div class="offcanvas offcanvas-end header-notification-canvas" tabindex="-1"
                             id="notificationcanvasRight" aria-labelledby="notificationcanvasRightLabel">
                            <div class="offcanvas-header">
                                <h5 class="offcanvas-title" id="notificationcanvasRightLabel">Notification</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                                        aria-label="Close"></button>
                            </div>
                            <div class="offcanvas-body app-scroll p-0">
                                <div class="head-container">
                                    <div class="notification-message head-box">
                                        <div class="message-images">
                              <span class="bg-secondary h-35 w-35 d-flex-center b-r-10 position-relative">
                                <img src="{{asset('../assets/images/ai_avtar/6.jpg')}}" alt="" class="img-fluid b-r-10">
                                <span
                                        class="position-absolute bottom-30 end-0 p-1 bg-secondary border border-light rounded-circle notification-avtar"></span>
                              </span>
                                        </div>
                                        <div class="message-content-box flex-grow-1 ps-2">

                                            <a href="#" class="f-s-15 text-secondary mb-0"><span
                                                        class="f-w-500 text-secondary">Gene Hart</span> wants to edit
                                                <span
                                                        class="f-w-500 text-secondary">Report.doc</span></a>
                                            <div>
                                                <a class="d-inline-block f-w-500 text-success me-1" href="#">Approve</a>
                                                <a class="d-inline-block f-w-500 text-danger" href="#">Deny</a>
                                            </div>
                                            <span class="badge text-light-secondary mt-2"> sep 23 </span>

                                        </div>
                                        <div class="align-self-start text-end">
                                            <i class="ph ph-trash f-s-18 text-danger close-btn"></i>
                                        </div>
                                    </div>
                                    <div class="notification-message head-box">
                                        <div class="message-images">
                              <span class="bg-light-dark h-35 w-35 d-flex-center b-r-10 position-relative">
                                <i class="ph-duotone  ph-truck f-s-18"></i>
                              </span>
                                        </div>
                                        <div class="message-content-box flex-grow-1 ps-2">
                                            <a href="#" class="f-s-15 text-secondary mb-0">Hey
                                                <span
                                                        class="f-w-500 text-secondary">Emery McKenzie</span>, get ready:
                                                Your order from <span
                                                        class="f-w-500 text-secondary">@Shopper.com</span> is out for
                                                delivery today!</a>
                                            <span class="badge text-light-secondary mt-2"> sep 23 </span>

                                        </div>
                                        <div class="align-self-start text-end">
                                            <i class="ph ph-trash f-s-18 text-danger close-btn"></i>
                                        </div>
                                    </div>
                                    <div class="notification-message head-box">
                                        <div class="message-images">
                              <span class="bg-secondary h-35 w-35 d-flex-center b-r-10 position-relative">
                                <img src="{{asset('../assets/images/ai_avtar/2.jpg')}}" alt="" class="img-fluid b-r-10">
                                <span
                                        class="position-absolute  end-0 p-1 bg-secondary border border-light rounded-circle notification-avtar"></span>
                              </span>
                                        </div>
                                        <div class="message-content-box flex-grow-1 ps-2">
                                            <a href="#" class="f-s-15 text-secondary mb-0"><span
                                                        class="f-w-500 text-secondary">Simon Young</span> shared a file
                                                called <span
                                                        class="f-w-500 text-secondary">Dropdown.pdf</span></a>
                                            <span class="badge text-light-secondary mt-2"> 30 min</span>

                                        </div>
                                        <div class="align-self-start text-end">
                                            <i class="ph ph-trash f-s-18 text-danger close-btn"></i>
                                        </div>
                                    </div>
                                    <div class="notification-message head-box">
                                        <div class="message-images">
                              <span class="bg-secondary h-35 w-35 d-flex-center b-r-10 position-relative">
                                <img src="{{asset('../assets/images/ai_avtar/5.jpg')}}" alt="" class="img-fluid b-r-10">
                                <span
                                        class="position-absolute end-0 p-1 bg-secondary border border-light rounded-circle notification-avtar"></span>
                              </span>
                                        </div>
                                        <div class="message-content-box flex-grow-1 ps-2">
                                            <a href="#" class="f-s-15 text-secondary mb-0"><span
                                                        class="f-w-500 text-secondary">Becky G. Hayes</span> has added a
                                                comment to <span
                                                        class="f-w-500 text-secondary">Final_Report.pdf</span></a>
                                            <span class="badge text-light-secondary mt-2"> 45 min</span>
                                        </div>
                                        <div class="align-self-start text-end">
                                            <i class="ph ph-trash f-s-18 text-danger close-btn"></i>
                                        </div>
                                    </div>
                                    <div class="notification-message head-box">
                                        <div class="message-images">
                              <span class="bg-secondary h-35 w-35 d-flex-center b-r-10 position-relative">
                                <img src="{{asset('../assets/images/ai_avtar/1.jpg')}}" alt="" class="img-fluid b-r-10">
                                <span
                                        class="position-absolute  end-0 p-1 bg-secondary border border-light rounded-circle notification-avtar"></span>
                              </span>
                                        </div>
                                        <div class="message-content-box flex-grow-1 ps-2">
                                            <a href="#" class="f-s-15 text-secondary mb-0"><span
                                                        class="f-w-600 text-secondary">Romaine Nadeau</span> invited you
                                                to join a meeting
                                            </a>
                                            <div>
                                                <a class="d-inline-block f-w-500 text-success me-1" href="#">Join</a>
                                                <a class="d-inline-block f-w-500 text-danger" href="#">Decline</a>
                                            </div>

                                            <span class="badge text-light-secondary mt-2"> 1 hour ago </span>
                                        </div>
                                        <div class="align-self-start text-end">
                                            <i class="ph ph-trash f-s-18 text-danger close-btn"></i>
                                        </div>
                                    </div>

                                    <div class="hidden-massage py-4 px-3">
                                        <img src="{{asset('../assets/images/icons/bell.png')}}"
                                             class="w-50 h-50 mb-3 mt-2" alt="">
                                        <div>
                                            <h6 class="mb-0">Notification Not Found</h6>
                                            <p class="text-secondary">When you have any notifications added here,will
                                                appear here.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </li>

                    <li class="header-profile">
                        <a href="#" class="d-block head-icon" role="button" data-bs-toggle="offcanvas"
                           data-bs-target="#profilecanvasRight" aria-controls="profilecanvasRight">
                            @if ($data->profile_image)
                                <!-- Profile Image -->
                                <img src="{{ url($data->profile_image) }}" alt="Profile Image"
                                     class="w-px-40 h-auto rounded-circle"
                                     style="width: 40px; height: 40px; object-fit: cover; border: 2px solid #ccc;" />
                            @else
                                <!-- Initials Circle -->
                                @php
                                    // Get initials from the user's name
                                    $initials = strtoupper(substr($data->name, 0, 1) . substr(strrchr($data->name, ' '), 1, 1));
                                    if (strlen($initials) < 2) {
                                        $initials = strtoupper(substr($data->name, 0, 2));
                                    }
                                @endphp
                                <span class="avatar-initial rounded-circle"
                                      style="width: 40px; height: 40px; background-color: white; border: 2px solid #ccc; display: inline-flex; align-items: center; justify-content: center; font-size: 16px; color: #333;">
                {{ $initials }}
            </span>
                            @endif
                        </a>

                        <!-- Offcanvas Profile Menu -->
                        <div class="offcanvas offcanvas-end header-profile-canvas" tabindex="-1" id="profilecanvasRight"
                             aria-labelledby="profilecanvasRight">
                            <div class="offcanvas-body app-scroll">
                                <ul>
                                    <li>
                                        <div class="d-flex-center">
                        <span class="h-45 w-45 d-flex-center b-r-10 position-relative">
                            @if ($data->profile_image)
                                <!-- Profile Image in Offcanvas -->
                                <img src="{{ url($data->profile_image) }}" alt="Profile Image"
                                     class="img-fluid b-r-10"
                                     style="width: 40px; height: 40px; object-fit: cover; border: 2px solid #ccc;" />
                            @else
                                <!-- Initials Circle in Offcanvas -->
                                @php
                                    // Get initials from the user's name
                                    $initials = strtoupper(substr($data->name, 0, 1) . substr(strrchr($data->name, ' '), 1, 1));
                                    if (strlen($initials) < 2) {
                                        $initials = strtoupper(substr($data->name, 0, 2));
                                    }
                                @endphp
                                <span class="avatar-initial rounded-circle"
                                      style="width: 40px; height: 40px; background-color: white; border: 2px solid #ccc; display: inline-flex; align-items: center; justify-content: center; font-size: 16px; color: #333;">
                                    {{ $initials }}
                                </span>
                            @endif
                        </span>
                                        </div>
                                        <div class="text-center mt-2">
                                            <h6 class="mb-0">{{ $data->name }}</h6>
                                            <p class="f-s-12 mb-0 text-secondary">{{ $data->email }}</p>
                                        </div>
                                    </li>

                                    <li class="app-divider-v dotted py-1"></li>
                                    <li>
                                        <a class="f-w-500" href="{{ route('view.profile') }}" target="_blank">
                                            <i class="ph-duotone ph-user-circle pe-1 f-s-20"></i> Profile Details
                                        </a>
                                    </li>

                                    <li>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                        <a class="mb-0 text-danger" href="#"
                                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <i class="ph-duotone ph-sign-out pe-1 f-s-20"></i> Log Out
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>
<!-- Header Section ends -->
