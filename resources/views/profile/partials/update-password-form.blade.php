<section class="max-w-4xl mx-auto p-4 sm:p-6 lg:p-8">
    <form method="post" action="{{ route('password.update') }}" class="overflow-hidden rounded-2xl bg-white shadow-2xl border border-slate-200/60 transition-all hover:shadow-2xl">
        @csrf
        @method('put')

        <!-- Header with Gradient -->
        <div class="relative bg-primary from-primary via-primary-600 to-primary-700 px-6 py-7 text-white overflow-hidden">
            <!-- Decorative elements -->
            <div class="absolute -right-12 -top-12 w-40 h-40 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute -left-8 -bottom-8 w-32 h-32 bg-white/5 rounded-full blur-2xl"></div>
            
            <div class="relative z-10 flex items-center gap-4">
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white/20 backdrop-blur-sm shadow-lg">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                        <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-2xl font-bold font-sans tracking-tight">
                        {{ __('Update Password') }}
                    </h3>
                    <p class="text-sm text-white/80 font-sans mt-0.5">
                        {{ __('Ensure your account is using a long, random password to stay secure.') }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Form Body -->
        <div class="p-6 sm:p-8 space-y-6">
            <!-- Current Password -->
            <div x-data="{ show: false }">
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5 font-sans flex items-center gap-2" for="update_password_current_password">
                    <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                        <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                    </svg>
                    {{ __('Current Password') }}
                </label>
                <div class="relative">
                    <input 
                        id="update_password_current_password" 
                        name="current_password" 
                        :type="show ? 'text' : 'password'" 
                        class="mt-1 block w-full rounded-xl border border-slate-200 bg-slate-50/50 px-4 py-3 text-sm text-slate-800 shadow-sm transition-all duration-200 focus:border-primary focus:ring-2 focus:ring-primary/20 focus:bg-white focus:shadow-md hover:border-slate-300" 
                        autocomplete="current-password"
                        placeholder="••••••••"
                    />
                    <button 
                        type="button" 
                        @click="show = !show"
                        class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 hover:text-primary transition-colors cursor-pointer"
                        aria-label="{{ __('Toggle password visibility') }}"
                    >
                        <svg x-show="!show" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7Z" />
                        </svg>
                        <svg x-cloak x-show="show" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path d="M3.98 8.223A10.477 10.477 0 0 0 2.458 12c1.274 4.057 5.064 7 9.542 7 .847 0 1.669-.11 2.458-.318M8.032 6.377A10.478 10.478 0 0 1 12 5c4.477 0 8.268 2.943 9.542 7a10.478 10.478 0 0 1-2.248 3.807M8.032 6.377 3.073 3.018M8.032 6.377l6.647 6.647M14.679 13.024l3.843 3.843" />
                        </svg>
                    </button>
                </div>
                @error('current_password', 'updatePassword')
                    <p class="mt-1.5 text-xs text-rose-600 font-sans flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <circle cx="12" cy="12" r="10" />
                            <line x1="12" x2="12" y1="8" y2="12" />
                            <line x1="12" x2="12.01" y1="16" y2="16" />
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <!-- New Password -->
                <div x-data="{ show: false }">
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5 font-sans flex items-center gap-2" for="update_password_password">
                        <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path d="M12 15v3m-3-3a3 3 0 1 0 6 0m-6 0a3 3 0 1 0 6 0m-6 0v-3m6 3v-3M4 9V6a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3M4 9v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9M4 9h16" />
                        </svg>
                        {{ __('New Password') }}
                    </label>
                    <div class="relative">
                        <input 
                            id="update_password_password" 
                            name="password" 
                            :type="show ? 'text' : 'password'" 
                            class="mt-1 block w-full rounded-xl border border-slate-200 bg-slate-50/50 px-4 py-3 text-sm text-slate-800 shadow-sm transition-all duration-200 focus:border-primary focus:ring-2 focus:ring-primary/20 focus:bg-white focus:shadow-md hover:border-slate-300" 
                            autocomplete="new-password"
                            placeholder="••••••••"
                        />
                        <button 
                            type="button" 
                            @click="show = !show"
                            class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 hover:text-primary transition-colors cursor-pointer"
                            aria-label="{{ __('Toggle password visibility') }}"
                        >
                            <svg x-show="!show" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7Z" />
                            </svg>
                            <svg x-cloak x-show="show" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path d="M3.98 8.223A10.477 10.477 0 0 0 2.458 12c1.274 4.057 5.064 7 9.542 7 .847 0 1.669-.11 2.458-.318M8.032 6.377A10.478 10.478 0 0 1 12 5c4.477 0 8.268 2.943 9.542 7a10.478 10.478 0 0 1-2.248 3.807M8.032 6.377 3.073 3.018M8.032 6.377l6.647 6.647M14.679 13.024l3.843 3.843" />
                            </svg>
                        </button>
                    </div>
                    @error('password', 'updatePassword')
                        <p class="mt-1.5 text-xs text-rose-600 font-sans flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <circle cx="12" cy="12" r="10" />
                                <line x1="12" x2="12" y1="8" y2="12" />
                                <line x1="12" x2="12.01" y1="16" y2="16" />
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div x-data="{ show: false }">
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5 font-sans flex items-center gap-2" for="update_password_password_confirmation">
                        <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0 1 12 2.944a11.955 11.955 0 0 1-8.618 3.04A12.02 12.02 0 0 0 3 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                        {{ __('Confirm Password') }}
                    </label>
                    <div class="relative">
                        <input 
                            id="update_password_password_confirmation" 
                            name="password_confirmation" 
                            :type="show ? 'text' : 'password'" 
                            class="mt-1 block w-full rounded-xl border border-slate-200 bg-slate-50/50 px-4 py-3 text-sm text-slate-800 shadow-sm transition-all duration-200 focus:border-primary focus:ring-2 focus:ring-primary/20 focus:bg-white focus:shadow-md hover:border-slate-300" 
                            autocomplete="new-password"
                            placeholder="••••••••"
                        />
                        <button 
                            type="button" 
                            @click="show = !show"
                            class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 hover:text-primary transition-colors cursor-pointer"
                            aria-label="{{ __('Toggle password visibility') }}"
                        >
                            <svg x-show="!show" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7Z" />
                            </svg>
                            <svg x-cloak x-show="show" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path d="M3.98 8.223A10.477 10.477 0 0 0 2.458 12c1.274 4.057 5.064 7 9.542 7 .847 0 1.669-.11 2.458-.318M8.032 6.377A10.478 10.478 0 0 1 12 5c4.477 0 8.268 2.943 9.542 7a10.478 10.478 0 0 1-2.248 3.807M8.032 6.377 3.073 3.018M8.032 6.377l6.647 6.647M14.679 13.024l3.843 3.843" />
                            </svg>
                        </button>
                    </div>
                    @error('password_confirmation', 'updatePassword')
                        <p class="mt-1.5 text-xs text-rose-600 font-sans flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <circle cx="12" cy="12" r="10" />
                                <line x1="12" x2="12" y1="8" y2="12" />
                                <line x1="12" x2="12.01" y1="16" y2="16" />
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

            <!-- Password Strength Indicator (Optional) -->
            <div class="pt-2">
                <div class="flex items-center gap-3 text-xs text-slate-500 font-sans">
                    <span>{{ __('Password must be at least 8 characters.') }}</span>
                    <span class="w-px h-4 font-sans bg-slate-200"></span>
                    <span>{{ __('Use a mix of letters, numbers & symbols.') }}</span>
                </div>
            </div>
        </div>

        <!-- Form Actions Footer -->
        <div class="flex items-center font-sans justify-between flex-wrap gap-3 bg-slate-50/80 px-6 py-4 border-t border-slate-200"
             x-data="{ show: @json(session('status') === 'password-updated' ? true : false) }"
             @if(session('status') === 'password-updated')
                 x-init="setTimeout(() => show = false, 5000)"
             @endif
        >
            <!-- Success Notification -->
            <div>
                <template x-if="show">
                    <div class="flex items-center gap-2.5 text-emerald-700 bg-emerald-50/80 backdrop-blur-sm px-4 py-2 rounded-xl border border-emerald-200 text-sm font-sans shadow-sm transition-all duration-300 animate-in slide-in-from-left-4">
                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>{{ __('Password updated successfully!') }}</span>
                    </div>
                </template>
                <div x-show="!show" class="text-xs text-slate-400 font-sans">
                    {{ __('Your password is safe and secure.') }}
                </div>
            </div>

            <!-- Save Button with Animation -->
            <button 
                type="submit" 
                class="group relative inline-flex items-center gap-2.5 rounded-xl bg-primary px-6 py-3 text-sm font-sans text-white shadow-lg shadow-primary/30 transition-all duration-200 hover:shadow-xl hover:shadow-primary/40 hover:scale-[1.02] active:scale-[0.98] cursor-pointer overflow-hidden"
            >
                <span class="relative z-10 flex items-center gap-2.5">
                    <svg class="w-5 h-5 group-hover:rotate-12 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    {{ __('Save Password') }}
                </span>
                <!-- Ripple effect background -->
                <span class="absolute inset-0 bg-white/10 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-xl"></span>
            </button>
        </div>
    </form>
</section>