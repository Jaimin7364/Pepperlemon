@extends('layouts.frontend')

@section('title', 'Terms & Conditions')

@section('content')
    <!-- Page Header -->
    <div class="bg-[#fdfaf6] py-5 md:py-12 text-center border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <p class="text-[10px] md:text-sm text-gray-500 uppercase tracking-widest leading-relaxed">
                <a href="/" class="hover:text-primary transition">Home</a> / 
                <span class="text-gray-900 font-medium">Terms & Conditions</span>
            </p>
            <h1 class="text-2xl sm:text-4xl font-serif font-bold text-gray-900 mt-1 md:mt-2">Terms & Conditions</h1>
        </div>
    </div>

    <!-- Content Section -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-16">
        <div class="prose max-w-none text-gray-600 leading-relaxed font-sans text-sm sm:text-base space-y-6">
            <p class="text-xs text-gray-400">Last updated: July 8, 2026</p>
            
            <p>
                Welcome to <strong>Pepperlemon LLC</strong>. By accessing or using our website, ordering our products, or utilizing any of our services, you agree to comply with and be bound by the following terms and conditions. Please read them carefully.
            </p>

            <h2 class="text-xl font-serif font-bold text-gray-900 mt-8 mb-4">1. General Conditions</h2>
            <p>
                By agreeing to these Terms, you represent that you are at least the age of majority in your state or province of residence. You may not use our products for any illegal or unauthorized purpose, nor may you violate any laws in your jurisdiction (including but not limited to copyright laws). We reserve the right to refuse service to anyone for any reason at any time.
            </p>

            <h2 class="text-xl font-serif font-bold text-gray-900 mt-8 mb-4">2. Accuracy, Completeness, and Timeliness of Information</h2>
            <p>
                We strive to ensure that all information on this website is accurate and up-to-date. However, we are not responsible if information made available on this site is not accurate, complete, or current. The material on this site is provided for general information only and should not be relied upon or used as the sole basis for making decisions. Any reliance on the material on this site is at your own risk.
            </p>

            <h2 class="text-xl font-serif font-bold text-gray-900 mt-8 mb-4">3. Products and Pricing</h2>
            <p>
                Prices for our products (including fresh produce, snacks, beverages, chocolates, and household grocery items) are subject to change without notice. We reserve the right at any time to modify or discontinue any product or service without notice. We shall not be liable to you or to any third party for any modification, price change, suspension, or discontinuance of products.
            </p>

            <h2 class="text-xl font-serif font-bold text-gray-900 mt-8 mb-4">4. Billing and Payment Information</h2>
            <p>
                We reserve the right to refuse any order you place with us. In the event that we make a change to or cancel an order, we may attempt to notify you by contacting the email and/or billing address/phone number provided at the time the order was made. 
            </p>
            <p>
                All online payments on our website are processed securely. We utilize <strong>Stripe</strong> as our primary payment gateway provider. By choosing to pay online, you agree to abide by Stripe's terms of service and authorization protocols. We do not store your credit/debit card credentials on our servers.
            </p>

            <h2 class="text-xl font-serif font-bold text-gray-900 mt-8 mb-4">5. Accuracy of Account Information</h2>
            <p>
                You agree to provide current, complete, and accurate purchase and account information for all purchases made at our store. You agree to promptly update your account and other information, including your email address and payment details, so that we can complete your transactions and contact you as needed.
            </p>

            <h2 class="text-xl font-serif font-bold text-gray-900 mt-8 mb-4">6. Third-Party Links</h2>
            <p>
                Certain content, products, and services available via our website may include materials from third parties. Third-party links on this site may direct you to third-party websites that are not affiliated with us. We are not responsible for examining or evaluating the content or accuracy and we do not warrant and will not have any liability or responsibility for any third-party materials or websites.
            </p>

            <h2 class="text-xl font-serif font-bold text-gray-900 mt-8 mb-4">7. Intellectual Property</h2>
            <p>
                All content included on this site, such as text, graphics, logos, button icons, images, audio clips, digital downloads, and data compilations, is the property of <strong>Pepperlemon LLC</strong> or its content suppliers and is protected by international copyright laws.
            </p>

            <h2 class="text-xl font-serif font-bold text-gray-900 mt-8 mb-4">8. Governing Law and Jurisdiction</h2>
            <p>
                These Terms of Service and any separate agreements whereby we provide you services or products shall be governed by and construed in accordance with the laws of the State of Texas, United States, and any disputes shall be subject to the exclusive jurisdiction of the state and federal courts located in <strong>Houston, Texas, USA</strong>.
            </p>

            <h2 class="text-xl font-serif font-bold text-gray-900 mt-8 mb-4">9. Contact Information</h2>
            <p>
                Questions about the Terms and Conditions should be sent to us at:
            </p>
            <ul class="list-disc pl-6 space-y-2 mt-2">
                <li><strong>Brand Name:</strong> {{ \App\Models\Setting::get('site_name', 'Pepperlemon LLC') }}</li>
                <li><strong>Email:</strong> {{ \App\Models\Setting::get('site_email', 'Papperlemon1@gmail.com') }}</li>
                <li><strong>Address:</strong> {{ \App\Models\Setting::get('site_address', '12800 Northborough Dr, Houston, TX 77067') }}</li>
            </ul>
        </div>
    </div>
@endsection

