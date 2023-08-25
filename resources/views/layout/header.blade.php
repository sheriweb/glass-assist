<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <div class="navbar-brand-box">
                <a href="{{url('/')}}" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{asset('assets/images/glass-assist-logo-sm.png')}}" alt="logo" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{asset('assets/images/glass-assist-logo.png')}}" alt="logo" height="38">
                    </span>
                </a>
            </div>
            <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect"
                    id="vertical-menu-btn">
                <i class="ri-menu-2-line align-middle"></i>
            </button>
        </div>
        <div class="d-flex">
            <button type="button" class="btn header-item noti-icon waves-effect" data-toggle="fullscreen">
                <i class="ri-fullscreen-line"></i>
            </button>
            @auth
                <div class="dropdown d-inline-block user-dropdown">
                    <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{--<img class="rounded-circle header-profile-user" src="{{asset('assets/images/users/admin.png')}}"
                             alt="Header Avatar">--}}
                        <span class="d-none d-xl-inline-block ms-1">
                            {{ Auth::user()->first_name}} {{ Auth::user()->surname}}
                        </span>
                        <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a class="dropdown-item" href="#"><i class="ri-user-line align-middle me-1"></i> Profile</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item text-danger" href="{{route('user-logout')}}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            <i class="ri-shut-down-line align-middle me-1 text-danger"></i> Logout</a>
                        <form id="logout-form" action="{{ route('user-logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </div>
            @endauth
        </div>
    </div>
</header>
