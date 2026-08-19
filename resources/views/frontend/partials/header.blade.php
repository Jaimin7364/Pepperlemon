<!-- ===================== DESKTOP NAVBAR ===================== -->
<header class="pl-navbar d-none d-lg-block" style="background: #ffffff; border-bottom: 1px solid var(--pl-border); padding: 0.4rem 0;">
  <div class="container d-flex align-items-center justify-content-between">
    
    <!-- LEFT COLUMN: Search bar -->
    <div class="d-flex align-items-center" style="flex: 1; max-width: 320px;">
      <form action="{{ route('shop') }}" method="GET" class="position-relative w-100" style="width: 100%;">
        <input type="search" name="search" class="form-control" placeholder="Search products, categories..." value="{{ request('search') }}" autocomplete="off"
               style="border-radius: 30px; border: 1px solid var(--pl-border); background: #f5faf7; color: var(--pl-ink); padding: 0.55rem 2.8rem 0.55rem 1.2rem; font-size: 0.82rem; outline: none; width: 100%; box-shadow: none;">
        <button type="submit" class="position-absolute" style="right: 14px; top: 50%; transform: translateY(-50%); background: none; border: none; color: var(--pl-muted); font-size: 1rem; cursor: pointer; padding: 0;">
          <i class="bi bi-search"></i>
        </button>
      </form>
    </div>

    <!-- CENTER COLUMN: Centered Logo -->
    <div class="text-center d-flex justify-content-center align-items-center" style="flex: 1;">
      <a href="{{ route('home') }}" class="d-inline-block text-decoration-none">
        <img src="{{ asset('images/logo.jpeg') }}" alt="Pepperlemon logo" style="height: 58px; width: auto; border-radius: 8px; display: block; margin: 0 auto; object-fit: contain;">
        <span style="font-family: 'Outfit', sans-serif; font-weight: 800; font-size: 0.95rem; color: var(--pl-primary-dark); letter-spacing: 0.15em; text-transform: uppercase; margin-top: 6px; display: block; line-height: 1.2;">Pepperlemon</span>
      </a>
    </div>

    <!-- RIGHT COLUMN: Actions (Account, Wishlist, Bag) -->
    <div class="d-flex align-items-center justify-content-end gap-4" style="flex: 1; max-width: 360px;">
      
      <!-- Account Link -->
      @auth
        <div class="dropdown">
          <a href="#" class="d-flex align-items-center gap-2 text-decoration-none dropdown-toggle" id="avatarDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="color: var(--pl-ink); font-size: 0.72rem; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase;">
            <i class="bi bi-person" style="font-size: 1.25rem; color: var(--pl-primary);"></i>
            <span>Account</span>
          </a>
          <ul class="dropdown-menu dropdown-menu-end shadow border-0" aria-labelledby="avatarDropdown" style="border-radius: 12px; margin-top: 10px; background: #ffffff; border: 1px solid var(--pl-border); padding: 8px 0; z-index: 1050;">
            <li><span class="dropdown-item-text text-muted small" style="padding: 4px 16px; display: block;">Signed in as <strong>{{ Auth::user()->name }}</strong></span></li>
            <li><hr class="dropdown-divider" style="background-color: var(--pl-border); border-color: var(--pl-border); margin: 6px 0;"></li>
            <li><a class="dropdown-item pl-dropdown-link-light" href="{{ route('dashboard') }}"><i class="bi bi-speedometer2 me-2" style="color: var(--pl-primary);"></i>Dashboard</a></li>
            <li><a class="dropdown-item pl-dropdown-link-light" href="{{ route('orders.index') }}"><i class="bi bi-box me-2" style="color: var(--pl-primary);"></i>My Orders</a></li>
            <li><a class="dropdown-item pl-dropdown-link-light" href="{{ route('profile.edit') }}"><i class="bi bi-person me-2" style="color: var(--pl-primary);"></i>My Profile</a></li>
            <li><hr class="dropdown-divider" style="background-color: var(--pl-border); border-color: var(--pl-border); margin: 6px 0;"></li>
            <li>
              <form method="POST" action="{{ route('logout') }}" class="m-0">
                @csrf
                <button type="submit" class="dropdown-item text-danger cursor-pointer pl-dropdown-link-light" style="font-size: 0.75rem;"><i class="bi bi-box-arrow-right me-2"></i>Log Out</button>
              </form>
            </li>
          </ul>
        </div>
      @else
        <a href="{{ route('login') }}" class="d-flex align-items-center gap-2 text-decoration-none" style="color: var(--pl-ink); font-size: 0.72rem; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase;">
          <i class="bi bi-person" style="font-size: 1.25rem; color: var(--pl-primary);"></i>
          <span>Account</span>
        </a>
      @endauth

      <!-- Wishlist Link -->
      <a href="{{ route('wishlist.index') }}" class="d-flex align-items-center gap-2 text-decoration-none position-relative" style="color: var(--pl-ink); font-size: 0.72rem; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase;">
        <i class="bi bi-heart" style="font-size: 1.15rem; color: var(--pl-primary);"></i>
        <span>Wishlist</span>
        <span class="d-flex align-items-center justify-content-center position-absolute" data-wishlist-badge
              style="background: var(--pl-red); color: #fff; font-size: 0.6rem; font-weight: 800; border-radius: 50%; width: 15px; height: 15px; top: -5px; right: -8px; {{ session()->has('wishlist') && count(session('wishlist')) > 0 ? 'display:flex !important;' : 'display:none !important;' }}">
          {{ session()->has('wishlist') ? count(session('wishlist')) : 0 }}
        </span>
      </a>

      <!-- Bag (Cart) Link -->
      <a href="{{ route('cart.index') }}" class="d-flex align-items-center gap-2 text-decoration-none position-relative" style="color: var(--pl-ink); font-size: 0.72rem; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase;">
        <i class="bi bi-bag" style="font-size: 1.15rem; color: var(--pl-primary);"></i>
        <span>Bag</span>
        <span class="d-flex align-items-center justify-content-center" data-cart-badge
              style="background: var(--pl-red); color: #fff; font-size: 0.65rem; font-weight: 800; border-radius: 50%; width: 18px; height: 18px; margin-left: 2px; text-align: center; {{ session()->has('cart') && array_sum(array_column(session('cart'), 'quantity')) > 0 ? 'display:flex !important;' : 'display:none !important;' }}">
          {{ session()->has('cart') ? array_sum(array_column(session('cart'), 'quantity')) : 0 }}
        </span>
      </a>

    </div>
  </div>
