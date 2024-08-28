<aside class="main-sidebar sidebar-light-primary elevation-1">
    <a href="{{ route('dashboard.index') }}" class="brand-link text-center">
        <span class="brand-text">{{ config('app.name') }}</span>
    </a>

    <div class="sidebar">
        <div class="user-panel d-flex mb-3 mt-3 pb-3">
            <div class="image">
                <img src="{{ asset("assets/img/user2-160x160.jpg")}}" class="img-circle elevation-1" alt="User Image"/>
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ auth()->user()->name }}</a>
            </div>
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('dashboard.index') }}"
                       class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-header">MENU</li>
                <li class="nav-item">
                    <a href="{{ route('category.index') }}"
                       class="nav-link {{ Request::is('dashboard/category*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-cubes"></i>
                        <p>Category</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('product.index') }}"
                       class="nav-link {{ Request::is('dashboard/product*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-boxes"></i>
                        <p>Product</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
