<nav class="main-header navbar navbar-expand navbar-white navbar-light sticky-top">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>
    <ul class="navbar-nav ml-auto">
        <a href="{{ route('home.index') }}" class="nav-link">Homepage</a>
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="fas fa-cog"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-md dropdown-menu-right px-2">
                <form action="{{ route('auth.logout') }}" method="post">
                    @csrf
                    <button type="submit" class="dropdown-item d-flex align-items-center">
                        <i class="fas fa-sign-out-alt mr-2"></i>
                        Logout
                    </button>
                </form>
            </div>
        </li>
    </ul>
</nav>
