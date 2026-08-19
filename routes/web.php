<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\CustomerOrderController;
use App\Http\Controllers\AddressController;
use Illuminate\Support\Facades\Route;

// Admin controllers
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\TestimonialController as AdminTestimonialController;
use App\Http\Controllers\Admin\CouponController as AdminCouponController;
use App\Http\Controllers\Admin\UserController as AdminUserController;

Route::get('/', [FrontendController::class, 'home'])->name('home');
Route::get('/about', [FrontendController::class, 'about'])->name('about');
Route::get('/shop', [FrontendController::class, 'shop'])->name('shop');
Route::get('/product/{slug}', [FrontendController::class, 'product'])->name('product.show');
Route::get('/contact', [FrontendController::class, 'contact'])->name('contact');

// Policy Pages (Razorpay compliant)
Route::get('/terms-and-conditions', [FrontendController::class, 'terms'])->name('terms');
Route::get('/privacy-policy', [FrontendController::class, 'privacy'])->name('privacy');
Route::get('/refund-policy', [FrontendController::class, 'refund'])->name('refund');
Route::get('/cancellation-policy', [FrontendController::class, 'cancellation'])->name('cancellation');
Route::get('/shipping-policy', [FrontendController::class, 'shipping'])->name('shipping');

// API/Ajax Routes for Cart, Wishlist, and Quick View
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/cart/count', [CartController::class, 'count'])->name('cart.count');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');

// Checkout Routes (require login)
Route::middleware('auth')->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/stripe-callback', [CheckoutController::class, 'handleStripeCallback'])->name('checkout.stripe.callback');
    Route::get('/checkout/cancel-payment', [CheckoutController::class, 'cancelStripePayment'])->name('checkout.stripe.cancel');
    Route::get('/order-success/{order_number}', [CheckoutController::class, 'success'])->name('checkout.success');
    
    // Customer Orders & Returns
    Route::get('/orders', [CustomerOrderController::class, 'index'])->name('orders.index');
    Route::post('/orders/{order}/return', [CustomerOrderController::class, 'requestReturn'])->name('orders.return');
});

Route::post('/wishlist/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
Route::get('/wishlist/count', [WishlistController::class, 'count'])->name('wishlist.count');
Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');

Route::get('/api/product/{slug}', [FrontendController::class, 'apiProductDetails'])->name('api.product.details');

Route::get('/dashboard', function () {
    $orders = App\Models\Order::where('user_id', auth()->id())->with('items')->latest()->get();
    return view('dashboard', compact('orders'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Addresses
    Route::get('/addresses', [AddressController::class, 'index'])->name('addresses.index');
    Route::post('/addresses', [AddressController::class, 'store'])->name('addresses.store');
    Route::patch('/addresses/{address}/default', [AddressController::class, 'setDefault'])->name('addresses.setDefault');
    Route::delete('/addresses/{address}', [AddressController::class, 'destroy'])->name('addresses.destroy');
});

Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);


// Custom Admin Panel routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::resource('products', AdminProductController::class);
    Route::resource('categories', AdminCategoryController::class);
    Route::resource('testimonials', AdminTestimonialController::class);
    Route::resource('coupons', AdminCouponController::class);
    
    // Orders
    Route::get('orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::patch('orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');

    // Users / Customers
    Route::get('users', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('users/{user}', [AdminUserController::class, 'show'])->name('users.show');
    Route::patch('users/{user}/toggle-status', [AdminUserController::class, 'toggleStatus'])->name('users.toggleStatus');

    // Settings
    Route::get('settings', [AdminController::class, 'settings'])->name('settings.edit');
    Route::post('settings', [AdminController::class, 'updateSettings'])->name('settings.update');
});

require __DIR__.'/auth.php';

// Stripe Webhook — excluded from CSRF and auth middleware
Route::withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class])->post(
    '/webhook/stripe',
    [CheckoutController::class, 'stripeWebhook']
)->name('webhook.stripe');
