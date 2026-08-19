<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<title>Pepperlemon | All Beverage</title>
<link rel="icon" href="{{ asset('images/logo.jpeg') }}">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/style.css?v=2') }}">
</head>
<body>

@include('frontend.partials.header')

<!-- ===================== MOBILE PAGE HEADER ===================== -->
<header class="pl-page-header d-lg-none flex-column gap-2 align-items-stretch">
  <div class="d-flex align-items-center justify-content-between">
    <div class="d-flex align-items-center gap-2">
      <a href="{{ url('/') }}" class="pl-back-btn"><i class="bi bi-arrow-left"></i></a>
      <h1 class="pl-header-title-text" id="mobile-category-title">All Beverage</h1>
    </div>
    <div class="pl-header-icons">
      <button class="pl-icon-btn" style="width:34px;height:34px;border:none;" id="mobile-filter-toggle"><i class="bi bi-sliders"></i></button>
    </div>
  </div>
  <div class="mt-1">
    <div class="pl-search-wrap position-relative d-flex mt-1">
      <span class="pl-search-icon"><i class="bi bi-search"></i></span>
      <input type="search" class="form-control pl-search-input pl-mobile-search" placeholder="Search products, brands..." value="{{ request('search') }}" autocomplete="off">
      <button class="pl-search-btn" type="button" title="Search">
        <i class="bi bi-arrow-right"></i>
      </button>
    </div>
  </div>
</header>

<main class="container-fluid container-lg pl-section">
  <div class="row">

    <!-- ===================== SIDEBAR FILTERS (desktop) ===================== -->
    <aside class="col-lg-3 d-none d-lg-block">
      <form action="{{ url('/shop') }}" method="GET" id="desktop-filter-form">
        @if(request('search'))
          <input type="hidden" name="search" value="{{ request('search') }}">
        @endif
        @if(request('sort_by'))
          <input type="hidden" name="sort_by" value="{{ request('sort_by') }}">
        @endif
        
        <div class="pl-product-card p-3 mb-3">
          <h6 class="fw-bold mb-3">Categories</h6>
          <div class="d-flex flex-column gap-2">
            @foreach($categories as $category)
              <div class="form-check m-0">
                <input class="form-check-input" type="checkbox" name="categories[]" value="{{ $category->id }}" id="cat-{{ $category->id }}"
                       {{ in_array($category->id, $selectedCategories) ? 'checked' : '' }}
                       onchange="document.getElementById('desktop-filter-form').submit()">
                <label class="form-check-label small cursor-pointer" for="cat-{{ $category->id }}">
                  {{ $category->name }}
                </label>
              </div>
            @endforeach
          </div>
        </div>
        
        <div class="pl-product-card p-3">
          <h6 class="fw-bold mb-3">Price Range</h6>
          <input type="range" class="form-range" name="max_price" id="desktop-price-range" min="20" max="2000" value="{{ request('max_price', 2000) }}">
          <div class="d-flex justify-content-between small text-muted mt-1">
            <span>$20</span>
            <span id="desktop-price-max-label">${{ request('max_price', 2000) }}</span>
          </div>
        </div>
      </form>
    </aside>

    <!-- ===================== PRODUCT GRID ===================== -->
    <div class="col-lg-9">
      <div class="pl-filter-bar px-0">
        <span id="pl-product-count">Showing 0 of 0</span>
        <select class="pl-sort-select" id="pl-sort-select">
          <option value="default">Default</option>
          <option value="price-asc">Price: Low to High</option>
          <option value="price-desc">Price: High to Low</option>
        </select>
      </div>

      <div class="row g-3" id="category-products-render">
        @forelse($products as $product)
        <div class="col-6 col-md-4 col-lg-3" data-product>
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
        @empty
        <div class="col-12 py-5 text-center text-muted">
          <i class="bi bi-search fs-2 mb-2 d-block"></i>
          No products match the selected filters.
        </div>
        @endforelse
      </div>
      
      <!-- Infinite Scroll Loader Spinner -->
      <div id="infinite-scroll-loader" class="text-center py-4 col-12 d-none">
        <div class="spinner-border text-success" role="status" style="width: 2.2rem; height: 2.2rem; border-width: 0.22em; color: #C49A6C !important;">
          <span class="visually-hidden">Loading...</span>
        </div>
      </div>

      <div id="pl-pagination-container" class="mt-4">
        {{ $products->links('pagination::bootstrap-5') }}
      </div>
    </div>
  </div>
