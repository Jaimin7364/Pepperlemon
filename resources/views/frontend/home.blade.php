<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<title>Pepperlemon | Home</title>
<link rel="icon" href="{{ asset('images/logo.jpeg') }}">
<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800;900&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/style.css?v=6') }}">
</head>
<body>

@include('frontend.partials.header')

<main class="container pl-section">

  <!-- ===================== HERO BANNER SECTION ===================== -->
  <section class="pl-hero-section mb-4">
    <div class="row g-3">
      <!-- Main Hero Slider (Full Width) -->
      <div class="col-12">
        <div id="plHeroCarousel" class="carousel slide carousel-fade pl-hero-carousel h-100" data-bs-ride="carousel" data-bs-interval="5000">
          <!-- Indicators -->
          <div class="carousel-indicators pl-carousel-indicators">
            @if(isset($banners) && count($banners) > 0)
              @foreach($banners as $index => $b)
                <button type="button" data-bs-target="#plHeroCarousel" data-bs-slide-to="{{ $index }}" class="{{ $loop->first ? 'active' : '' }}" aria-current="{{ $loop->first ? 'true' : 'false' }}"></button>
              @endforeach
            @else
              <button type="button" data-bs-target="#plHeroCarousel" data-bs-slide-to="0" class="active" aria-current="true"></button>
              <button type="button" data-bs-target="#plHeroCarousel" data-bs-slide-to="1"></button>
              <button type="button" data-bs-target="#plHeroCarousel" data-bs-slide-to="2"></button>
            @endif
          </div>

          <div class="carousel-inner h-100 rounded-4 overflow-hidden shadow-sm">
            @if(isset($banners) && count($banners) > 0)
              @foreach($banners as $index => $banner)
                <div class="carousel-item {{ $loop->first ? 'active' : '' }} h-100">
                  <a href="{{ $banner->link ?: url('/shop') }}" class="pl-hero-slide d-block h-100">
                    <img src="{{ asset($banner->image_path) }}" alt="{{ $banner->title ?: 'Banner image' }}" class="pl-hero-img">
                  </a>
                </div>
              @endforeach
            @else
              <!-- Slide 1 -->
              <div class="carousel-item active h-100">
                <a href="{{ url('/shop') }}" class="pl-hero-slide d-block h-100">
                  <img src="{{ asset('images/hero_banner_new.png') }}" alt="Fresh Organic Groceries Banner" class="pl-hero-img">
                </a>
              </div>
              <!-- Slide 2 -->
              <div class="carousel-item h-100">
                <a href="{{ url('/shop') }}?cat=beverage" class="pl-hero-slide d-block h-100">
                  <img src="{{ asset('images/banner2_new.png') }}" alt="Premium Beverages" class="pl-hero-img">
                </a>
              </div>
              <!-- Slide 3 -->
              <div class="carousel-item h-100">
                <a href="{{ url('/shop') }}?cat=snacks" class="pl-hero-slide d-block h-100">
                  <img src="{{ asset('images/banner3_new.png') }}" alt="Gourmet Snacks" class="pl-hero-img">
                </a>
              </div>
            @endif
          </div>

          <!-- Slider Controls -->
          <button class="carousel-control-prev pl-carousel-nav" type="button" data-bs-target="#plHeroCarousel" data-bs-slide="prev">
            <span class="pl-nav-icon"><i class="bi bi-chevron-left"></i></span>
          </button>
          <button class="carousel-control-next pl-carousel-nav" type="button" data-bs-target="#plHeroCarousel" data-bs-slide="next">
            <span class="pl-nav-icon"><i class="bi bi-chevron-right"></i></span>
          </button>
        </div>
      </div>
    </div>

    <!-- Perks Bar -->
    <div class="pl-perks-bar mt-3">
      <div class="row g-2 g-md-3">
        <div class="col-6 col-md-3">
          <div class="pl-perk-card">
            <div class="pl-perk-icon"><i class="bi bi-lightning-charge-fill"></i></div>
            <div>
              <div class="pl-perk-title">30-Min Express</div>
              <div class="pl-perk-desc">Superfast local dispatch</div>
            </div>
          </div>
        </div>
        <div class="col-6 col-md-3">
          <div class="pl-perk-card">
            <div class="pl-perk-icon"><i class="bi bi-shield-check"></i></div>
            <div>
              <div class="pl-perk-title">100% Organic</div>
              <div class="pl-perk-desc">Pure & certified items</div>
            </div>
          </div>
        </div>
        <div class="col-6 col-md-3">
          <div class="pl-perk-card">
            <div class="pl-perk-icon"><i class="bi bi-tags-fill"></i></div>
            <div>
              <div class="pl-perk-title">Best Price Deal</div>
              <div class="pl-perk-desc">Direct farm & brand prices</div>
            </div>
          </div>
        </div>
        <div class="col-6 col-md-3">
          <div class="pl-perk-card">
            <div class="pl-perk-icon"><i class="bi bi-arrow-counterclockwise"></i></div>
            <div>
              <div class="pl-perk-title">Easy Returns</div>
              <div class="pl-perk-desc">Hassle-free replacement</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ===================== TOP CATEGORIES ===================== -->
  <section class="pl-section pt-0">
    <div class="pl-section-head">
      <h2>Top Categories</h2>
      <a href="{{ url('/shop') }}" class="pl-view-all">View All</a>
    </div>
    <div class="pl-cat-list">
      <a href="{{ url('/shop') }}?cat=mexican" class="pl-cat-pill text-decoration-none">
        <div class="pl-cat-icon cat-mexican"><i class="bi bi-cup-straw"></i></div>
        <span>Mexican Product</span>
      </a>
      <a href="{{ url('/shop') }}?cat=beverage" class="pl-cat-pill text-decoration-none">
        <div class="pl-cat-icon cat-beverage"><i class="bi bi-snow2"></i></div>
        <span>Beverage / Can</span>
      </a>
      <a href="{{ url('/shop') }}?cat=candy" class="pl-cat-pill text-decoration-none">
        <div class="pl-cat-icon cat-candy"><i class="bi bi-gift"></i></div>
        <span>Grocery / Candy</span>
      </a>
      <a href="{{ url('/shop') }}?cat=snacks" class="pl-cat-pill text-decoration-none">
        <div class="pl-cat-icon cat-snacks"><i class="bi bi-basket"></i></div>
        <span>Snacks</span>
      </a>
      <a href="{{ url('/shop') }}?cat=water" class="pl-cat-pill text-decoration-none">
        <div class="pl-cat-icon cat-water"><i class="bi bi-droplet"></i></div>
        <span>Water</span>
      </a>
      <a href="{{ url('/shop') }}?cat=chocolate" class="pl-cat-pill text-decoration-none">
        <div class="pl-cat-icon cat-chocolate"><i class="bi bi-box-seam"></i></div>
        <span>Chocolate</span>
      </a>
    </div>
  </section>

  <!-- ===================== NEW PRODUCTS ===================== -->
  <section class="pl-section">
    <div class="pl-section-head">
      <h2>New Products</h2>
      <div class="pl-scroll-arrows d-none d-md-flex gap-2" data-scroll-target="new-products-render">
        <button type="button" class="scroll-prev"><i class="bi bi-chevron-left"></i></button>
        <button type="button" class="scroll-next"><i class="bi bi-chevron-right"></i></button>
      </div>
    </div>
    <div class="pl-hscroll" id="new-products-render">
      @foreach($featuredProducts as $product)
      <div class="pl-hscroll-item" data-product>
        <div class="pl-product-card">
          <div class="pl-product-img-wrap">
            <!-- Tags Overlay -->
            @if($product->sale_price)
              <div class="pl-card-tags">
                @php
                  $discount = round((($product->price - $product->sale_price) / $product->price) * 100);
                @endphp
                <span class="pl-tag pl-tag-sale">{{ $discount }}% OFF</span>
              </div>
            @endif
              @if($product->quantity <= 0)
                <div class="pl-card-tags" style="top:auto;bottom:8px;left:8px;right:auto;">
                  <span class="pl-tag" style="background:#ef4444;color:#fff;">Out of Stock</span>
                </div>
              @endif
              <button class="pl-wishlist-btn" data-wishlist-product-id="{{ $product->id }}" onclick="PL.toggleWishlist('{{ $product->id }}')"><i class="{{ is_array(session('wishlist')) && in_array($product->id, session('wishlist')) ? 'bi bi-heart-fill text-danger' : 'bi bi-heart' }}"></i></button>
            <a href="{{ route('product.show', $product->slug) }}"><img src="{{ $product->primary_image_url }}" alt="{{ $product->name }}"></a>
          </div>
          <div class="pl-product-body">
            <a href="{{ route('product.show', $product->slug) }}" class="pl-product-title" title="{{ $product->name }}">{{ $product->name }}</a>
            <div class="pl-product-price">${{ number_format($product->sale_price ?? $product->price, 2) }}
              @if($product->sale_price)
                <span class="pl-old">${{ number_format($product->price, 2) }}</span>
              @endif
            </div>
            <div class="mt-auto d-flex gap-2">
              @if($product->quantity > 0)
                <button class="pl-btn-outline text-center flex-grow-1 py-2" onclick="PL.buyNow('{{ $product->id }}')">Buy Now</button>
                <button class="btn btn-pl-primary px-3 d-flex align-items-center justify-content-center" style="border-radius:8px;" onclick="PL.addToCartById('{{ $product->id }}')"><i class="bi bi-cart-plus"></i></button>
              @else
                <button class="btn w-100 py-2" style="border-radius:8px;background:#f1f5f9;color:#94a3b8;border:1px solid #e2e8f0;font-size:0.75rem;font-weight:700;cursor:not-allowed;" disabled><i class="bi bi-x-circle me-1"></i> Out of Stock</button>
              @endif
            </div>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </section>

  <!-- ===================== BEST SELLERS ===================== -->
  <section class="pl-section">
    <div class="pl-section-head">
      <h2>Best Sellers</h2>
      <div class="pl-scroll-arrows d-none d-md-flex gap-2" data-scroll-target="best-sellers-render">
        <button type="button" class="scroll-prev"><i class="bi bi-chevron-left"></i></button>
        <button type="button" class="scroll-next"><i class="bi bi-chevron-right"></i></button>
      </div>
    </div>
    <div class="pl-hscroll" id="best-sellers-render">
      @foreach($bestSellers as $product)
      <div class="pl-hscroll-item" data-product>
        <div class="pl-product-card">
          <div class="pl-product-img-wrap">
            <!-- Tags Overlay -->
            @if($product->sale_price)
              <div class="pl-card-tags">
                @php
                  $discount = round((($product->price - $product->sale_price) / $product->price) * 100);
                @endphp
                <span class="pl-tag pl-tag-sale">{{ $discount }}% OFF</span>
              </div>
            @endif
              @if($product->quantity <= 0)
                <div class="pl-card-tags" style="top:auto;bottom:8px;left:8px;right:auto;">
                  <span class="pl-tag" style="background:#ef4444;color:#fff;">Out of Stock</span>
                </div>
              @endif
              <button class="pl-wishlist-btn" data-wishlist-product-id="{{ $product->id }}" onclick="PL.toggleWishlist('{{ $product->id }}')"><i class="{{ is_array(session('wishlist')) && in_array($product->id, session('wishlist')) ? 'bi bi-heart-fill text-danger' : 'bi bi-heart' }}"></i></button>
            <a href="{{ route('product.show', $product->slug) }}"><img src="{{ $product->primary_image_url }}" alt="{{ $product->name }}"></a>
          </div>
          <div class="pl-product-body">
            <a href="{{ route('product.show', $product->slug) }}" class="pl-product-title" title="{{ $product->name }}">{{ $product->name }}</a>
            <div class="pl-product-price">${{ number_format($product->sale_price ?? $product->price, 2) }}
              @if($product->sale_price)
                <span class="pl-old">${{ number_format($product->price, 2) }}</span>
              @endif
            </div>
            <div class="mt-auto d-flex gap-2">
              @if($product->quantity > 0)
                <button class="pl-btn-outline text-center flex-grow-1 py-2" onclick="PL.buyNow('{{ $product->id }}')">Buy Now</button>
                <button class="btn btn-pl-primary px-3 d-flex align-items-center justify-content-center" style="border-radius:8px;" onclick="PL.addToCartById('{{ $product->id }}')"><i class="bi bi-cart-plus"></i></button>
              @else
                <button class="btn w-100 py-2" style="border-radius:8px;background:#f1f5f9;color:#94a3b8;border:1px solid #e2e8f0;font-size:0.75rem;font-weight:700;cursor:not-allowed;" disabled><i class="bi bi-x-circle me-1"></i> Out of Stock</button>
              @endif
            </div>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </section>

  <!-- ===================== ALL PRODUCTS (Infinite Scroll) ===================== -->
  <section class="pl-section">
    <div class="pl-section-head">
      <h2>All Products</h2>
      <a href="{{ url('/shop') }}" class="pl-view-all">View in Shop</a>
    </div>

    <div class="row g-3" id="home-all-products-render">
      @foreach($allProducts as $product)
      <div class="col-6 col-md-4 col-lg-3" data-product>
        <div class="pl-product-card">
          <div class="pl-product-img-wrap">
            @if($product->sale_price)
              <div class="pl-card-tags">
                @php $discount = round((($product->price - $product->sale_price) / $product->price) * 100); @endphp
                <span class="pl-tag pl-tag-sale">{{ $discount }}% OFF</span>
              </div>
            @endif
            @if($product->quantity <= 0)
              <div class="pl-card-tags" style="top:auto;bottom:8px;left:8px;right:auto;">
                <span class="pl-tag" style="background:#ef4444;color:#fff;">Out of Stock</span>
              </div>
            @endif
            <button class="pl-wishlist-btn" data-wishlist-product-id="{{ $product->id }}" onclick="PL.toggleWishlist('{{ $product->id }}')"><i class="{{ is_array(session('wishlist')) && in_array($product->id, session('wishlist')) ? 'bi bi-heart-fill text-danger' : 'bi bi-heart' }}"></i></button>
            <a href="{{ route('product.show', $product->slug) }}"><img src="{{ $product->primary_image_url }}" alt="{{ $product->name }}"></a>
          </div>
          <div class="pl-product-body">
            <a href="{{ route('product.show', $product->slug) }}" class="pl-product-title" title="{{ $product->name }}">{{ $product->name }}</a>
            <div class="pl-product-price">${{ number_format($product->sale_price ?? $product->price, 2) }}
              @if($product->sale_price)
                <span class="pl-old">${{ number_format($product->price, 2) }}</span>
              @endif
            </div>
            <div class="mt-auto d-flex gap-2">
              @if($product->quantity > 0)
                <button class="pl-btn-outline text-center flex-grow-1 py-2" onclick="PL.buyNow('{{ $product->id }}')">Buy Now</button>
                <button class="btn btn-pl-primary px-3 d-flex align-items-center justify-content-center" style="border-radius:8px;" onclick="PL.addToCartById('{{ $product->id }}')"><i class="bi bi-cart-plus"></i></button>
              @else
                <button class="btn w-100 py-2" style="border-radius:8px;background:#f1f5f9;color:#94a3b8;border:1px solid #e2e8f0;font-size:0.75rem;font-weight:700;cursor:not-allowed;" disabled><i class="bi bi-x-circle me-1"></i> Out of Stock</button>
              @endif
            </div>
          </div>
        </div>
      </div>
      @endforeach
    </div>

    <!-- Infinite Scroll Loader -->
    <div id="home-infinite-loader" class="text-center py-4 col-12 d-none">
      <div class="spinner-border" role="status" style="width:2.2rem;height:2.2rem;border-width:0.22em;color:#C49A6C !important;">
        <span class="visually-hidden">Loading...</span>
      </div>
    </div>

    <!-- Hidden pagination (used by JS to find next page URL) -->
    <div id="home-pagination-container" class="mt-4">
      {{ $allProducts->links('pagination::bootstrap-5') }}
    </div>
  </section>

