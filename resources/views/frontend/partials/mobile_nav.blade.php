<!-- ===================== MOBILE BOTTOM NAV ===================== -->
<nav class="pl-bottom-nav d-lg-none">
  <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}"><i class="bi bi-house-door-fill"></i>Home</a>
  <a href="{{ route('shop') }}" class="{{ request()->routeIs('shop') ? 'active' : '' }}"><i class="bi bi-grid-3x3-gap-fill"></i>Shop</a>
  <a href="{{ route('wishlist.index') }}" class="{{ request()->routeIs('wishlist.index') ? 'active' : '' }}" style="position: relative;">
    <i class="bi bi-heart-fill"></i>Wishlist
    <span class="pl-cart-dot bg-danger" data-wishlist-badge style="{{ session()->has('wishlist') && count(session('wishlist')) > 0 ? 'display:flex;' : 'display:none;' }}">{{ session()->has('wishlist') ? count(session('wishlist')) : 0 }}</span>
  </a>
  <a href="{{ auth()->check() ? route('dashboard') : route('login') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}"><i class="bi bi-speedometer2"></i>Account</a>
  <a href="{{ route('cart.index') }}" class="{{ request()->routeIs('cart.index') ? 'active' : '' }}" style="position: relative;">
    <i class="bi bi-cart3"></i>Cart
    <span class="pl-cart-dot" data-cart-badge style="{{ session()->has('cart') && array_sum(array_column(session('cart'), 'quantity')) > 0 ? 'display:flex;' : 'display:none;' }}">{{ session()->has('cart') ? array_sum(array_column(session('cart'), 'quantity')) : 0 }}</span>
  </a>
</nav>

@php
  $rawPhone = preg_replace('/[^0-9]/', '', \App\Models\Setting::get('site_phone', '919915978757'));
  if (strlen($rawPhone) == 10) {
      $rawPhone = '91' . $rawPhone;
  }
@endphp
<a href="https://wa.me/{{ $rawPhone }}" target="_blank" class="pl-whatsapp-float" title="Chat on WhatsApp">
  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor">
    <path d="M13.601 2.326A7.85 7.85 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.9 7.9 0 0 0 3.79.977h.004c4.368 0 7.928-3.558 7.93-7.93a7.9 7.9 0 0 0-2.327-5.615zM7.994 14.52a6.6 6.6 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.56 6.56 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592m3.618-4.934c-.197-.1-.1.197-.502.399-.1.052-.23.115-.492.059-.262-.057-.492-.162-.857-.36-.456-.247-.745-.515-.929-.691-.184-.176-.324-.36-.37-.414-.045-.054-.009-.083.018-.11.024-.025.054-.064.082-.095v-.012c.01-.013.02-.027.027-.041.024-.049.035-.097.018-.146-.017-.05-.152-.366-.208-.5-.055-.133-.11-.115-.152-.117-.038-.002-.082-.002-.128-.002a.246.246 0 0 0-.18.085c-.06.064-.23.225-.23.55s.236.637.268.682c.033.045.779.688.739.685a.77.77 0 0 0 .39.172c.1.021.23.029.39.022.16-.006.27-.018.33-.049.06-.03.12-.08.17-.11.08-.05.14-.1.19-.15z"/>
  </svg>
</a>
