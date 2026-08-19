<section class="space-y-4">
    <header class="flex items-center gap-2.5 mb-3.5 border-b border-slate-100 pb-2">
        <div class="bg-red-50 text-red-650 p-2 rounded-lg border border-red-100">
            <i class="fa-solid fa-circle-radiation text-base"></i>
        </div>
        <div>
            <h2 class="text-sm font-serif font-extrabold text-slate-900" style="font-family: 'Outfit', sans-serif;">
                {{ __('Delete Account') }}
            </h2>
            <p class="text-[9px] text-red-500 font-bold uppercase tracking-wider mt-0.5">
                {{ __('Danger Zone - Action cannot be undone') }}
            </p>
        </div>
    </header>

    <div class="bg-red-50/50 border border-red-100 p-3 rounded-xl flex items-start gap-2.5">
        <i class="fa-solid fa-triangle-exclamation text-red-500 text-sm mt-0.5 flex-shrink-0"></i>
        <div>
            <h4 class="text-xs font-bold text-red-800 mb-0.5">Warning about data deletion</h4>
            <p class="text-[10px] text-red-750 font-medium leading-relaxed">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
            </p>
        </div>
    </div>

    <button
        type="button"
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="bg-red-500 hover:bg-red-650 text-white font-extrabold px-4 py-2 rounded-xl text-xs tracking-wider transition-all shadow-md hover:shadow-lg transform hover:-translate-y-0.5 cursor-pointer flex items-center gap-1.5 w-fit"
    >
        <i class="fa-solid fa-user-slash text-[10px]"></i> {{ __('Delete Account') }}
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-5">
            @csrf
            @method('delete')

            <h2 class="text-base font-serif font-extrabold text-slate-900 mb-1.5" style="font-family: 'Outfit', sans-serif;">
                {{ __('Are you sure you want to delete your account?') }}
            </h2>

            <p class="text-[11px] text-slate-500 font-semibold leading-relaxed mb-4">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <div>
                <label for="password" class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">{{ __('Password') }}</label>
                <div class="relative w-full sm:w-3/4">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400 pointer-events-none">
                        <i class="fa-solid fa-lock text-xs"></i>
                    </span>
                    <input
                        id="password"
                        name="password"
                        type="password"
                        class="w-full bg-slate-50/50 border border-slate-200 focus:bg-white rounded-xl pl-9 pr-4 py-2 text-xs font-bold text-slate-800 shadow-xs focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500/20 transition duration-200"
                        placeholder="{{ __('Confirm with Password') }}"
                    />
                </div>

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-0.5" />
            </div>

            <div class="mt-5 flex justify-end gap-2.5">
                <button type="button" x-on:click="$dispatch('close')" class="px-3.5 py-1.5 border border-slate-200 rounded-xl text-xs font-bold text-slate-650 hover:bg-slate-50 transition duration-150 cursor-pointer">
                    {{ __('Cancel') }}
                </button>

                <button type="submit" class="px-3.5 py-1.5 bg-red-500 hover:bg-red-650 text-white rounded-xl text-xs font-bold transition duration-150 shadow-md hover:shadow-lg cursor-pointer">
                    {{ __('Confirm Delete') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>
