<!-- Menu Navigation starts -->
<style>

    .main-nav .collapse li:hover {
        background-color: #cadff8; /* Ngjyrë e lehtë gri */
        transition: background-color 0.3s ease;
        border-radius: 5px;
    }

    .main-nav .collapse li:hover > a {
        color: #007bff; /* Ngjyrë blu për tekstin */
        transition: color 0.3s ease;
    }

</style>
<nav>
    <div class="app-logo">
        <a class="logo d-inline-block" href="{{ route('dashboard') }}">
            <img src="{{asset('../assets/images/logo/logo.png')}}" style="border-radius: 10px;" alt="#">
        </a>

        <span class="bg-light-primary toggle-semi-nav">
          <i class="ti ti-chevrons-right f-s-20"></i>
        </span>
    </div>
    <div class="app-nav" id="app-simple-bar">
        <ul class="main-nav p-0 mt-2">
            <li class="menu-title">
                <span>Dashboard</span>
            </li>
            <li>
                <a class="1" data-bs-toggle="collapse" href="#DataTrack" aria-expanded="false">
                    <i class="ph-duotone ph-database"></i>
                    Struttura Rete
                    <span class="badge text-bg-success badge-notification ms-2"></span>
                </a>
               <ul class="collapse" id="DataTrack">
                    <li><a href="{{route('datti_cliente')}}"><i class="ph-duotone ph-database"></i> Nuovo Componente</a></li>
                    <li><a href="{{route('view_partners')}}"><i class="ph-duotone ph-briefcase"></i> Vedi Collaboratori</a></li>
@php
                    $ka_akses=\Illuminate\Support\Facades\Auth::user()->akses_edit()->exists();
