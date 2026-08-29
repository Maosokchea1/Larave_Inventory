<section class="max-w-4xl mx-auto p-4 sm:p-6 lg:p-8" x-data="{ photoPreview: null }">
    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="overflow-hidden rounded-2xl bg-white shadow-2xl border border-slate-200/60 transition-all hover:shadow-2xl">
        @csrf
        @method('patch')

        <!-- Profile Header with Gradient -->
        <div class="relative bg-primary from-primary via-primary-600 to-primary-700 px-6 py-7 text-white overflow-hidden">
            <!-- Decorative Elements -->
            <div class="absolute -right-16 -top-16 w-48 h-48 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute -left-12 -bottom-12 w-40 h-40 bg-white/5 rounded-full blur-2xl"></div>

            <div class="relative z-10 flex flex-col sm:flex-row items-start sm:items-center gap-4">
                <!-- Avatar / Profile Image with Live Preview -->
                <div class="relative shrink-0 group">
                    <div class="relative">
                        <!-- Preview Image -->
                        <template x-if="photoPreview">
                            <img :src="photoPreview" class="h-20 w-20  font-sans rounded-full object-cover border-4 border-white/30 shadow-xl">
                        </template>
                        <!-- Current Image or Initials -->
                        <template x-if="!photoPreview">
                            @if(auth()->user()->image)
                                <img src="{{ asset('storage/' . auth()->user()->image) }}" 
                                     alt="{{ auth()->user()->name }}" 
                                     class="h-20 w-20 rounded-full object-cover border-4 border-white/30 shadow-xl">
                            @else
                                <div class="flex h-20 w-20 items-center font-sans justify-center rounded-full bg-white/20 text-3xl text-white shadow-xl backdrop-blur-sm">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                            @endif
                        </template>
                        <!-- Hover Overlay for Upload -->
                        <div class="absolute inset-0 flex items-center justify-center rounded-full bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 cursor-pointer">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                    </div>
                    <!-- Upload Input (Hidden) -->
                    <input type="file" name="image" accept="image/*" class="hidden" id="profile_image_upload"
                           x-ref="photo"
                           @change="
                               const file = $refs.photo.files[0];
                               if (file) {
                                   const reader = new FileReader();
                                   reader.onload = (e) => { photoPreview = e.target.result; };
                                   reader.readAsDataURL(file);
                               }
                           " />
                    <!-- Click to upload (triggers hidden input) -->
                    <button type="button" @click="$refs.photo.click()" class="absolute -bottom-1 -right-1 flex h-8 w-8 items-center justify-center rounded-full bg-white text-primary shadow-lg hover:scale-110 transition-transform duration-200 cursor-pointer border-2 border-white">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                    </button>
                </div>

                <!-- User Info -->
                <div class="min-w-0 flex-1">
                    <p class="text-xs font-sans uppercase tracking-wider text-white/80">
                        {{ __('Edit Profile') }}
                    </p>
                    <h3 class="truncate text-2xl font-sans text-white">
                        {{ auth()->user()->name }}
                    </h3>
                    <p class="truncate text-sm font-sans text-white/90">
                        {{ auth()->user()->email }}
                    </p>
                    <div class="mt-1 flex items-center font-sans gap-2 text-xs text-white/70">
                        <span class="inline-flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            {{ auth()->user()->role ?? __('Admin') }}
                        </span>
                        <span class="w-px h-3 font-sans bg-white/20"></span>
                        <span class="inline-flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                                <line x1="16" y1="2" x2="16" y2="6" />
                                <line x1="8" y1="2" x2="8" y2="6" />
                                <line x1="3" y1="10" x2="21" y2="10" />
                            </svg>
                            {{ auth()->user()->created_at ? auth()->user()->created_at->format('M d, Y') : '-' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Profile Details Content -->
        <div class="grid grid-cols-1 gap-6 p-6 md:grid-cols-2 bg-slate-50/50">
            
            <!-- Account Information Card -->
            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm hover:shadow-md transition-shadow duration-200 space-y-4">
                <div class="flex items-center gap-2.5 border-b border-slate-200 pb-3 text-primary font-sans">
                    <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-primary/10 text-primary">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="2" y="5" width="20" height="14" rx="2" />
                            <path d="M2 10h20" />
                        </svg>
                    </div>
                    <span class="text-sm uppercase tracking-wider font-sans">{{ __('Account Information') }}</span>
                </div>

                <!-- Name -->
                <div>
                    <x-input-label for="name" :value="__('Full Name')" class="text-xs font-medium text-slate-600" />
                    <x-text-input id="name" name="name" type="text" class="mt-1.5 block w-full rounded-xl border-slate-200 bg-slate-50/50 px-4 py-2.5 text-sm text-slate-800 shadow-sm transition-all duration-200 focus:border-primary focus:ring-2 focus:ring-primary/20 focus:bg-white focus:shadow-md hover:border-slate-300" :value="old('name', auth()->user()->name)" required autofocus autocomplete="name" />
                    <x-input-error class="mt-1.5 text-xs text-rose-600" :messages="$errors->get('name')" />
                </div>

                <!-- Email -->
                <div>
                    <x-input-label for="email" :value="__('Email Address')" class="text-xs font-sans text-slate-600" />
                    <x-text-input id="email" name="email" type="email" class="mt-1.5 block w-full rounded-xl border-slate-200 bg-slate-50/50 px-4 py-2.5 text-sm text-slate-800 shadow-sm transition-all duration-200 focus:border-primary focus:ring-2 focus:ring-primary/20 focus:bg-white focus:shadow-md hover:border-slate-300" :value="old('email', auth()->user()->email)" required autocomplete="username" />
                    <x-input-error class="mt-1.5 text-xs text-rose-600" :messages="$errors->get('email')" />
                </div>

                <!-- Role (Read-only) -->
                <div class="pt-1">
                    <p class="text-xs font-sans text-slate-600">{{ __('Role') }}</p>
                    <div class="mt-1.5 inline-flex items-center gap-2 rounded-full bg-primary/10 px-3.5 py-1.5 text-sm font-semibold text-primary">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        {{ auth()->user()->role ?? __('Admin') }}
                    </div>
                </div>
            </div>

            <!-- Contact Details Card -->
            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm hover:shadow-md transition-shadow duration-200 space-y-4">
                <div class="flex items-center gap-2.5 border-b border-slate-200 pb-3 text-primary font-sans">
                    <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-primary/10 text-primary">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z" />
                        </svg>
                    </div>
                    <span class="text-sm uppercase tracking-wider">{{ __('Contact Details') }}</span>
                </div>

                <!-- Phone -->
                <div>
                    <x-input-label for="phone" :value="__('Phone Number')" class="text-xs font-medium text-slate-600" />
                    <x-text-input id="phone" name="phone" type="text" class="mt-1.5 block w-full rounded-xl border-slate-200 bg-slate-50/50 px-4 py-2.5 text-sm text-slate-800 shadow-sm transition-all duration-200 focus:border-primary focus:ring-2 focus:ring-primary/20 focus:bg-white focus:shadow-md hover:border-slate-300" :value="old('phone', auth()->user()->phone)" autocomplete="tel" />
                    <x-input-error class="mt-1.5 text-xs text-rose-600" :messages="$errors->get('phone')" />
                </div>

                <!-- Address -->
                <div>
                    <x-input-label for="address" :value="__('Address')" class="text-xs font-medium text-slate-600" />
                    <x-text-input id="address" name="address" type="text" class="mt-1.5 block w-full rounded-xl border-slate-200 bg-slate-50/50 px-4 py-2.5 text-sm text-slate-800 shadow-sm transition-all duration-200 focus:border-primary focus:ring-2 focus:ring-primary/20 focus:bg-white focus:shadow-md hover:border-slate-300" :value="old('address', auth()->user()->address)" autocomplete="address-level1" />
                    <x-input-error class="mt-1.5 text-xs text-rose-600" :messages="$errors->get('address')" />
                </div>

                <!-- Joined Date (Read-only) -->
                <div class="pt-1">
                    <p class="text-xs font-sans text-slate-600">{{ __('Member Since') }}</p>
                    <div class="mt-1.5 flex items-center gap-2 text-sm font-sans text-slate-700">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                            <line x1="16" y1="2" x2="16" y2="6" />
                            <line x1="8" y1="2" x2="8" y2="6" />
                            <line x1="3" y1="10" x2="21" y2="10" />
                        </svg>
                        {{ auth()->user()->created_at ? auth()->user()->created_at->format('F d, Y') : '-' }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Actions Footer -->
        <div class="flex items-center justify-between font-sans flex-wrap gap-3 bg-slate-50/80 px-6 py-4 border-t border-slate-200"
             x-data="{ show: @json(session('success') ? true : false) }"
             @if(session('success'))
                 x-init="setTimeout(() => show = false, 5000)"
             @endif
        >
            <!-- Success Notification -->
            <div>
                <template x-if="show">
                    <div class="flex items-center font-sans gap-2.5 text-emerald-700 bg-emerald-50/80 backdrop-blur-sm px-4 py-2 rounded-xl border border-emerald-200 text-sm font-semibold shadow-sm transition-all duration-300 animate-in slide-in-from-left-4">
                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>{{ __('Profile updated successfully!') }}</span>
                    </div>
                </template>
                <div x-show="!show" class="text-xs text-slate-400 font-sans">
                    {{ __('Update your profile information.') }}
                </div>
            </div>

            <!-- Save Button with Animation -->
            <button type="submit" 
                    class="group relative inline-flex items-center gap-2.5 rounded-xl bg-primary px-6 py-3 text-sm font-sans text-white shadow-lg shadow-primary/30 transition-all duration-200 hover:shadow-xl hover:shadow-primary/40 hover:scale-[1.02] active:scale-[0.98] cursor-pointer overflow-hidden">
                <span class="relative z-10 flex items-center gap-2.5">
                    <svg class="w-5 h-5 group-hover:rotate-12 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    {{ __('Save Changes') }}
                </span>
                <!-- Ripple effect background -->
                <span class="absolute inset-0 bg-white/10 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-xl"></span>
            </button>
        </div>
    </form>
</section>