</header>

<!-- ===================== MOBILE WELCOME HEADER ===================== -->
<header class="pl-welcome-bar d-lg-none" style="background: #ffffff; border-bottom: 1px solid var(--pl-border); padding: 1rem 1rem;">
  <div class="container-fluid d-flex align-items-center justify-content-between p-0">
    <a href="{{ route('home') }}" class="d-flex align-items-center gap-2 text-decoration-none">
      <img src="{{ asset('images/logo.jpeg') }}" alt="Pepperlemon logo" style="height: 38px; width: auto; border-radius: 6px; object-fit: contain;">
      <div>
        <div class="pl-name" style="color: var(--pl-primary-dark); font-weight: 700; font-size: 1.02rem; line-height: 1.1; font-family: var(--pl-font-head);">Pepperlemon</div>
        <div class="pl-hi" style="font-size: 0.62rem; color: var(--pl-muted); letter-spacing: 0.03em; text-transform: uppercase;">Bold Flavor. Fresh Ideas.</div>
      </div>
    </a>
    <div class="d-flex align-items-center gap-3">
      @auth
        <a href="{{ route('dashboard') }}" class="position-relative" title="Account" style="color: var(--pl-primary-dark); font-size: 1.25rem; display: flex;">
          <i class="bi bi-person-circle"></i>
        </a>
      @else
        <a href="{{ route('login') }}" class="position-relative" title="Log In" style="color: var(--pl-primary-dark); font-size: 1.25rem; display: flex;">
          <i class="bi bi-person"></i>
        </a>
      @endauth
      <a href="{{ route('wishlist.index') }}" class="position-relative" title="Wishlist" style="color: var(--pl-primary-dark); font-size: 1.25rem; display: flex;">
        <i class="bi bi-heart"></i>
        <span class="position-absolute d-flex align-items-center justify-content-center" data-wishlist-badge
              style="background: var(--pl-red); color: #fff; font-size: 0.6rem; font-weight: 800; border-radius: 50%; width: 15px; height: 15px; top: -5px; right: -7px; {{ session()->has('wishlist') && count(session('wishlist')) > 0 ? 'display:flex !important;' : 'display:none !important;' }}">
          {{ session()->has('wishlist') ? count(session('wishlist')) : 0 }}
        </span>
      </a>
      <a href="{{ route('cart.index') }}" class="position-relative" title="Cart" style="color: var(--pl-primary-dark); font-size: 1.25rem; display: flex;">
        <i class="bi bi-bag"></i>
        <span class="position-absolute d-flex align-items-center justify-content-center" data-cart-badge
              style="background: var(--pl-red); color: #fff; font-size: 0.6rem; font-weight: 800; border-radius: 50%; width: 15px; height: 15px; top: -5px; right: -7px; {{ session()->has('cart') && array_sum(array_column(session('cart'), 'quantity')) > 0 ? 'display:flex !important;' : 'display:none !important;' }}">
          {{ session()->has('cart') ? array_sum(array_column(session('cart'), 'quantity')) : 0 }}
        </span>
      </a>
    </div>
  </div>
</header>
