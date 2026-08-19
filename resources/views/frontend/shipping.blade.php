@extends('layouts.frontend')

@section('title', 'Shipping & Delivery Policy')

@section('content')
    <!-- Page Header -->
    <div class="bg-[#fdfaf6] py-5 md:py-12 text-center border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <p class="text-[10px] md:text-sm text-gray-500 uppercase tracking-widest leading-relaxed">
                <a href="/" class="hover:text-primary transition">Home</a> / 
                <span class="text-gray-900 font-medium">Shipping Policy</span>
            </p>
            <h1 class="text-2xl sm:text-4xl font-serif font-bold text-gray-900 mt-1 md:mt-2">Shipping & Delivery Policy</h1>
        </div>
    </div>

    <!-- Content Section -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-16">
        <div class="prose max-w-none text-gray-600 leading-relaxed font-sans text-sm sm:text-base space-y-6">
            <p class="text-xs text-gray-400">Last updated: July 8, 2026</p>
            
            <p>
                Welcome to <strong>Pepperlemon LLC</strong>. We are committed to delivering our fresh, high-quality groceries, beverages, and daily essentials safely and efficiently right to your doorstep.
            </p>

            <h2 class="text-xl font-serif font-bold text-gray-900 mt-8 mb-4">1. Shipping Coverage & Locations</h2>
            <p>
                We ship our products across the contiguous United States (lower 48 states). If your delivery address is in Alaska, Hawaii, or a U.S. territory not serviced by standard UPS ground routes, our support team will contact you to arrange an alternative delivery solution.
            </p>

            <h2 class="text-xl font-serif font-bold text-gray-900 mt-8 mb-4">2. Order Processing & Dispatch Time</h2>
            <p>
                All orders are processed and prepared for shipping within <strong>1 to 2 business days</strong> after receiving order confirmation and payment. Orders placed on Sundays or public holidays will be processed on the next working day.
            </p>

            <h2 class="text-xl font-serif font-bold text-gray-900 mt-8 mb-4">3. Delivery Timelines</h2>
            <p>
                Our standard delivery timeline once dispatched is:
            </p>
            <ul class="list-disc pl-6 space-y-2">
                <li><strong>Standard (UPS Ground):</strong> 3 to 7 business days.</li>
                <li><strong>Expedited (UPS 3 Day Select):</strong> 3 business days.</li>
                <li><strong>Expedited (UPS 2nd Day Air):</strong> 2 business days.</li>
                <li><strong>Overnight (UPS Next Day Air):</strong> 1 business day.</li>
                <li><strong>Remote or Rural Areas:</strong> May take up to 10 business days.</li>
            </ul>
            <p>
                *Note: Delivery times may be affected by bad weather, holidays, or administrative disruptions beyond our control.
            </p>

            <h2 class="text-xl font-serif font-bold text-gray-900 mt-8 mb-4">4. Shipping & Delivery Charges</h2>
            <p>
                Shipping rates are calculated based on weight, dimensions, and the destination of the package. Any applicable shipping fees will be clearly displayed in your cart and summarized at the checkout screen before you finalize your payment.
            </p>

            <h2 class="text-xl font-serif font-bold text-gray-900 mt-8 mb-4">5. Shipment Tracking</h2>
            <p>
                Once your order has been dispatched, we will send you a shipment confirmation email or SMS containing a **Tracking Number** and a link to trace your package online. You can use this to monitor the status and estimated delivery time of your package.
            </p>

            <h2 class="text-xl font-serif font-bold text-gray-900 mt-8 mb-4">6. Lost or Damaged Shipments</h2>
            <p>
                In the rare event that a package is lost in transit or is delivered in a heavily damaged state, please contact us immediately at <strong>{{ \App\Models\Setting::get('site_email', 'Papperlemon1@gmail.com') }}</strong>. We will work with the logistics partner to resolve the issue or dispatch a replacement order to you as soon as possible.
            </p>

            <h2 class="text-xl font-serif font-bold text-gray-900 mt-8 mb-4">7. Contact Information</h2>
            <p>
                If you have any questions or queries regarding the shipping of your products, please reach out to us:
            </p>
            <ul class="list-disc pl-6 space-y-2 mt-2">
                <li><strong>Brand Name:</strong> {{ \App\Models\Setting::get('site_name', 'Pepperlemon LLC') }}</li>
                <li><strong>Email:</strong> {{ \App\Models\Setting::get('site_email', 'Papperlemon1@gmail.com') }}</li>
                <li><strong>Address:</strong> {{ \App\Models\Setting::get('site_address', '12800 Northborough Dr, Houston, TX 77067') }}</li>
            </ul>
        </div>
    </div>
@endsection

