@extends('layouts.frontend')

@section('title', 'Complete Payment — Pepperlemon')

@section('content')
<div class="min-h-[70vh] flex items-center justify-center px-4 py-10 bg-slate-50">
    <div class="w-full max-w-md">

        {{-- Header --}}
        <div class="text-center mb-6">
            <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl mb-3 shadow-md" style="background: linear-gradient(135deg, #0e6b57, #094f40);">
                <i class="fa-solid fa-lock text-white text-lg"></i>
            </div>
            <h1 class="text-xl font-bold text-slate-900" style="font-family: 'Outfit', sans-serif;">Secure Payment</h1>
            <p class="text-xs text-slate-500 mt-1">Your payment is encrypted and secure</p>
        </div>

        {{-- Order Summary Card --}}
        <div class="bg-white border border-slate-200 rounded-2xl p-4 mb-4 shadow-sm">
            <div class="flex items-center justify-between mb-3 pb-2 border-b border-slate-100">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Order</span>
                <span class="text-xs font-extrabold text-slate-900">#{{ $order->order_number }}</span>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-sm text-slate-600 font-medium">Total Amount</span>
                <span class="text-lg font-extrabold text-slate-900" style="font-family: 'Outfit', sans-serif;">${{ number_format($order->total_amount, 2) }}</span>
            </div>
        </div>

        {{-- Stripe Payment Form --}}
        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
            <div class="flex items-center gap-2 mb-4">
                <i class="fa-solid fa-credit-card text-slate-400 text-sm"></i>
                <span class="text-xs font-bold text-slate-700 uppercase tracking-wider">Card Details</span>
                <div class="ml-auto flex items-center gap-1.5">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/4/41/Visa_Logo.png" alt="Visa" class="h-4 object-contain opacity-70">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/2/2a/Mastercard-logo.svg" alt="Mastercard" class="h-4 object-contain opacity-70">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/3/30/American_Express_logo.svg" alt="Amex" class="h-4 object-contain opacity-70">
                </div>
            </div>

            <form id="stripe-payment-form">
                <div id="payment-element" class="mb-4"></div>

                {{-- Error message --}}
                <div id="payment-message" class="hidden text-xs text-red-600 bg-red-50 border border-red-200 rounded-lg px-3 py-2 mb-3 flex items-center gap-2">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <span id="payment-message-text"></span>
                </div>

                <button id="submit-btn" type="submit"
                    class="w-full text-white font-bold py-3 rounded-xl text-sm tracking-wide transition-all duration-300 shadow-md hover:shadow-lg flex items-center justify-center gap-2 cursor-pointer"
                    style="background: linear-gradient(135deg, #0e6b57, #094f40);">
                    <span id="btn-text">
                        <i class="fa-solid fa-lock text-xs mr-1"></i>
                        Pay ${{ number_format($order->total_amount, 2) }}
                    </span>
                    <span id="btn-spinner" class="hidden">
                        <i class="fa-solid fa-spinner fa-spin"></i> Processing...
                    </span>
                </button>
            </form>

            {{-- Cancel link --}}
            <div class="text-center mt-4">
                <a href="{{ route('checkout.stripe.cancel', ['order_id' => $order->id]) }}"
                   class="text-[11px] text-slate-400 hover:text-red-500 transition-colors font-medium"
                   onclick="return confirm('Cancel payment? Your cart will be restored.')">
                    <i class="fa-solid fa-xmark mr-1"></i>Cancel and go back to cart
                </a>
            </div>
        </div>

        {{-- Security badge --}}
        <div class="flex items-center justify-center gap-2 mt-4 text-[10px] text-slate-400 font-medium">
            <i class="fa-solid fa-shield-halved text-slate-300"></i>
            <span>Secured by <strong>Stripe</strong> · 256-bit SSL Encryption</span>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://js.stripe.com/v3/"></script>
<script>
    const stripe = Stripe('{{ $stripePublicKey }}');

    const appearance = {
        theme: 'stripe',
        variables: {
            colorPrimary: '#0e6b57',
            colorBackground: '#ffffff',
            colorText: '#1e293b',
            colorDanger: '#e11d48',
            fontFamily: 'Outfit, ui-sans-serif, system-ui, sans-serif',
            borderRadius: '10px',
            spacingUnit: '4px',
        },
        rules: {
            '.Input': {
                border: '1px solid #e2e8f0',
                boxShadow: 'none',
                padding: '10px 12px',
                fontSize: '13px',
            },
            '.Input:focus': {
                border: '1px solid #0e6b57',
                boxShadow: '0 0 0 3px rgba(14,107,87,0.1)',
            },
            '.Label': {
                fontSize: '11px',
                fontWeight: '600',
                color: '#64748b',
                textTransform: 'uppercase',
                letterSpacing: '0.05em',
            },
        }
    };

    const elements = stripe.elements({
        clientSecret: '{{ $clientSecret }}',
        appearance,
    });

    const paymentElement = elements.create('payment');
    paymentElement.mount('#payment-element');

    const form        = document.getElementById('stripe-payment-form');
    const submitBtn   = document.getElementById('submit-btn');
    const btnText     = document.getElementById('btn-text');
    const btnSpinner  = document.getElementById('btn-spinner');
    const msgBox      = document.getElementById('payment-message');
    const msgText     = document.getElementById('payment-message-text');

    function setLoading(loading) {
        submitBtn.disabled = loading;
        btnText.classList.toggle('hidden', loading);
        btnSpinner.classList.toggle('hidden', !loading);
    }

    function showError(message) {
        msgBox.classList.remove('hidden');
        msgText.textContent = message;
        setLoading(false);
    }

    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        msgBox.classList.add('hidden');
        setLoading(true);

        const returnUrl = '{{ route("checkout.stripe.callback") }}';

        const { error } = await stripe.confirmPayment({
            elements,
            confirmParams: {
                return_url: returnUrl,
                payment_method_data: {
                    billing_details: {
                        name: '{{ $order->shipping_name }}',
                        email: '{{ $order->shipping_email }}',
                    }
                }
            },
        });

        // Only runs if there's an immediate error (e.g. card declined)
        if (error) {
            if (error.type === 'card_error' || error.type === 'validation_error') {
                showError(error.message);
            } else {
                showError('An unexpected error occurred. Please try again.');
            }
        }
    });
</script>
@endpush
