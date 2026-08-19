/* ============================================================
   Pepperlemon Web App — Shared Behaviour (AJAX Version)
   ============================================================ */

const PL = {
  updateCartBadges(count){
    document.querySelectorAll("[data-cart-badge]").forEach(el=>{
      el.textContent = count;
      el.style.display = count > 0 ? "flex" : "none";
    });
  },

  updateWishlistBadges(count){
    document.querySelectorAll("[data-wishlist-badge]").forEach(el=>{
      el.textContent = count;
      el.style.display = count > 0 ? "flex" : "none";
    });
  },

  async toggleWishlist(id) {
    try {
      const res = await fetch('/wishlist/toggle', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': window.pl_csrf
        },
        body: JSON.stringify({ product_id: id })
      });
      const data = await res.json();
      if (data.success) {
        this.updateWishlistBadges(data.wishlist_count);
        this.showToast(`<i class="bi bi-heart-fill me-2" style="color: #e63946; font-size: 1.05rem; vertical-align: middle;"></i> ${data.message}`);
        
        // Update all wishlist buttons in the current document for this product ID
        document.querySelectorAll(`[data-wishlist-product-id="${id}"]`).forEach(btn => {
          const icon = btn.querySelector('i');
          if (icon) {
            if (data.in_wishlist) {
              icon.className = 'bi bi-heart-fill text-danger';
            } else {
              icon.className = 'bi bi-heart';
            }
          }
        });
      } else {
        this.showToast(data.message || 'Something went wrong.');
      }
    } catch(e) {
      console.error(e);
      this.showToast("Failed to update wishlist");
    }
  },

  showToast(msg){
    let toast = document.querySelector(".pl-toast");
    if(!toast){
      toast = document.createElement("div");
      toast.className = "pl-toast";
      document.body.appendChild(toast);
    }
    toast.innerHTML = msg;
    toast.classList.add("show");
    clearTimeout(this._toastTimer);
    this._toastTimer = setTimeout(()=> toast.classList.remove("show"), 1800);
  },

  async addToCartById(id, qty) {
    try {
      // Always read current qty from DOM if on product page
      var detailQty = document.getElementById('pl-detail-qty');
      var stickyQty = document.getElementById('pl-sticky-qty');
      if (detailQty || stickyQty) {
        qty = parseInt((detailQty || stickyQty).textContent, 10) || 1;
      } else if (!qty || qty < 1) {
        qty = 1;
      }

      const res = await fetch('/cart/add', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': window.pl_csrf
        },
        body: JSON.stringify({ product_id: id, quantity: qty })
      });
      const data = await res.json();
      if (data.success) {
        this.updateCartBadges(data.cart_count);
        this.showToast(`<i class="bi bi-cart-check-fill me-2" style="color: #2ec4b6; font-size: 1.05rem; vertical-align: middle;"></i> ${data.message}`);
      } else {
        this.showToast(data.message);
      }
    } catch(e) {
      console.error(e);
      this.showToast("Failed to add to cart");
    }
  },

  async buyNow(id) {
    try {
      // Always read current qty from DOM
      var detailQty = document.getElementById('pl-detail-qty');
      var stickyQty = document.getElementById('pl-sticky-qty');
      var qty = parseInt((detailQty || stickyQty || {textContent: '1'}).textContent, 10) || 1;

      const res = await fetch('/cart/add', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': window.pl_csrf
        },
        body: JSON.stringify({ product_id: id, quantity: qty })
      });
      const data = await res.json();
      if (data.success) {
        window.location.href = '/cart';
      } else {
        this.showToast(data.message);
      }
    } catch(e) {
      console.error(e);
      this.showToast("Failed to process. Try again.");
    }
  },

  async removeFromCart(id){
    try {
      const res = await fetch('/cart/remove', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': window.pl_csrf
        },
        body: JSON.stringify({ product_id: id })
      });
      const data = await res.json();
      if (data.success) {
        window.location.reload(); // Reload cart page to reflect changes
      }
    } catch(e) {
      console.error(e);
    }
  },

  async setQty(id, qty){
    if (qty < 1) {
      return this.removeFromCart(id);
    }
    try {
      const res = await fetch('/cart/update', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': window.pl_csrf
        },
        body: JSON.stringify({ product_id: id, quantity: qty })
      });
      const data = await res.json();
      if (data.success) {
        window.location.reload(); // Reload cart page to reflect changes
      }
    } catch(e) {
      console.error(e);
    }
  },

  /* Horizontal scroll helper */
  initScrollArrows() {
    document.querySelectorAll("[data-scroll-target]").forEach(controls => {
      const targetId = controls.dataset.scrollTarget;
      const target = document.getElementById(targetId);
      if (!target) return;
      const prev = controls.querySelector(".scroll-prev");
      const next = controls.querySelector(".scroll-next");
      if (prev && next) {
        prev.addEventListener("click", () => {
          target.scrollBy({ left: -240, behavior: "smooth" });
        });
        next.addEventListener("click", () => {
          target.scrollBy({ left: 240, behavior: "smooth" });
        });
      }
    });
  },

  /* Setup Global Search & Mobile Filters Event Listeners */
  initSearchAndFilters() {
    const handleSearchSubmit = (query) => {
      const q = query.trim();
      if (!q) return; // ignore empty searches
      const url = new URL(window.location.href);
      url.searchParams.set('search', q);
      // Remove page param so we always start from page 1
      url.searchParams.delete('page');
      // If we are not on shop page, go to shop page
      if (!window.location.pathname.includes('/shop')) {
        window.location.href = `/shop?search=${encodeURIComponent(q)}`;
      } else {
        window.location.href = url.toString();
      }
    };

    // Restore search value from URL on page load
    const urlSearch = new URLSearchParams(window.location.search).get('search') || '';
    document.querySelectorAll(".pl-search-input").forEach(input => {
      if (urlSearch) input.value = urlSearch;

      // Enter key submits
      input.addEventListener("keydown", (e) => {
        if (e.key === "Enter") {
          e.preventDefault();
          handleSearchSubmit(input.value);
        }
      });

      // Clear search (x button on type=search)
      input.addEventListener("search", (e) => {
        if (!e.target.value) {
          const url = new URL(window.location.href);
          url.searchParams.delete('search');
          url.searchParams.delete('page');
          window.location.href = url.toString();
        }
      });
    });

    // Search icon button click (for buttons next to the input)
    document.querySelectorAll(".pl-search-btn").forEach(btn => {
      btn.addEventListener("click", () => {
        const input = btn.closest('.pl-search-wrap')?.querySelector('.pl-search-input')
                     || document.querySelector('.pl-search-input');
        if (input) handleSearchSubmit(input.value);
      });
    });

    // Handle Shop Page specific JS (Dropdowns, Sliders)
    if (document.getElementById("category-products-render")) {
      const urlParams = new URLSearchParams(window.location.search);
      
      // Update price range value on load
      const maxPrice = urlParams.get('max_price') || 2000;
      const desktopRange = document.getElementById("desktop-price-range");
      const mobileRange = document.getElementById("mobile-price-range");
      
      if (desktopRange) {
        desktopRange.value = maxPrice;
        document.getElementById("desktop-price-max-label").textContent = `₹${maxPrice}`;
        desktopRange.addEventListener("change", (e) => {
          const url = new URL(window.location.href);
          url.searchParams.set('max_price', e.target.value);
          window.location.href = url.toString();
        });
        desktopRange.addEventListener("input", (e) => {
          document.getElementById("desktop-price-max-label").textContent = `₹${e.target.value}`;
        });
      }

      if (mobileRange) {
        mobileRange.value = maxPrice;
        document.getElementById("mobile-price-max-label").textContent = `₹${maxPrice}`;
        mobileRange.addEventListener("input", (e) => {
          document.getElementById("mobile-price-max-label").textContent = `₹${e.target.value}`;
        });
      }

      const sortSelect = document.getElementById("pl-sort-select");
      if (sortSelect) {
        sortSelect.value = urlParams.get('sort_by') || 'default';
        sortSelect.addEventListener("change", (e) => {
          const url = new URL(window.location.href);
          url.searchParams.set('sort_by', e.target.value);
          window.location.href = url.toString();
        });
      }
      
      if (document.getElementById("pl-product-count") && typeof window.pl_total_products !== 'undefined') {
        document.getElementById("pl-product-count").textContent = `Showing ${window.pl_total_products} products`;
      }

      // Mobile filter drawer toggles
      const mobileToggle = document.getElementById("mobile-filter-toggle");
      const drawer = document.getElementById("mobileFilterDrawer");
      const overlay = document.getElementById("mobileDrawerOverlay");
      const closeBtn = document.getElementById("mobileFilterClose");
      const applyBtn = document.getElementById("mobileFilterApply");

      if (mobileToggle && drawer) {
        mobileToggle.addEventListener("click", () => drawer.classList.add("open"));
      }

      const closeDrawer = () => { if (drawer) drawer.classList.remove("open"); };
      if (overlay) overlay.addEventListener("click", closeDrawer);
      if (closeBtn) closeBtn.addEventListener("click", closeDrawer);

      // Form submit handles mobile filters natively now
    }
  },

  /* Show sticky bottom bar on scroll for product page on mobile */
  initStickyProductBarScroll() {
    const stickyBar = document.getElementById("plMobileStickyBar");
    const addBtn = document.getElementById("pl-add-to-cart-btn");
    if (!stickyBar || !addBtn) return;

    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (!entry.isIntersecting) {
          stickyBar.classList.add("visible");
        } else {
          stickyBar.classList.remove("visible");
        }
      });
    }, { threshold: 0.1 });

    observer.observe(addBtn);
  },

  /* Product details thumbnail click */
  initProductGallery() {
    const thumbsWrap = document.getElementById("pl-thumbnails-wrap");
    const mainImg = document.getElementById("pl-main-image");
    if (thumbsWrap && mainImg) {
      thumbsWrap.querySelectorAll(".pl-detail-thumbnail").forEach(thumb => {
        thumb.addEventListener("click", () => {
          thumbsWrap.querySelectorAll(".pl-detail-thumbnail").forEach(t => t.classList.remove("active"));
          thumb.classList.add("active");
          mainImg.src = thumb.querySelector("img").src;
        });
      });
    }
  },

  /* ---- Simple accordion (product description) ---- */
  initAccordions(){
    document.querySelectorAll(".pl-accordion-btn").forEach(btn=>{
      // Remove any previously added listeners to avoid double-firing
      const newBtn = btn.cloneNode(true);
      btn.parentNode.replaceChild(newBtn, btn);

      newBtn.addEventListener("click", ()=>{
        const panel = document.getElementById(newBtn.getAttribute("aria-controls"));
        const expanded = newBtn.getAttribute("aria-expanded") === "true";
        newBtn.setAttribute("aria-expanded", String(!expanded));
        panel.style.maxHeight = expanded ? "0px" : panel.scrollHeight + "px";
        panel.classList.toggle("show", !expanded);
      });
    });
  },

  init(){
    this.initScrollArrows();
    this.initSearchAndFilters();
    this.initStickyProductBarScroll();
    this.initProductGallery();
    this.initAccordions();
    
    // Product page steppers are handled inline in product.blade.php
    // to ensure synced behaviour between detail and sticky steppers
  }
};

document.addEventListener("DOMContentLoaded", ()=> PL.init());
