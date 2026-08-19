<!-- ===================== FOOTER ===================== -->
<footer class="pl-footer d-none d-lg-block">
  <div class="container">
    <div class="row g-4">
      <div class="col-lg-4">
        <div class="d-flex align-items-center gap-2 mb-3">
          <img src="{{ asset('images/logo.jpeg') }}" class="pl-footer-logo" alt="Pepperlemon logo">
          <span class="fw-bold fs-5 text-white">Pepperlemon LLC</span>
        </div>
        <p class="mb-1"><i class="bi bi-geo-alt me-2" style="color:var(--pl-primary);"></i>{{ \App\Models\Setting::get('site_address', '12800 Northborough Dr, Houston, TX 77067') }}</p>
        <p class="mb-1"><i class="bi bi-envelope me-2" style="color:var(--pl-primary);"></i>{{ \App\Models\Setting::get('site_email', 'Papperlemon1@gmail.com') }}</p>
        <p class="mb-1"><i class="bi bi-telephone me-2" style="color:var(--pl-primary);"></i>{{ \App\Models\Setting::get('site_phone', '+91 9915978757') }}</p>

        @php
            $facebook = \App\Models\Setting::get('social_facebook');
            $twitter = \App\Models\Setting::get('social_twitter');
            $instagram = \App\Models\Setting::get('social_instagram');
            $linkedin = \App\Models\Setting::get('social_linkedin');
            $youtube = \App\Models\Setting::get('social_youtube');
            $hasSocial = $facebook || $twitter || $instagram || $linkedin || $youtube;
        @endphp
        @if($hasSocial)
          <div class="d-flex align-items-center gap-2 mt-3 pl-social-links">
            @if($facebook)
              <a href="{{ $facebook }}" target="_blank" class="pl-social-icon" title="Facebook"><i class="bi bi-facebook"></i></a>
            @endif
            @if($twitter)
              <a href="{{ $twitter }}" target="_blank" class="pl-social-icon" title="Twitter / X"><i class="bi bi-twitter-x"></i></a>
            @endif
            @if($instagram)
              <a href="{{ $instagram }}" target="_blank" class="pl-social-icon" title="Instagram"><i class="bi bi-instagram"></i></a>
            @endif
            @if($linkedin)
              <a href="{{ $linkedin }}" target="_blank" class="pl-social-icon" title="LinkedIn"><i class="bi bi-linkedin"></i></a>
            @endif
            @if($youtube)
              <a href="{{ $youtube }}" target="_blank" class="pl-social-icon" title="YouTube"><i class="bi bi-youtube"></i></a>
            @endif
          </div>
        @endif
      </div>
      <div class="col-6 col-lg-2">
        <h6 class="text-white mb-3">Shop</h6>
        <p class="mb-2"><a href="{{ route('home') }}">Home</a></p>
        <p class="mb-2"><a href="{{ route('shop') }}">Shop Catalog</a></p>
        <p class="mb-2"><a href="{{ route('cart.index') }}">Shopping Cart</a></p>
        <p class="mb-2"><a href="{{ route('wishlist.index') }}">My Wishlist</a></p>
      </div>
      <div class="col-6 col-lg-3">
        <h6 class="text-white mb-3">Company & Policies</h6>
        <p class="mb-2"><a href="{{ route('about') }}">About Us</a></p>
        <p class="mb-2"><a href="{{ route('contact') }}">Contact Us</a></p>
        <p class="mb-2"><a href="{{ route('privacy') }}">Privacy Policy</a></p>
        <p class="mb-2"><a href="{{ route('terms') }}">Terms & Conditions</a></p>
        <p class="mb-2"><a href="{{ route('refund') }}">Refund & Return Policy</a></p>
        <p class="mb-2"><a href="{{ route('cancellation') }}">Cancellation Policy</a></p>
        <p class="mb-2"><a href="{{ route('shipping') }}">Shipping Policy</a></p>
      </div>
      <div class="col-lg-3">
        <h6 class="text-white mb-3">Stay in the loop</h6>
        <p class="mb-3">Subscribe to get special offers, free giveaways, and deals.</p>
        <div class="d-flex gap-2">
          <input type="email" class="form-control form-control-sm bg-white text-dark" placeholder="Your email">
          <button class="btn btn-pl-primary btn-sm px-3">Join</button>
        </div>
      </div>
    </div>
    <hr class="my-4">
    <div class="d-flex justify-content-between flex-wrap gap-2">
      <span>&copy; 2026 Pepperlemon LLC. All rights reserved. | Created by <a href="https://vivektech.online/index.html" target="_blank">VivekTech</a></span>
      <span>Bold Flavor. Fresh Ideas.</span>
    </div>
  </div>
</footer>