</main>

@include('frontend.partials.footer')
@include('frontend.partials.mobile_nav')

<!-- ===================== MOBILE FILTER DRAWER ===================== -->
<div class="pl-filter-drawer" id="mobileFilterDrawer">
  <div class="pl-drawer-overlay" id="mobileDrawerOverlay"></div>
  <div class="pl-drawer-content">
    <div class="pl-drawer-handle"></div>
    <div class="pl-drawer-header" style="border-top:none;padding-top:8px;">
      <h5>Filters</h5>
      <button class="pl-close-drawer-btn" id="mobileFilterClose"><i class="bi bi-x-lg"></i></button>
    </div>
    <form action="{{ url('/shop') }}" method="GET" id="mobile-filter-form">
      @if(request('search'))
        <input type="hidden" name="search" value="{{ request('search') }}">
      @endif
      @if(request('sort_by'))
        <input type="hidden" name="sort_by" value="{{ request('sort_by') }}">
      @endif
      
      <div class="pl-drawer-body">
        <div class="pl-filter-section mb-3">
          <h6 class="fw-bold mb-2">Categories</h6>
          <div class="d-flex flex-column gap-2">
            @foreach($categories as $category)
              <div class="form-check m-0">
                <input class="form-check-input" type="checkbox" name="categories[]" value="{{ $category->id }}" id="mob-cat-{{ $category->id }}"
                       {{ in_array($category->id, $selectedCategories) ? 'checked' : '' }}>
                <label class="form-check-label small cursor-pointer" for="mob-cat-{{ $category->id }}">
                  {{ $category->name }}
                </label>
              </div>
            @endforeach
          </div>
        </div>
        <div class="pl-filter-section mb-3">
          <h6 class="fw-bold mb-2">Price Range</h6>
          <input type="range" class="form-range" name="max_price" id="mobile-price-range" min="20" max="2000" value="{{ request('max_price', 2000) }}">
          <div class="d-flex justify-content-between small text-muted mt-1">
            <span>$20</span>
            <span id="mobile-price-max-label">${{ request('max_price', 2000) }}</span>
          </div>
        </div>
        <button type="submit" class="btn btn-pl-primary w-100 py-2 rounded-3" id="mobileFilterApply">Apply Filters</button>
      </div>
    </form>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  window.pl_csrf = '{{ csrf_token() }}';
  window.pl_total_products = {{ $products->total() }};
</script>
<script src="{{ asset('js/script.js?v=2') }}"></script>

<script>
  document.addEventListener("DOMContentLoaded", () => {
      let loading = false;
      let nextPageUrl = '';
      const loader = document.getElementById('infinite-scroll-loader');
      const paginationContainer = document.getElementById('pl-pagination-container');

      const updateNextPageUrl = () => {
          if (!paginationContainer) return;
          const nextLink = paginationContainer.querySelector('a[rel="next"]');
          nextPageUrl = nextLink ? nextLink.href : '';
          paginationContainer.classList.add('d-none');
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
                      headers: {
                          'X-Requested-With': 'XMLHttpRequest'
                      }
                  });
                  if (!res.ok) throw new Error('Response error');
                  
                  const html = await res.text();
                  const parser = new DOMParser();
                  const doc = parser.parseFromString(html, 'text/html');

                  const nextProductsGrid = doc.getElementById('category-products-render');
                  const currentProductsGrid = document.getElementById('category-products-render');
                  
                  if (nextProductsGrid && currentProductsGrid) {
                      const newCards = nextProductsGrid.querySelectorAll('[data-product]');
                      newCards.forEach(card => {
                          currentProductsGrid.appendChild(card);
                      });
                  }

                  const nextPagination = doc.getElementById('pl-pagination-container');
                  if (nextPagination && paginationContainer) {
                      paginationContainer.innerHTML = nextPagination.innerHTML;
                  }

                  updateNextPageUrl();

                  if (!nextPageUrl) {
                      loader.classList.add('d-none');
                  }
              } catch (err) {
                  console.error('Infinite scroll error:', err);
                  loader.classList.add('d-none');
              } finally {
                  loading = false;
              }
          };

          const observer = new IntersectionObserver((entries) => {
              entries.forEach(entry => {
                  if (entry.isIntersecting && !loading && nextPageUrl) {
                      loadNextPage();
                  }
              });
          }, {
              rootMargin: '200px'
          });

          observer.observe(loader);
      }
  });
</script>

</body>
</html>


