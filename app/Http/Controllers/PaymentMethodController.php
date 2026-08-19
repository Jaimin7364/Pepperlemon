<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\StripeClient;
use App\Models\User;

class PaymentMethodController extends Controller
{
    protected $stripe;

    public function __construct()
    {
        $this->stripe = new StripeClient(env('STRIPE_SECRET'));
    }

    public function index()
    {
        $user = Auth::user();

        // Create Stripe Customer if not exists
        if (!$user->stripe_customer_id) {
            $customer = $this->stripe->customers->create([
                'email' => $user->email,
                'name'  => $user->name,
            ]);
            $user->stripe_customer_id = $customer->id;
            $user->save();
        }

        // Fetch Payment Methods (Cards)
        $paymentMethods = $this->stripe->paymentMethods->all([
            'customer' => $user->stripe_customer_id,
            'type' => 'card',
        ]);

        // Create Setup Intent to securely collect new card info
        $setupIntent = $this->stripe->setupIntents->create([
            'customer' => $user->stripe_customer_id,
            'payment_method_types' => ['card'],
        ]);

        return view('frontend.payment_methods.index', [
            'paymentMethods' => $paymentMethods->data,
            'intent' => $setupIntent
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'payment_method_id' => 'required|string'
        ]);

        $user = Auth::user();

        try {
            // Attach the payment method to the customer
            $this->stripe->paymentMethods->attach(
                $request->payment_method_id,
                ['customer' => $user->stripe_customer_id]
            );

            return redirect()->route('payment-methods.index')->with('success', 'Payment method added successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function destroy($paymentMethodId)
    {
        try {
            // Detach payment method
            $this->stripe->paymentMethods->detach($paymentMethodId, []);
            return redirect()->route('payment-methods.index')->with('success', 'Payment method removed successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
