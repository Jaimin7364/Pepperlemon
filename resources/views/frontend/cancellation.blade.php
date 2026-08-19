@extends('layouts.frontend')

@section('title', 'Cancellation Policy')

@section('content')
    <!-- Page Header -->
    <div class="bg-[#fdfaf6] py-5 md:py-12 text-center border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <p class="text-[10px] md:text-sm text-gray-500 uppercase tracking-widest leading-relaxed">
                <a href="/" class="hover:text-primary transition">Home</a> / 
                <span class="text-gray-900 font-medium">Cancellation Policy</span>
            </p>
            <h1 class="text-2xl sm:text-4xl font-serif font-bold text-gray-900 mt-1 md:mt-2">Cancellation Policy</h1>
        </div>
    </div>

    <!-- Content Section -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-16">
        <div class="prose max-w-none text-gray-600 leading-relaxed font-sans text-sm sm:text-base space-y-6">
            <p class="text-xs text-gray-400">Last updated: July 8, 2026</p>
            
            <p>
                At <strong>Pepperlemon LLC</strong>, we understand that you may sometimes need to cancel an order. We have a simple cancellation process designed to be as fair and convenient as possible.
            </p>

            <h2 class="text-xl font-serif font-bold text-gray-900 mt-8 mb-4">1. Cancellation Timeline</h2>
            <p>
                You can cancel your order at any time **before it has been shipped or dispatched**. 
            </p>
            <p>
                We usually process and ship orders within <strong>24 to 48 hours</strong> of order placement. Therefore, if you wish to cancel, please notify us as quickly as possible. Once the order has been dispatched from our facility and a tracking number has been generated, the order **cannot be cancelled**.
            </p>

            <h2 class="text-xl font-serif font-bold text-gray-900 mt-8 mb-4">2. How to Request a Cancellation</h2>
            <p>
                To cancel your order:
            </p>
            <ul class="list-disc pl-6 space-y-2">
                <li>Send an urgent email to <strong>{{ \App\Models\Setting::get('site_email', 'Papperlemon1@gmail.com') }}</strong> OR call our support team.</li>
                <li>Provide your **Order Number** and the reason for cancellation in your message.</li>
            </ul>

            <h2 class="text-xl font-serif font-bold text-gray-900 mt-8 mb-4">3. Refunds for Cancelled Orders</h2>
            <p>
                If your order is cancelled successfully before dispatch:
            </p>
            <ul class="list-disc pl-6 space-y-2">
                <li>We will cancel the order in our system and initiate a full refund.</li>
                <li>The refund will be credited back to your original payment method (Credit/Debit Card, Net Banking, UPI, or Wallet) via our secure gateway, <strong>Razorpay</strong>.</li>
                <li>You will receive a confirmation email once the cancellation is approved and the refund is initiated.</li>
            </ul>

            <h2 class="text-xl font-serif font-bold text-gray-900 mt-8 mb-4">4. Refund Processing Duration</h2>
            <p>
                Refunds for cancelled orders follow the standard gateway timeline. The amount will typically reflect in your account within <strong>5 to 7 business days</strong> of the cancellation confirmation.
            </p>

            <h2 class="text-xl font-serif font-bold text-gray-900 mt-8 mb-4">5. Post-Dispatch Cancellation (Refusal of Delivery)</h2>
            <p>
                If the order has already been shipped and you refuse delivery from our courier partner, a refund will be processed only after the package is returned back to our warehouse. In such cases, we reserve the right to deduct any shipping charges incurred for sending the package and its return-to-origin (RTO) from the final refund amount.
            </p>

            <h2 class="text-xl font-serif font-bold text-gray-900 mt-8 mb-4">6. Contact Information</h2>
            <p>
                For immediate help with order cancellation, please reach out to us:
            </p>
            <ul class="list-disc pl-6 space-y-2 mt-2">
                <li><strong>Brand Name:</strong> {{ \App\Models\Setting::get('site_name', 'Pepperlemon LLC') }}</li>
                <li><strong>Email:</strong> {{ \App\Models\Setting::get('site_email', 'Papperlemon1@gmail.com') }}</li>
                <li><strong>Address:</strong> {{ \App\Models\Setting::get('site_address', '12800 Northborough Dr, Houston, TX 77067') }}</li>
            </ul>
        </div>
    </div>
@endsection