@endphp
                   @if($ka_akses)
                   <li><a href="{{route('view_workFlow')}}"><i class="ph-duotone ph-circle-dashed"></i>Workflow</a></li>
                   @endif
               </ul>

            </li>


            <li>
                <a class="" data-bs-toggle="collapse" href="#more" aria-expanded="false">
                    <i class="ph-duotone ph-dots-three"></i>
                    Di più +
                </a>
                <ul class="collapse" id="more">
                    <li><a href="{{route('view_kompanite')}}"><i class="ph-duotone ph-computer-tower"></i> Aziende</a></li>
                    <li><a href="{{route('view_departaments')}}"><i class="ph-duotone ph-briefcase"></i> Dipartimento</a></li>
                    <li><a href="{{route('view_pozicions')}}"><i class="ph-duotone ph-user"></i>Posizioni di lavoro</a></li>
                    <li><a href="{{route('view_staf')}}"><i class="ph-duotone ph-users"></i> Staff</a></li>
                  {{--  <li><a href="{{route('view_klient')}}"><i class="ph-duotone ph-users"></i> Clienti</a></li>--}}
                   {{-- <li><a href="{{route('view_users')}}"><i class="ph-duotone ph-person"></i> Utenti</a></li>--}}
                    {{--<li><a href="{{route('view_add_tasks_users')}}"><i class="ph-duotone ph-tasks"></i> Percakto Pune</a></li>--}}
                </ul>
            </li>









            {{--    <li>
                    <a class="" data-bs-toggle="collapse" href="#dashboard" aria-expanded="false">
                        <i class="ph-duotone  ph-house-line"></i>
                        Dashboard
                        <span class="badge text-bg-success badge-notification ms-2">4</span>
                    </a>
                    <ul class="collapse" id="dashboard">
                        <li><a href="{{ route('index') }}">Ecommerce</a></li>
                        <li><a href="{{ route('project_dashboard') }}">Project</a></li>
                        <li><a href="{{ route('crypto_dashboard') }}">Crypto</a></li>
                        <li><a href="{{ route('education_dashboard') }}">Education</a></li>
                    </ul>
                </li>

                <li>
                    <a class="" data-bs-toggle="collapse" href="#apps" aria-expanded="false">
                        <i class="ph-duotone  ph-stack"></i>
                        Apps
                    </a>
                    <ul class="collapse" id="apps">
                        <li><a href="{{route('calendar')}}">Calender</a></li>
                        <li class="another-level">
                            <a class="" data-bs-toggle="collapse" href="#Profile-page" aria-expanded="false">
                                Profile
                            </a>
                            <ul class="collapse" id="Profile-page">
                                <li><a href="{{route('profile')}}">Profile</a></li>
                                <li><a href="{{route('setting')}}">Setting</a></li>
                            </ul>
                        </li>
                        <li class="another-level">
                            <a class="" data-bs-toggle="collapse" href="#projects-page" aria-expanded="false">
                                Projects Page
                            </a>
                            <ul class="collapse" id="projects-page">
                                <li><a href="{{route('project_app')}}">projects</a></li>
                                <li><a href="{{route('project_details')}}">projects Details</a></li>
                            </ul>
                        </li>
                        <li><a href="{{route('to_do')}}">To-Do</a></li>
                        <li><a href="{{route('team')}}">Team</a></li>
                        <li><a href="{{route('api')}}">API</a></li>
                        <li class="another-level">
                            <a class="" data-bs-toggle="collapse" href="#ticket-page" aria-expanded="false">
                                Ticket
                            </a>
                            <ul class="collapse" id="ticket-page">
                                <li><a href="{{route('ticket')}}">Ticket</a></li>
                                <li><a href="{{route('ticket_details')}}">Ticket Details</a></li>
                            </ul>
                        </li>
                        <li class="another-level">
                            <a class="" data-bs-toggle="collapse" href="#email-page" aria-expanded="false">
                                Email Page
                            </a>
                            <ul class="collapse" id="email-page">
                                <li><a href="{{route('email')}}"> Email</a></li>
                                <li><a href="{{route('read_email')}}">Read Email</a></li>
                            </ul>
                        </li>
                        <li class="another-level">
                            <a class="" data-bs-toggle="collapse" href="#e-shop" aria-expanded="false">
                                E-shop
                            </a>
                            <ul class="collapse" id="e-shop">
                                <li><a href="{{route('cart')}}">Cart</a></li>
                                <li><a href="{{route('product')}}">Product</a></li>
                                <li><a href="{{route('add_product')}}">Add Product</a></li>
                                <li><a href="{{route('product_details')}}">Product-Details</a></li>
                                <li><a href="{{route('product_list')}}">Product list</a></li>
                                <li><a href="{{route('orders')}}">Orders</a></li>
                                <li><a href="{{route('order_details')}}">Orders Details</a></li>
                                <li><a href="{{route('order_list')}}">Orders List</a></li>
                                <li><a href="{{route('checkout')}}">Check out</a></li>
                                <li><a href="{{route('wishlist')}}">Wishlist</a></li>
                            </ul>
                        </li>
                        <li><a href="{{route('invoice')}}">Invoice</a></li>
                        <li><a href="{{route('chat')}}">Chat</a></li>
                        <li><a href="{{route('file_manager')}}">File manager</a></li>
                        <li><a href="{{route('bookmark')}}">Bookmark</a></li>
                        <li><a href="{{route('kanban_board')}}">Kanban board</a></li>
                        <li><a href="{{route('timeline')}}">Timeline</a></li>
                        <li><a href="{{route('faq')}}">FAQS</a></li>
                        <li><a href="{{route('pricing')}}">Pricing</a></li>
                        <li><a href="{{route('gallery')}}">Gallery</a></li>
                        <li class="another-level">
                            <a class="" data-bs-toggle="collapse" href="#blog-page" aria-expanded="false">
                                Blog Page
                            </a>
                            <ul class="collapse" id="blog-page">
                                <li><a href="{{route('blog')}}">Blog</a></li>
                                <li><a href="{{route('blog_details')}}">Blog Details</a></li>
                                <li><a href="{{route('add_blog')}}">Add Blog</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="no-sub">
                    <a class="" href="{{route('widget')}}">
                        <i class="ph-duotone  ph-squares-four"></i> Widgets
                    </a>
                </li>

                <li class="menu-title"> <span>Component</span></li>
                <li>
                    <a class="" data-bs-toggle="collapse" href="#ui-kits" aria-expanded="false">

                        <i class="ph-duotone  ph-briefcase"></i>
                        UI kits
                    </a>
                    <ul class="collapse" id="ui-kits">
                        <li><a href="{{route('cheatsheet')}}">Cheatsheet</a></li>
                        <li><a href="{{route('alert')}}">Alert</a></li>
                        <li><a href="{{route('badges')}}">Badges</a></li>
                        <li><a href="{{route('buttons')}}">Buttons</a></li>
                        <li><a href="{{route('cards')}}">Cards</a></li>
                        <li><a href="{{route('dropdown')}}">Dropdown</a></li>
                        <li><a href="{{route('grid')}}">Grid</a></li>
                        <li><a href="{{route('avatar')}}">Avatar</a></li>
                        <li><a href="{{route('tabs')}}">Tabs</a></li>
                        <li><a href="{{ route('accordions') }}">Accordions</a></li>
                        <li><a href="{{route('progress')}}">Progress</a></li>
                        <li><a href="{{route('notifications')}}">Notifications</a></li>
                        <li><a href="{{route('list')}}">Lists</a></li>
                        <li><a href="{{route('helper_classes')}}">Helper Classes</a></li>
                        <li><a href="{{route('background')}}">Background</a></li>
                        <li><a href="{{route('divider')}}">Divider</a></li>
                        <li><a href="{{route('ribbons')}}">Ribbons</a></li>
                        <li><a href="{{route('editor')}}">Editor </a></li>
                        <li><a href="{{route('collapse')}}">Collapse</a></li>
                        <li><a href="{{route('footer_page')}}">Footer</a></li>
                        <li><a href="{{route('shadow')}}">Shadow</a></li>
                        <li><a href="{{route('wrapper')}}">Wrapper</a></li>
                        <li><a href="{{route('bullet')}}">Bullet</a></li>
                        <li><a href="{{route('placeholder')}}">Placeholder</a></li>
                        <li><a href="{{route('alignment')}}">Alignment Thing</a></li>
                    </ul>
                </li>


                <li>
                    <a class="" data-bs-toggle="collapse" href="#advance-ui" aria-expanded="false">
                        <i class="ph-duotone  ph-briefcase-metal"></i> Advance UI
                        <span class=" badge rounded-pill bg-warning badge-notification ms-2">
                    12+
                    <span class="visually-hidden">unread messages</span>
                  </span>
                    </a>
                    <ul class="collapse" id="advance-ui">
                        <li><a href="{{route('modals')}}">Modals</a></li>
                        <li><a href="{{route('offcanvas')}}">Offcanvas Toggle</a></li>
                        <li><a href="{{route('sweetalert')}}">Sweat Alert</a></li>
                        <li><a href="{{route('scrollbar')}}">Scrollbar</a></li>
                        <li><a href="{{route('spinners')}}">Spinners</a></li>
                        <li><a href="{{route('animation')}}">Animation</a></li>
                        <li><a href="{{route('video_embed')}}">Video Embed</a></li>
                        <li><a href="{{route('tour')}}">Tour</a></li>
                        <li><a href="{{route('slick_slider')}}">Slick Slider</a></li>
                        <li><a href="{{route('bootstrap_slider')}}">Bootstrap Slider</a></li>
                        <li><a href="{{route('scrollpy')}}">Scrollpy</a></li>
                        <li><a href="{{route('tooltips_popovers')}}">Tooltip & Popovers</a></li>
                        <li><a href="{{route('ratings')}}">Rating</a></li>
                        <li><a href="{{route('prismjs')}}">Prismjs</a></li>
                        <li><a href="{{route('count_down')}}">Count Down</a></li>
                        <li><a href="{{route('count_up')}}"> Count up </a></li>
                        <li><a href="{{route('draggable')}}">Draggable</a></li>
                        <li><a href="{{route('tree-view')}}">Tree View</a></li>
                        <li><a href="{{route('block_ui')}}">Block Ui </a></li>
                    </ul>
                </li>
                <li>
                    <a class="" data-bs-toggle="collapse" href="#icons" aria-expanded="false">
                        <i class="ph-duotone  ph-shapes"></i> Icons
                    </a>
                    <ul class="collapse" id="icons">
                        <li><a href="{{route('fontawesome')}}">Fontawesome</a></li>
                        <li><a href="{{route('flag_icons')}}">Flag</a></li>
                        <li><a href="{{route('tabler_icons')}}">Tabler</a></li>
                        <li><a href="{{route('weather_icon')}}">Weather</a></li>
                        <li><a href="{{route('animated_icon')}}">Animated</a></li>
                        <li><a href="{{route('iconoir_icon')}}">Iconoir</a></li>
                        <li><a href="{{route('phosphor')}}">Phosphor</a></li>
                    </ul>
                </li>
                <li class="no-sub">
                    <a class="" href="{{route('misc')}}">
                        <i class="ph-duotone  ph-certificate"></i> Misc
                    </a>
                </li>
                <li class="menu-title"> <span>Map & Charts </span></li>
                <li>
                    <a class="" href="#maps" data-bs-toggle="collapse" aria-expanded="false">
                        <i class="ph-duotone  ph-map-pin-line"></i> Map
                    </a>
                    <ul class="collapse" id="maps">
                        <li><a href="{{route('google_map')}}">Google Maps</a></li>
                        <li><a href="{{route('leaflet_map')}}">Leaflet map</a></li>
                        <li><a href="{{route('vector_map')}}">Vector map</a></li>
                    </ul>
                </li>
                <li>
                    <a class="" data-bs-toggle="collapse" href="#chart" aria-expanded="false">
                        <i class="ph-duotone  ph-chart-pie-slice"></i> Chart
                    </a>
                    <ul class="collapse" id="chart">


                        <li><a href="{{route('chart_js')}}">Chart js</a></li>


                        <li class="another-level">
                            <a class="" data-bs-toggle="collapse" href="#apexcharts-page" aria-expanded="false">
                                Apexcharts
                            </a>
                            <ul class="collapse" id="apexcharts-page">
                                <li><a href="{{route('line_chart')}}">Line</a></li>
                                <li><a href="{{route('area_chart')}}">Area</a></li>
                                <li><a href="{{route('column_chart')}}">Column</a></li>
                                <li><a href="{{route('bar_chart')}}">Bar</a></li>
                                <li><a href="{{route('mixed_chart')}}">Mixed</a></li>
                                <li><a href="{{route('timeline_range_charts')}}">Timeline & Range-Bars</a></li>
                                <li><a href="{{route('candlestick_chart')}}">Candlestick</a></li>
                                <li><a href="{{route('boxplot_chart')}}">Boxplot</a></li>
                                <li><a href="{{route('bubble_chart')}}">Bubble</a></li>
                                <li><a href="{{route('scatter_chart')}}">Scatter</a></li>
                                <li><a href="{{route('heatmap')}}">Heatmap</a></li>
                                <li><a href="{{route('treemap_chart')}}">Treemap</a></li>
                                <li><a href="{{route('pie_charts')}}">Pie</a></li>
                                <li><a href="{{route('radial_bar_chart')}}">Radial bar</a></li>
                                <li><a href="{{route('radar_chart')}}">Radar</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>

                <li class="menu-title"> <span>Table & forms </span></li>

                <li>
                    <a class="" data-bs-toggle="collapse" href="#table" aria-expanded="false">
                        <i class="ph-duotone  ph-table"></i> Table
                    </a>
                    <ul class="collapse" id="table">
                        <li><a href="{{route('basic_table')}}">BasicTable</a></li>
                        <li><a href="{{route('data_table')}}">Data Table</a></li>
                        <li><a href="{{route('list_table')}}">List Js</a></li>
                        <li><a href="{{route('advance_table')}}">Advance Table</a></li>
                    </ul>
                </li>


                <li>
                    <a class="" data-bs-toggle="collapse" href="#forms" aria-expanded="false">
                        <i class="ph-duotone  ph-cardholder"></i> Forms elements
                    </a>
                    <ul class="collapse" id="forms">
                        <li><a href="{{route('form_validation')}}">Form Validation</a></li>
                        <li><a href="{{route('base_inputs')}}">Base Input</a></li>
                        <li><a href="{{route('checkbox_radio')}}">Checkbox & Radio</a></li>
                        <li><a href="{{route('input_groups')}}">Input Groups</a></li>
                        <li><a href="{{route('input_masks')}}">Input Masks</a></li>
                        <li><a href="{{asset('floating_labels')}}">Floating Labels</a></li>
                        <li><a href="{{route('date_picker')}}">Datetimepicker</a></li>
                        <li><a href="{{route('touch_spin')}}">Touch spin</a></li>
                        <li><a href="{{route('select')}}">Select2</a></li>
                        <li><a href="{{route('switch')}}">Switch</a></li>
                        <li><a href="{{route('range_slider')}}">Range Slider</a></li>
                        <li><a href="{{route('typeahead')}}">Typeahead</a></li>
                        <li><a href="{{route('textarea')}}">Textarea</a></li>
                        <li><a href="{{route('clipboard')}}">Clipboard</a></li>
                        <li><a href="{{route('file_upload')}}">File Upload</a></li>
                        <li><a href="{{route('dual_list_boxes')}}">Dual List Boxes</a></li>
                        <li><a href="{{route('default_forms')}}">Default Forms</a></li>
                    </ul>
                </li>

                <li>
                    <a class="" data-bs-toggle="collapse" href="#ready_to_use" aria-expanded="false">
                        <i class="ph-duotone  ph-hand-heart"></i>
                        Ready to use <span class="badge text-light-success badge-notification ms-2">New</span>
                    </a>
                    <ul class="collapse" id="ready_to_use">
                        <li><a href="{{route('form_wizards')}}">Form wizards</a></li>
                        <li><a href="{{route('form_wizard_1')}}">Form wizards 1</a></li>
                        <li><a href="{{route('form_wizard_2')}}">Form wizards 2</a></li>
                        <li><a href="{{route('ready_to_use_form')}}">Ready To Use Form</a></li>
                        <li><a href="{{route('ready_to_use_table')}}">Ready To Use Tables</a></li>
                    </ul>
                </li>

                <li class="menu-title"> <span>Pages</span></li>

                <li>
                    <a class="" data-bs-toggle="collapse" href="#auth_pages" aria-expanded="false">
                        <i class="ph-duotone  ph-notebook"></i> Auth Pages
                    </a>
                    <ul class="collapse" id="auth_pages">
                        <li><a href="{{route('sign_in')}}">Sign In</a></li>
                        <li><a href="{{route('sign_in_1')}}">Sign In with Bg-image</a></li>
                        <li><a href="{{route('sign_up')}}">Sign Up</a></li>
                        <li><a href="{{route('sign_up_1')}}">Sign Up with Bg-image</a></li>
                        <li><a href="{{route('password_reset')}}">Password Reset</a></li>
                        <li><a href="{{route('password_reset_1')}}">Password Reset with Bg-image</a></li>
                        <li><a href="{{route('password_create')}}">Password Create</a></li>
                        <li><a href="{{route('password_create_1')}}">Password Create with Bg-image</a></li>
                        <li><a href="{{route('lock_screen')}}">Lock Screen</a></li>
                        <li><a href="{{route('lock_screen_1')}}">Lock Screen with Bg-image</a></li>
                        <li><a href="{{route('two_step_verification')}}">Two-Step Verification</a></li>
                        <li><a href="{{route('two_step_verification_1')}}">Two-Step Verification with Bg-image</a></li>
                    </ul>
                </li>
                <li>
                    <a class="" data-bs-toggle="collapse" href="#error_pages" aria-expanded="false">
                        <i class="ph-duotone  ph-warning-octagon"></i> Error Pages
                    </a>
                    <ul class="collapse" id="error_pages">
                        <li><a href="{{route('error_400')}}">Bad Request </a></li>
                        <li><a href="{{route('error_403')}}">Forbidden </a></li>
                        <li><a href="{{route('error_404')}}">Not Found</a></li>
                        <li><a href="{{route('error_500')}}">Internal Server</a></li>
                        <li><a href="{{route('error_503')}}">Service Unavailable</a></li>
                    </ul>
                </li>

                <li>
                    <a class="" data-bs-toggle="collapse" href="#other_pages" aria-expanded="false">
                        <i class="ph-duotone  ph-newspaper"></i> Other Pages
                    </a>
                    <ul class="collapse" id="other_pages">
                        <li><a href="{{route('blank')}}">Blank</a></li>
                        <li><a href="{{route('maintenance')}}">Maintenance</a></li>
                        <li><a href="{{route('landing')}}">Landing Page</a></li>
                        <li><a href="{{route('coming_soon')}}">Coming Soon</a></li>
                        <li><a href="{{route('sitemap')}}">Sitemap</a></li>
                        <li><a href="{{route('privacy_policy')}}">Privacy Policy</a></li>
                        <li><a href="{{route('terms_condition')}}">Terms &amp; Condition</a></li>
                    </ul>
                </li>

                <li class="menu-title"> <span>Others</span></li>

                <li>
                    <a class="" data-bs-toggle="collapse" href="#level" aria-expanded="false">
                        <i class="ph-duotone  ph-number-circle-two"></i> 2 level
                    </a>
                    <ul class="collapse" id="level">
                        <li><a href="#">Blank</a></li>
                        <li class="another-level">
                            <a class="" data-bs-toggle="collapse" href="#level2" aria-expanded="false">
                                Another level
                            </a>
                            <ul class="collapse" id="level2">
                                <li><a href="{{route('blank')}}">Blank</a></li>
                            </ul>
                        </li>

                    </ul>
                </li>

                <li class="no-sub">
                    <a class="" href="mailto:teqlathemes@gmail.com.">
                        <i class="ph-duotone  ph-chats"></i> Support
                    </a>
                </li>

    --}}
        </ul>


    </div>
    <a href="https://wa.me/1234567890"
       target="_blank"
       class="btn btn-success rounded-circle position-fixed bottom-0 start-0 m-3 d-flex justify-content-center align-items-center shadow-lg"
       style="width: 60px; height: 60px;">
        <i class="fab fa-whatsapp fa-2x"></i>
        WP
    </a>

    <div class="menu-navs">
        <span class="menu-previous"><i class="ti ti-chevron-left"></i></span>
        <span class="menu-next"><i class="ti ti-chevron-right"></i></span>
    </div>

</nav>
<!-- Menu Navigation ends -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        // Kur klikohet një menu që ka submenu
        $(".main-nav a[data-bs-toggle='collapse']").on("click", function () {
            let target = $(this).attr("href");

            // Hap ose mbyll submenu
            if ($(target).hasClass("show")) {
                $(this).removeClass("active");
            } else {
                $(".main-nav a").removeClass("active");
                $(this).addClass("active");
            }
        });

        // Mbaj submenu hapur në refresh (kontrollo nëse ka klasa `show`)
        $(".collapse.show").each(function () {
            let parentLink = $("a[href='#" + $(this).attr("id") + "']");
            parentLink.addClass("active");
        });
    });
</script>

