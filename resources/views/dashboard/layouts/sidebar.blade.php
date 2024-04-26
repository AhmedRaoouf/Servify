<aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 "
    id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href="#" target="_blank">
            <img src="{{ url('/') }}/admin/img/servifay-logo.jpg" class="navbar-brand-img" alt="main_logo">
            <span class="ms-1 font-weight-bold">Servifay</span>
        </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link {{ request()->is('dashboard/home') ? 'active' : '' }}"
                    href="{{ url(app()->getLocale() . '/dashboard/home') }}">

                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-home text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">{{ __('admin.home') }}</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->is('dashboard/admins') ? 'active' : '' }}"
                    href="{{ url(app()->getLocale() . '/dashboard/admins') }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-users-cog text-danger text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">{{ __('admin.admins') }}</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->is('dashboard/services') ? 'active' : '' }}"
                    href="{{ url(app()->getLocale() . '/dashboard/services') }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-tools text-warning text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">{{ __('admin.services') }}</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->is('dashboard/specialists') ? 'active' : '' }}"
                    href="{{ url(app()->getLocale() . '/dashboard/specialists') }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-users  text-info text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">{{ __('admin.specialists') }}</span>
                </a>
            </li>
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">
                    {{ __('admin.accountPages') }}</h6>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="./pages/profile.html">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-single-02 text-dark text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">{{ __('admin.profile') }}</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url(app()->getLocale() . '/dashboard/logout') }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-sign-out-alt text-dark text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">{{ __('admin.logout') }}</span>
                </a>
            </li>


        </ul>
    </div>

</aside>