</main>

<!-- ===================== FOOTER (DESKTOP) ===================== -->
@include('frontend.partials.footer')
@include('frontend.partials.mobile_nav')

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  window.pl_csrf = '{{ csrf_token() }}';
</script>
<script src="{{ asset('js/script.js?v=3') }}"></script>

<script>
  // ===== HOME PAGE INFINITE SCROLL =====
  document.addEventListener('DOMContentLoaded', () => {
    let loading = false;
    let nextPageUrl = '';
    const loader = document.getElementById('home-infinite-loader');
    const paginationContainer = document.getElementById('home-pagination-container');
    const grid = document.getElementById('home-all-products-render');

    const updateNextPageUrl = () => {
      if (!paginationContainer) return;
      const nextLink = paginationContainer.querySelector('a[rel="next"]');
      nextPageUrl = nextLink ? nextLink.href : '';
      paginationContainer.classList.add('d-none'); // hide visual pagination
    };

    updateNextPageUrl();

    if (loader && nextPageUrl) {
      loader.classList.remove('d-none');

      const loadNextPage = async () => {
        if (loading || !nextPageUrl) return;
        loading = true;
        loader.classList.remove('d-none');

        try {
          const res = await fetch(nextPageUrl, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
          });
          if (!res.ok) throw new Error('Network error');

          const html = await res.text();
          const parser = new DOMParser();
          const doc = parser.parseFromString(html, 'text/html');

          // Append new product cards
          const newGrid = doc.getElementById('home-all-products-render');
          if (newGrid && grid) {
            newGrid.querySelectorAll('[data-product]').forEach(card => grid.appendChild(card));
          }

          // Update pagination for next iteration
          const nextPagination = doc.getElementById('home-pagination-container');
          if (nextPagination && paginationContainer) {
            paginationContainer.innerHTML = nextPagination.innerHTML;
          }

          updateNextPageUrl();

          if (!nextPageUrl) {
            loader.classList.add('d-none'); // no more pages
          }
        } catch (err) {
          console.error('Home infinite scroll error:', err);
          loader.classList.add('d-none');
        } finally {
          loading = false;
        }
      };

      // Trigger load when loader comes into viewport
      const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting && !loading && nextPageUrl) {
            loadNextPage();
          }
        });
      }, { rootMargin: '300px' });

      observer.observe(loader);
    } else if (loader) {
      loader.classList.add('d-none'); // only 1 page, hide loader
    }
  });
</script>

</body>
</html>
