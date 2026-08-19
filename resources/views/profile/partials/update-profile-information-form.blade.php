<section>
    <header class="flex items-center gap-2.5 mb-3.5 border-b border-slate-100 pb-2">
        <div class="bg-primary/10 text-primary p-2 rounded-lg">
            <i class="fa-solid fa-address-card text-base"></i>
        </div>
        <div>
            <h2 class="text-sm font-serif font-extrabold text-slate-900" style="font-family: 'Outfit', sans-serif;">
                {{ __('Personal Information') }}
            </h2>
            <p class="text-[9px] text-slate-500 font-bold uppercase tracking-wider mt-0.5">
                {{ __('Update your account details and email address') }}
            </p>
        </div>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-3">
        @csrf
        @method('patch')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
            <div>
                <label for="name" class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">{{ __('Full Name') }}</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400 pointer-events-none">
                        <i class="fa-solid fa-user text-xs"></i>
                    </span>
                    <input id="name" name="name" type="text" 
                        class="w-full bg-slate-50/50 border border-slate-200 focus:bg-white rounded-xl pl-9 pr-4 py-2 text-xs font-bold text-slate-800 shadow-xs focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary/20 transition duration-200" 
                        value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
                </div>
                <x-input-error class="mt-0.5" :messages="$errors->get('name')" />
            </div>

            <div>
                <label for="email" class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">{{ __('Email Address') }}</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400 pointer-events-none">
                        <i class="fa-solid fa-envelope text-xs"></i>
                    </span>
                    <input id="email" name="email" type="email" 
                        class="w-full bg-slate-50/50 border border-slate-200 focus:bg-white rounded-xl pl-9 pr-4 py-2 text-xs font-bold text-slate-800 shadow-xs focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary/20 transition duration-200" 
                        value="{{ old('email', $user->email) }}" required autocomplete="username" />
                </div>
                <x-input-error class="mt-0.5" :messages="$errors->get('email')" />
            </div>
        </div>

        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <div class="bg-amber-50 border border-amber-250/70 p-2.5 rounded-xl flex items-start gap-2">
                <i class="fa-solid fa-circle-exclamation text-amber-600 text-xs mt-0.5 flex-shrink-0"></i>
                <div class="flex-1">
                    <p class="text-xs text-amber-800 font-bold leading-normal">
                        {{ __('Your email address is unverified.') }}
                    </p>
                    <button form="send-verification" class="text-[9px] text-amber-700 hover:text-amber-900 underline font-bold mt-0.5 cursor-pointer">
                        {{ __('Click here to re-send the verification email.') }}
                    </button>
                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-0.5 font-bold text-[9px] text-emerald-700">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            </div>
        @endif

        <div class="flex items-center gap-3 pt-1">
            <button type="submit" class="bg-primary hover:bg-primary-dark text-white font-extrabold px-4 py-2 rounded-xl text-xs tracking-wider transition-all shadow-md hover:shadow-lg transform hover:-translate-y-0.5 cursor-pointer flex items-center gap-1.5">
                <i class="fa-solid fa-floppy-disk text-[10px]"></i> {{ __('Save Changes') }}
            </button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)" class="text-xs text-emerald-600 font-extrabold flex items-center gap-1">
                    <i class="fa-solid fa-circle-check"></i> {{ __('Profile updated successfully.') }}
                </p>
            @endif
        </div>
    </form>
</section>
