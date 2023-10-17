<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Logo dan Text -->
    <div class="logo-text-container">
        <a href="{{ route('home') }}">
            <img class="img-logo" src="{{ asset('assets/img/logo/logo.png') }}" alt="Logo"></a>
        <span class="navbar-text text-logo">Document Management Information System</span>
    </div>

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">

        <!-- Right Side Of Navbar -->
        <ul class="navbar-nav ms-auto">
            <!-- Authentication Links -->
            @guest
                @if (Route::has('login'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">
                            <span class="mr-2 d-none d-lg-inline text-gray-600 ">{{ __('Login') }}</span></a>
                    </li>
                @endif

                <div class="topbar-divider d-none d-sm-block"></div>

                @if (Route::has('register'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">
                            <span class="mr-2 d-none d-lg-inline text-gray-600 ">{{ __('Register') }}</span></a>
                    </li>
                @endif
            @else
                <!-- Nav Item - User Information -->
                <li class="nav-item dropdown no-arrow">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="mr-2 d-none d-lg-inline text-gray-600">{{ Auth::user()->name }}</span>
                        <img class="img-profile rounded-circle" src="{{ asset('assets/img/profile-user.png') }}">
                    </a>

                    <!-- Dropdown - User Information -->
                    <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                        @if (auth()->user()->role->name === 'Administrator')
                            <a class="dropdown-item" href="{{ route('dashboard') }}">
                                <i class="fas fa-dashboard fa-sm fa-fw mr-2 text-gray-400"></i>
                                Dashboard
                            </a>
                            <div class="dropdown-divider"></div>
                        @endif
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                            Logout
                        </a>
                    </div>
                </li>
            @endguest
        </ul>
    </ul>
</nav>
