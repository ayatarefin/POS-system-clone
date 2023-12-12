<aside class="left-sidebar fixed-sidebar">
    <!-- Sidebar Start -->
    <!-- Sidebar navigation-->

    <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
        <div class="brand-logo d-flex align-items-center justify-content-between mt-3">
            <a class="text-nowrap logo-img">
                <img src="../images/logos/logo.webp" width="130" height="auto" alt="BnB Logo">
            </a>
        </div>
        <ul id="sidebarnav mt-2">
            <li class="sidebar-item">
                <a class="sidebar-link" href="{{route('dashboard')}}" aria-expanded="false">
                    <span>
                        <i class="ti ti-layout-dashboard"></i>
                    </span>
                    <span class="hide-menu">Dashboard</span>
                </a>
            </li>

            <li class="nav-small-cap">
                <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                <span class="hide-menu">Menu</span>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="{{route('currentStock')}}" aria-expanded="false">
                    <span>
                        <i class="ti ti-article"></i>
                    </span>
                    <span class="hide-menu">Stock Reports</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="" aria-expanded="false">
                    {{-- {{route('alertMessage')}} --}}
                    <span>
                        <i class="ti ti-alert-circle"></i>
                    </span>
                    <span class="hide-menu">Alerts</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="" aria-expanded="false">
                    {{-- {{route('alertSystem')}} --}}
                    <span>
                        <i class="ti ti-cards"></i>
                    </span>
                    <span class="hide-menu">Alert Configuration</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="" aria-expanded="false">
                    {{-- {{route('alertReceiver')}} --}}
                    <span>
                        <i class="ti ti-file-description"></i>
                    </span>
                    <span class="hide-menu">Alert Receiver</span>
                </a>
            </li>

            <li class="nav-small-cap">
                <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                <span class="hide-menu">User</span>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="{{route('logout')}}" aria-expanded="false">
                    <span>
                        <i class="ti ti-login"></i>
                    </span>
                    <span class="hide-menu">Logout</span>
                </a>
            </li>
        </ul>
    </nav><!-- End Sidebar navigation -->
</aside><!--  Sidebar End -->
