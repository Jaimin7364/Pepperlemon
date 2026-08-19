@extends('layouts.frontend')

@section('title', 'Refund & Return Policy')

@section('content')
    <!-- Page Header -->
    <div class="bg-[#fdfaf6] py-5 md:py-12 text-center border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <p class="text-[10px] md:text-sm text-gray-500 uppercase tracking-widest leading-relaxed">
                <a href="/" class="hover:text-primary transition">Home</a> / 
                <span class="text-gray-900 font-medium">Refund Policy</span>
            </p>
            <h1 class="text-2xl sm:text-4xl font-serif font-bold text-gray-900 mt-1 md:mt-2">Refund & Return Policy</h1>
        </div>
    </div>

    <!-- Content Section -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-16">
        <div class="prose max-w-none text-gray-600 leading-relaxed font-sans text-sm sm:text-base space-y-6">
            <p class="text-xs text-gray-400">Last updated: July 8, 2026</p>
            
            <p>
                At <strong>Pepperlemon LLC</strong>, customer satisfaction is our top priority. Since our products are fresh groceries, beverages, and organic daily essentials, we take great care in ensuring the highest quality. Please read our policy on returns and refunds below.
            </p>

            <h2 class="text-xl font-serif font-bold text-gray-900 mt-8 mb-4">1. Eligibility for Returns & Exchanges</h2>
            <p>
                We accept returns or exchanges only under the following specific circumstances:
            </p>
            <ul class="list-disc pl-6 space-y-2">
                <li><strong>Damaged in Transit:</strong> If the product is physically damaged upon delivery.</li>
                <li><strong>Wrong Item Delivered:</strong> If you received an item different from what you ordered.</li>
                <li><strong>Defective/Expired Products:</strong> If the product has a manufacturing defect or is expired.</li>
            </ul>
            <p>
                To be eligible for a return, the item must be unused, in the same condition that you received it, and in its original packaging. You must raise a return request within <strong>48 hours</strong> of receiving your delivery.
            </p>

            <h2 class="text-xl font-serif font-bold text-gray-900 mt-8 mb-4">2. Process for Raising a Request</h2>
            <p>
                If you receive a damaged or wrong product, please follow these steps to request a return or refund:
            </p>
            <ol class="list-decimal pl-6 space-y-2">
                <li>Send an email to <strong>{{ \App\Models\Setting::get('site_email', 'Papperlemon1@gmail.com') }}</strong> within 48 hours of delivery.</li>
                <li>In your request, please provide your **Order Number**, the **Name of the product**, and clear **photographs/videos** of the damaged or incorrect item.</li>
                <li>Our support team will review your submission. Once approved, we will arrange a reverse pickup or guide you on the return shipping process.</li>
            </ol>

            <h2 class="text-xl font-serif font-bold text-gray-900 mt-8 mb-4">3. Refund Approval & Processing</h2>
            <p>
                Once your return is received and inspected, we will send you an email or call you to notify you that we have received your returned item. We will also notify you of the approval or rejection of your refund.
            </p>
            <p>
                If approved, your refund will be processed immediately. The refund amount will automatically be credited back to your original payment method (Credit Card, Debit Card, Net Banking, UPI, or Wallet) through our payment gateway, <strong>Razorpay</strong>.
            </p>

            <h2 class="text-xl font-serif font-bold text-gray-900 mt-8 mb-4">4. Refund Timeline</h2>
            <p>
                Once processed by us, it typically takes <strong>5 to 7 business days</strong> for the refunded amount to reflect in your bank account or credit card statement, depending on your card issuer or banking institution.
            </p>

            <h2 class="text-xl font-serif font-bold text-gray-900 mt-8 mb-4">5. Non-Returnable Items</h2>
            <p>
                Certain types of goods cannot be returned:
            </p>
            <ul class="list-disc pl-6 space-y-2">
                <li>Products showing signs of use, alteration, or tampering.</li>
                <li>Products returned without original packaging or invoices.</li>
                <li>Items purchased during promotional clearance sales.</li>
            </ul>

            <h2 class="text-xl font-serif font-bold text-gray-900 mt-8 mb-4">6. Contact Information</h2>
            <p>
                For any questions or support regarding refunds, returns, or exchanges, please contact us:
            </p>
            <ul class="list-disc pl-6 space-y-2 mt-2">
                <li><strong>Brand Name:</strong> {{ \App\Models\Setting::get('site_name', 'Pepperlemon LLC') }}</li>
                <li><strong>Email:</strong> {{ \App\Models\Setting::get('site_email', 'Papperlemon1@gmail.com') }}</li>
                <li><strong>Address:</strong> {{ \App\Models\Setting::get('site_address', '12800 Northborough Dr, Houston, TX 77067') }}</li>
            </ul>
        </div>
    </div>
@endsection

