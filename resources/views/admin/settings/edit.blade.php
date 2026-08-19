@extends('layouts.admin')

@section('header_title', 'Global Settings')

@section('content')
<div class="max-w-2xl mx-auto bg-white rounded-2xl border border-slate-100 p-6 sm:p-8 shadow-xs">
    
    <div class="mb-6 flex items-center justify-between">
        <h3 class="font-serif font-bold text-slate-800 text-lg">System Settings</h3>
    </div>

    <form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-6">
        @csrf

        <!-- Site Identity -->
        <div class="bg-slate-50 p-5 rounded-2xl border border-slate-100 space-y-4">
            <h4 class="font-serif font-bold text-slate-800 text-sm pb-1.5 border-b border-slate-200">Shop Identity</h4>

            <!-- Site Name -->
            <div class="space-y-1.5">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Shop Name</label>
                <input type="text" name="site_name" value="{{ $settings['site_name'] ?? 'Pepperlemon' }}" placeholder="Pepperlemon"
                       class="w-full border border-slate-200 focus:ring-1 focus:ring-[#C49A6C] focus:border-[#C49A6C] rounded-xl text-sm px-4 py-2.5 bg-white">
            </div>

            <!-- Site Email -->
            <div class="space-y-1.5">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Support Email</label>
                <input type="email" name="site_email" value="{{ $settings['site_email'] ?? 'Papperlemon1@gmail.com' }}" placeholder="Papperlemon1@gmail.com"
                       class="w-full border border-slate-200 focus:ring-1 focus:ring-[#C49A6C] focus:border-[#C49A6C] rounded-xl text-sm px-4 py-2.5 bg-white">
            </div>

            <!-- Site Phone -->
            <div class="space-y-1.5">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Support Phone</label>
                <input type="text" name="site_phone" value="{{ $settings['site_phone'] ?? '+1-800-555-0199' }}" placeholder="+1-800-555-0199"
                       class="w-full border border-slate-200 focus:ring-1 focus:ring-[#C49A6C] focus:border-[#C49A6C] rounded-xl text-sm px-4 py-2.5 bg-white">
            </div>

            <!-- Site Address -->
            <div class="space-y-1.5">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Physical Address</label>
                <textarea name="site_address" rows="3" placeholder="Shop Address..."
                          class="w-full border border-slate-200 focus:ring-1 focus:ring-[#C49A6C] focus:border-[#C49A6C] rounded-xl text-sm px-4 py-2.5 bg-white">{{ $settings['site_address'] ?? '12800 Northborough Dr, Houston, TX 77067' }}</textarea>
            </div>
        </div>

        <!-- Stripe Payment Settings -->
        <div class="bg-slate-50 p-5 rounded-2xl border border-slate-100 space-y-4">
            <h4 class="font-serif font-bold text-slate-800 text-sm pb-1.5 border-b border-slate-200">Stripe Payment</h4>

            <div class="space-y-1.5">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Stripe Publishable Key</label>
                <input type="text" name="stripe_key" value="{{ $settings['stripe_key'] ?? config('services.stripe.key') }}" placeholder="pk_live_..."
                       class="w-full border border-slate-200 focus:ring-1 focus:ring-[#C49A6C] focus:border-[#C49A6C] rounded-xl text-sm px-4 py-2.5 bg-white">
            </div>

            <div class="space-y-1.5" x-data="{ showSecret: false }">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Stripe Secret Key</label>
                <div class="relative">
                    <input :type="showSecret ? 'text' : 'password'" name="stripe_secret" value="{{ $settings['stripe_secret'] ?? config('services.stripe.secret') }}" placeholder="sk_live_..."
                           class="w-full border border-slate-200 focus:ring-1 focus:ring-[#C49A6C] focus:border-[#C49A6C] rounded-xl text-sm pl-4 pr-10 py-2.5 bg-white">
                    <button type="button" @click="showSecret = !showSecret" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-[#C49A6C] focus:outline-none cursor-pointer">
                        <i class="fa-solid text-sm" :class="showSecret ? 'fa-eye-slash' : 'fa-eye'"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Social Media Settings -->
        <div class="bg-slate-50 p-5 rounded-2xl border border-slate-100 space-y-4">
            <h4 class="font-serif font-bold text-slate-800 text-sm pb-1.5 border-b border-slate-200">Social Media Links</h4>

            <!-- Facebook -->
            <div class="space-y-1.5">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Facebook URL</label>
                <input type="url" name="social_facebook" value="{{ $settings['social_facebook'] ?? '' }}" placeholder="https://facebook.com/yourpage"
                       class="w-full border border-slate-200 focus:ring-1 focus:ring-[#C49A6C] focus:border-[#C49A6C] rounded-xl text-sm px-4 py-2.5 bg-white">
            </div>

            <!-- Twitter / X -->
            <div class="space-y-1.5">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Twitter / X URL</label>
                <input type="url" name="social_twitter" value="{{ $settings['social_twitter'] ?? '' }}" placeholder="https://x.com/yourhandle"
                       class="w-full border border-slate-200 focus:ring-1 focus:ring-[#C49A6C] focus:border-[#C49A6C] rounded-xl text-sm px-4 py-2.5 bg-white">
            </div>

            <!-- Instagram -->
            <div class="space-y-1.5">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Instagram URL</label>
                <input type="url" name="social_instagram" value="{{ $settings['social_instagram'] ?? '' }}" placeholder="https://instagram.com/yourhandle"
                       class="w-full border border-slate-200 focus:ring-1 focus:ring-[#C49A6C] focus:border-[#C49A6C] rounded-xl text-sm px-4 py-2.5 bg-white">
            </div>

            <!-- LinkedIn -->
            <div class="space-y-1.5">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">LinkedIn URL</label>
                <input type="url" name="social_linkedin" value="{{ $settings['social_linkedin'] ?? '' }}" placeholder="https://linkedin.com/company/yourcompany"
                       class="w-full border border-slate-200 focus:ring-1 focus:ring-[#C49A6C] focus:border-[#C49A6C] rounded-xl text-sm px-4 py-2.5 bg-white">
            </div>

            <!-- YouTube -->
            <div class="space-y-1.5">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">YouTube URL</label>
                <input type="url" name="social_youtube" value="{{ $settings['social_youtube'] ?? '' }}" placeholder="https://youtube.com/c/yourchannel"
                       class="w-full border border-slate-200 focus:ring-1 focus:ring-[#C49A6C] focus:border-[#C49A6C] rounded-xl text-sm px-4 py-2.5 bg-white">
            </div>
        </div>

        <!-- UPS Shipping Settings -->
        <div class="bg-slate-50 p-5 rounded-2xl border border-slate-100 space-y-4">
            <h4 class="font-serif font-bold text-slate-800 text-sm pb-1.5 border-b border-slate-200">UPS Shipping</h4>

            <div class="space-y-1.5">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">UPS Client ID</label>
                <input type="text" name="ups_client_id" value="{{ $settings['ups_client_id'] ?? '' }}" placeholder="UPS OAuth Client ID"
                       class="w-full border border-slate-200 focus:ring-1 focus:ring-[#C49A6C] focus:border-[#C49A6C] rounded-xl text-sm px-4 py-2.5 bg-white">
            </div>

            <div class="space-y-1.5" x-data="{ showSecret: false }">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">UPS Client Secret</label>
                <div class="relative">
                    <input :type="showSecret ? 'text' : 'password'" name="ups_client_secret" value="{{ $settings['ups_client_secret'] ?? '' }}" placeholder="••••••••••••••••"
                           class="w-full border border-slate-200 focus:ring-1 focus:ring-[#C49A6C] focus:border-[#C49A6C] rounded-xl text-sm pl-4 pr-10 py-2.5 bg-white">
                    <button type="button" @click="showSecret = !showSecret" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-[#C49A6C] focus:outline-none cursor-pointer">
                        <i class="fa-solid text-sm" :class="showSecret ? 'fa-eye-slash' : 'fa-eye'"></i>
                    </button>
                </div>
            </div>

            <div class="space-y-1.5">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">UPS Account Number</label>
                <input type="text" name="ups_account_number" value="{{ $settings['ups_account_number'] ?? '' }}" placeholder="6-digit UPS shipper number"
                       class="w-full border border-slate-200 focus:ring-1 focus:ring-[#C49A6C] focus:border-[#C49A6C] rounded-xl text-sm px-4 py-2.5 bg-white">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Ship-From Street</label>
                    <input type="text" name="ups_ship_from_address" value="{{ $settings['ups_ship_from_address'] ?? '12800 Northborough Dr' }}" placeholder="123 Main St"
                           class="w-full border border-slate-200 focus:ring-1 focus:ring-[#C49A6C] focus:border-[#C49A6C] rounded-xl text-sm px-4 py-2.5 bg-white">
                </div>
                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Ship-From City</label>
                    <input type="text" name="ups_ship_from_city" value="{{ $settings['ups_ship_from_city'] ?? 'Houston' }}" placeholder="Houston"
                           class="w-full border border-slate-200 focus:ring-1 focus:ring-[#C49A6C] focus:border-[#C49A6C] rounded-xl text-sm px-4 py-2.5 bg-white">
                </div>
                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Ship-From State</label>
                    <input type="text" name="ups_ship_from_state" value="{{ $settings['ups_ship_from_state'] ?? 'TX' }}" placeholder="TX" maxlength="2"
                           class="w-full border border-slate-200 focus:ring-1 focus:ring-[#C49A6C] focus:border-[#C49A6C] rounded-xl text-sm px-4 py-2.5 bg-white">
                </div>
                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Ship-From ZIP</label>
                    <input type="text" name="ups_ship_from_zip" value="{{ $settings['ups_ship_from_zip'] ?? '77067' }}" placeholder="77067"
                           class="w-full border border-slate-200 focus:ring-1 focus:ring-[#C49A6C] focus:border-[#C49A6C] rounded-xl text-sm px-4 py-2.5 bg-white">
                </div>
            </div>
            <span class="text-[10px] text-slate-400 block">This is your warehouse/pickup address that UPS will pick shipments from.</span>
        </div>

        <!-- Submit Buttons -->
        <div class="flex justify-end pt-4 border-t border-slate-100">
            <button type="submit" class="w-full sm:w-auto bg-[#C49A6C] hover:bg-[#b0875b] text-white font-bold text-sm px-8 py-3.5 rounded-xl shadow-md shadow-[#C49A6C]/20 transition cursor-pointer">
                Save Settings
            </button>
        </div>
    </form>

</div>
@endsection
