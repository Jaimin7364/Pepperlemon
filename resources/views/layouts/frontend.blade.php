<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('meta_title', 'Pepperlemon - Premium Online Grocery & Beverage Shop')</title>
    <meta name="description" content="@yield('meta_description', 'Discover premium organic groceries, beverages, candies, and gourmet snacks at Pepperlemon. Enjoy fast express delivery and secure online checkout.')">
    <meta name="keywords" content="@yield('meta_keywords', 'pepperlemon, online grocery store, organic food delivery, buy beverages online, gourmet snacks, candy store')">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('meta_title', 'Pepperlemon - Premium Online Grocery & Beverage Shop')">
    <meta property="og:description" content="@yield('meta_description', 'Discover premium organic groceries, beverages, candies, and gourmet snacks at Pepperlemon. Enjoy fast express delivery and secure online checkout.')">
    <meta property="og:image" content="@yield('meta_image', asset('images/logo.jpeg'))">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{ url()->current() }}">
    <meta name="twitter:title" content="@yield('meta_title', 'Pepperlemon - Premium Online Grocery & Beverage Shop')">
    <meta name="twitter:description" content="@yield('meta_description', 'Discover premium organic groceries, beverages, candies, and gourmet snacks at Pepperlemon. Enjoy fast express delivery and secure online checkout.')">
    <meta name="twitter:image" content="@yield('meta_image', asset('images/logo.jpeg'))">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <!-- Bootstrap 5 & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800;900&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css?v=6') }}">

    <!-- Vite Tailwind Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; color: #000000; }
        a { text-decoration: none; }
    </style>
</head>
<body class="font-sans antialiased text-black bg-white" x-data="{ mobileMenuOpen: false }">
    
    @include('frontend.partials.header')

    <!-- Main Content -->
    <main class="container my-4 min-vh-100 pb-5">
        @if (session('success') || session('error') || session('warning') || session('status'))
            <div class="mb-4">
                @if (session('success'))
                    <div class="alert alert-success border-0 rounded-3 shadow-sm d-flex align-items-center justify-content-between">
                        <span>{{ session('success') }}</span>
                        <button onclick="this.parentElement.remove()" class="btn-close" type="button"></button>
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger border-0 rounded-3 shadow-sm d-flex align-items-center justify-content-between">
                        <span>{{ session('error') }}</span>
                        <button onclick="this.parentElement.remove()" class="btn-close" type="button"></button>
                    </div>
                @endif
                @if (session('warning'))
                    <div class="alert alert-warning border-0 rounded-3 shadow-sm d-flex align-items-center justify-content-between">
                        <span>{{ session('warning') }}</span>
                        <button onclick="this.parentElement.remove()" class="btn-close" type="button"></button>
                    </div>
                @endif
                @if (session('status'))
                    <div class="alert alert-info border-0 rounded-3 shadow-sm d-flex align-items-center justify-content-between">
                        <span>{{ session('status') }}</span>
                        <button onclick="this.parentElement.remove()" class="btn-close" type="button"></button>
                    </div>
                @endif
            </div>
        @endif

        @yield('content')
    </main>

    @include('frontend.partials.footer')
    @include('frontend.partials.mobile_nav')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
      window.pl_csrf = '{{ csrf_token() }}';
    </script>
    <script src="{{ asset('js/script.js?v=3') }}"></script>
    
    <!-- Quick View Modal -->
    <div id="quickview-modal" class="fixed inset-0 z-50 hidden bg-black/60 backdrop-blur-sm flex items-center justify-center p-4 transition-opacity duration-300 opacity-0">
        <div class="bg-white rounded-2xl max-w-4xl w-full overflow-hidden shadow-2xl relative border border-gray-100 flex flex-col md:flex-row transform scale-95 transition-transform duration-300">
            <!-- Close Button -->
            <button id="close-quickview" class="absolute top-4 right-4 text-gray-400 hover:text-gray-900 transition-colors z-20 h-10 w-10 flex items-center justify-center rounded-full bg-gray-50 hover:bg-gray-100"><i class="fa-solid fa-xmark text-lg"></i></button>
            
            <!-- Modal Body Image -->
            <div class="w-full md:w-1/2 bg-gray-50 flex items-center justify-center p-8 relative">
                <img id="qv-image" src="" alt="" class="max-h-80 object-contain">
                <span id="qv-sale-badge" class="absolute top-4 left-4 bg-red-500 text-white text-[10px] uppercase font-bold px-2 py-1 rounded hidden">Sale</span>
            </div>
            
            <!-- Modal Body Content -->
            <div class="w-full md:w-1/2 p-8 flex flex-col justify-center">
                <p id="qv-category" class="text-xs text-primary uppercase font-bold tracking-widest mb-1"></p>
                <h2 id="qv-name" class="text-2xl font-serif font-bold text-gray-900 mb-3"></h2>
                
                <div class="mb-4">
                    <span id="qv-price-del" class="text-lg text-gray-400 line-through mr-3 hidden"></span>
                    <span id="qv-price" class="text-2xl font-bold text-primary"></span>
                </div>
                
                <p id="qv-description" class="text-gray-500 text-sm mb-6 leading-relaxed"></p>
                
                <div class="flex flex-col sm:flex-row gap-4 mb-6">
                    <div class="flex items-center border border-gray-200 rounded">
                        <button type="button" id="qv-qty-minus" class="w-10 h-10 text-gray-600 hover:bg-gray-100 transition"><i class="fa-solid fa-minus text-xs"></i></button>
                        <input type="number" id="qv-qty-input" class="w-12 h-10 text-center border-none focus:ring-0 text-sm text-gray-900" value="1" min="1">
                        <button type="button" id="qv-qty-plus" class="w-10 h-10 text-gray-600 hover:bg-gray-100 transition"><i class="fa-solid fa-plus text-xs"></i></button>
                    </div>
                    
                    <button id="qv-add-cart-btn" class="flex-1 bg-primary hover:bg-primary-dark text-white font-bold py-3 px-6 rounded-lg text-xs uppercase tracking-wider transition-colors shadow-md flex items-center justify-center gap-2 cursor-pointer">
                        <i class="fa-solid fa-cart-shopping"></i> Add to Cart
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Notification -->
    <div id="toast" class="fixed bottom-6 right-6 z-50 bg-gray-900 text-white px-5 py-3 rounded-xl shadow-2xl flex items-center space-x-3 transition-all duration-300 transform translate-y-20 opacity-0 border border-gray-800">
        <i class="fa-solid fa-circle-check text-primary text-lg"></i>
        <span id="toast-message" class="text-xs font-medium"></span>
    </div>

    @stack('scripts')
</body>
</html>
