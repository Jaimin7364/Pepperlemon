@extends('layouts.frontend')

@section('title', 'Privacy Policy')

@section('content')
    <!-- Page Header -->
    <div class="bg-[#fdfaf6] py-5 md:py-12 text-center border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <p class="text-[10px] md:text-sm text-gray-500 uppercase tracking-widest leading-relaxed">
                <a href="/" class="hover:text-primary transition">Home</a> / 
                <span class="text-gray-900 font-medium">Privacy Policy</span>
            </p>
            <h1 class="text-2xl sm:text-4xl font-serif font-bold text-gray-900 mt-1 md:mt-2">Privacy Policy</h1>
        </div>
    </div>

    <!-- Content Section -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-16">
        <div class="prose max-w-none text-gray-600 leading-relaxed font-sans text-sm sm:text-base space-y-6">
            <p class="text-xs text-gray-400">Last updated: July 8, 2026</p>
            
            <p>
                At <strong>Pepperlemon LLC</strong>, one of our main priorities is the privacy of our visitors. This Privacy Policy document contains types of information that are collected and recorded by Pepperlemon LLC and how we use it.
            </p>
            <p>
                If you have additional questions or require more information about our Privacy Policy, do not hesitate to contact us.
            </p>

            <h2 class="text-xl font-serif font-bold text-gray-900 mt-8 mb-4">1. Consent</h2>
            <p>
                By using our website, you hereby consent to our Privacy Policy and agree to its terms.
            </p>

            <h2 class="text-xl font-serif font-bold text-gray-900 mt-8 mb-4">2. Information We Collect</h2>
            <p>
                The personal information that you are asked to provide, and the reasons why you are asked to provide it, will be made clear to you at the point we ask you to provide your personal information.
            </p>
            <p>
                If you register for an account or purchase products from us, we may ask for your contact information, including items such as:
            </p>
            <ul class="list-disc pl-6 space-y-2">
                <li>Name / Business Name</li>
                <li>Shipping Address and Billing Address</li>
                <li>Email Address</li>
                <li>Telephone/Mobile Number</li>
            </ul>
            <p>
                When you make a payment on our website, the transaction details are handled by our secure payment gateway partner, <strong>Stripe</strong>. We do not store or collect your payment card details on our website servers. Stripe processes your payment data in compliance with PCI-DSS standards.
            </p>

            <h2 class="text-xl font-serif font-bold text-gray-900 mt-8 mb-4">3. How We Use Your Information</h2>
            <p>
                We use the information we collect in various ways, including to:
            </p>
            <ul class="list-disc pl-6 space-y-2">
                <li>Provide, operate, and maintain our website.</li>
                <li>Improve, personalize, and expand our website offerings.</li>
                <li>Understand and analyze how you use our website.</li>
                <li>Process your transactions, arrange shipments, and send invoice confirmations.</li>
                <li>Communicate with you, either directly or through one of our partners, including for customer service, to provide you with updates and other information relating to the website.</li>
                <li>Send you emails regarding order status, tracking, and promotional notifications (with your consent).</li>
                <li>Find and prevent fraud.</li>
            </ul>

            <h2 class="text-xl font-serif font-bold text-gray-900 mt-8 mb-4">4. Log Files</h2>
            <p>
                Pepperlemon LLC follows a standard procedure of using log files. These files log visitors when they visit websites. The information collected by log files includes internet protocol (IP) addresses, browser type, Internet Service Provider (ISP), date and time stamp, referring/exit pages, and possibly the number of clicks. These are not linked to any information that is personally identifiable. The purpose of the information is for analyzing trends, administering the site, tracking users' movement on the website, and gathering demographic information.
            </p>

            <h2 class="text-xl font-serif font-bold text-gray-900 mt-8 mb-4">5. Cookies and Web Beacons</h2>
            <p>
                Like any other website, Pepperlemon LLC uses "cookies". These cookies are used to store information including visitors' preferences, and the pages on the website that the visitor accessed or visited. The information is used to optimize the users' experience by customizing our web page content based on visitors' browser type and/or other information.
            </p>

            <h2 class="text-xl font-serif font-bold text-gray-900 mt-8 mb-4">6. Third-Party Privacy Policies</h2>
            <p>
                Pepperlemon LLC's Privacy Policy does not apply to other advertisers or websites. Thus, we are advising you to consult the respective Privacy Policies of these third-party servers for more detailed information. It may include their practices and instructions about how to opt-out of certain options. 
            </p>
            <p>
                Our payment gateway partner, <strong>Stripe</strong>, acts as an independent controller of your payment data. You can read their privacy policy at stripe.com/privacy to understand how they handle transaction data.
            </p>

            <h2 class="text-xl font-serif font-bold text-gray-900 mt-8 mb-4">7. Your Privacy Rights (CCPA / US Privacy Law)</h2>
            <p>
                We would like to make sure you are fully aware of all of your data protection rights. Every user is entitled to the following:
            </p>
            <ul class="list-disc pl-6 space-y-2">
                <li><strong>The right to access:</strong> You have the right to request copies of your personal data.</li>
                <li><strong>The right to rectification:</strong> You have the right to request that we correct any information you believe is inaccurate.</li>
                <li><strong>The right to erasure:</strong> You have the right to request that we erase your personal data, under certain conditions.</li>
                <li><strong>The right to restrict processing:</strong> You have the right to request that we restrict the processing of your personal data, under certain conditions.</li>
            </ul>

            <h2 class="text-xl font-serif font-bold text-gray-900 mt-8 mb-4">8. Contact Us</h2>
            <p>
                If you have any questions about this Privacy Policy, or if you would like to exercise any of your data protection rights, please contact us at:
            </p>
            <ul class="list-disc pl-6 space-y-2 mt-2">
                <li><strong>Brand Name:</strong> {{ \App\Models\Setting::get('site_name', 'Pepperlemon LLC') }}</li>
                <li><strong>Email:</strong> {{ \App\Models\Setting::get('site_email', 'Papperlemon1@gmail.com') }}</li>
                <li><strong>Address:</strong> {{ \App\Models\Setting::get('site_address', '12800 Northborough Dr, Houston, TX 77067') }}</li>
            </ul>
        </div>
    </div>
@endsection

