<nav class="main-header navbar navbar-expand-md navbar-light navbar-white sticky-top">
    <div class="container">
        <a href="{{ route('home.index') }}" class="navbar-brand">
            <img src="{{ asset('assets/img/laravel.png') }}" alt="{{ config('app.name') }} Logo"
                 class="brand-image"
                 style="opacity: .8">
            <span class="brand-text font-weight-light">{{ config('app.name') }}</span>
        </a>
        <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse"
                aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse order-3" id="navbarCollapse">

            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="{{ route('home.index') }}" class="nav-link {{ Request::is("/") ? "active" : "" }}">Home</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('home.product') }}"
                       class="nav-link {{ Request::is("product*") ? "active" : "" }}">Product</a>
                </li>

            </ul>
        </div>

        <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
            <li class="nav-item dropdown">
                @auth
                    <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                       class="nav-link dropdown-toggle">{{ auth()->user()->name }}</a>
                @endauth
                @guest
                    <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                       class="nav-link dropdown-toggle">Menu</a>
                @endguest
                <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                    @auth
                        @if(auth()->user()->role === 'admin')
                            <li><a href="{{ route('dashboard.index') }}" class="dropdown-item">Dashboard</a></li>
                            <li class="dropdown-divider"></li>
                        @endif
                        <li>
                            <form action="{{ route('auth.logout') }}" method="post">
                                @csrf
                                <button type="submit" class="dropdown-item d-flex align-items-center">
                                    <i class="fas fa-sign-out-alt mr-2"></i>
                                    Logout
                                </button>
                            </form>
                        </li>
                    @endauth
                    @guest
                        <li><a href="{{ route('auth.login') }}" class="dropdown-item">Login</a></li>
                        <li><a href="{{ route('auth.register') }}" class="dropdown-item">Register</a></li>
                    @endguest
                </ul>
            </li>

        </ul>
    </div>
</nav>
