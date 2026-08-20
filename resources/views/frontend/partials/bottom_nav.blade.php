<!-- ===================== MOBILE BOTTOM NAVIGATION ===================== -->
<nav class="pl-bottom-nav d-lg-none">
    <a href="{{ route('home') }}" class="nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
        <i class="bi {{ request()->routeIs('home') ? 'bi-house-fill' : 'bi-house' }}"></i>
        <span>Home</span>
    </a>
    
    <a href="{{ route('shop') }}" class="nav-item {{ request()->routeIs('shop') || request()->routeIs('category.show') ? 'active' : '' }}">
        <i class="bi {{ request()->routeIs('shop') || request()->routeIs('category.show') ? 'bi-grid-fill' : 'bi-grid' }}"></i>
        <span>Shop</span>
    </a>
    
    <a href="{{ route('cart.index') }}" class="nav-item position-relative {{ request()->routeIs('cart.index') ? 'active' : '' }}">
        <i class="bi {{ request()->routeIs('cart.index') ? 'bi-bag-fill' : 'bi-bag' }}"></i>
        <span>Cart</span>
        <span class="badge position-absolute translate-middle bg-danger border border-light rounded-circle pl-nav-badge" data-cart-badge style="{{ session()->has('cart') && array_sum(array_column(session('cart'), 'quantity')) > 0 ? 'display:flex;' : 'display:none;' }}">
            {{ session()->has('cart') ? array_sum(array_column(session('cart'), 'quantity')) : 0 }}
        </span>
    </a>
    
    @auth
        <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') || request()->routeIs('profile.edit') || request()->routeIs('orders.*') ? 'active' : '' }}">
            <i class="bi {{ request()->routeIs('dashboard') || request()->routeIs('profile.edit') || request()->routeIs('orders.*') ? 'bi-person-fill' : 'bi-person' }}"></i>
            <span>Profile</span>
        </a>
    @else
        <a href="{{ route('login') }}" class="nav-item {{ request()->routeIs('login') ? 'active' : '' }}">
            <i class="bi bi-person"></i>
            <span>Login</span>
        </a>
    @endauth
</nav>
