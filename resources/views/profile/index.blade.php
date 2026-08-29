<div class="bg-white rounded-2xl shadow-xl overflow-hidden max-w-3xl w-full mx-auto">
    <!-- Header Red Background with Image/Avatar -->
    <div class="bg-red-700 p-6 text-white relative">
        <button @click="open = false" class="absolute top-4 right-4 text-white/80 hover:text-white bg-black/10 hover:bg-black/20 rounded-full p-1.5 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
        <div class="flex items-center gap-4">
            <!-- Profile Image or Default Initial -->
            <div class="w-16 h-16 rounded-full overflow-hidden bg-white/25 flex items-center justify-center border-2 border-white/40 shadow-md shrink-0">
                @if(Auth::user()->image ?? false)
                    <img src="{{ asset('storage/' . Auth::user()->image) }}" alt="Profile Image" class="w-full h-full object-cover">
                @else
                    <span class="text-2xl font-bold text-white">{{ substr(Auth::user()->name, 0, 1) }}</span>
                @endif
            </div>
            <div>
                <p class="text-xs uppercase tracking-wider text-white/80 font-sans">{{ __('My Profile') }}</p>
                <h2 class="text-xl font-bold text-white">{{ Auth::user()->name }}</h2>
                <p class="text-sm text-white/90">{{ Auth::user()->email }}</p>
            </div>
        </div>
    </div>

    <!-- Body Content -->
    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6 bg-slate-50/50">
        <!-- Account Information Card -->
        <div class="bg-white p-5 rounded-xl border border-slate-100 shadow-sm space-y-4">
            <div class="flex items-center gap-2 text-red-700 font-sans border-b pb-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                <span>{{ __('Account Information') }}</span>
            </div>
            
            <div>
                <p class="text-xs text-slate-400 font-sans">{{ __('Name') }}</p>
                <p class="text-sm font-semibold text-slate-800">{{ Auth::user()->name }}</p>
            </div>

            <div>
                <p class="text-xs text-slate-400 font-sans">{{ __('Email') }}</p>
                <p class="text-sm font-semibold text-slate-800">{{ Auth::user()->email }}</p>
            </div>

            <div>
                <p class="text-xs text-slate-400 font-sans">{{ __('Role') }}</p>
                <p class="text-sm font-semibold text-slate-800">{{ Auth::user()->role ?? 'Admin' }}</p>
            </div>
        </div>

        <!-- Contact Details Card -->
        <div class="bg-white p-5 rounded-xl border border-slate-100 shadow-sm space-y-4">
            <div class="flex items-center gap-2 text-red-700 font-sans border-b pb-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.3-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                <span>{{ __('Contact Details') }}</span>
            </div>

            <div>
                <p class="text-xs text-slate-400 font-sans">{{ __('Phone') }}</p>
                <p class="text-sm font-semibold text-slate-800">{{ Auth::user()->phone ?? '-' }}</p>
            </div>

            <div>
                <p class="text-xs text-slate-400 font-sans">{{ __('Address') }}</p>
                <p class="text-sm font-semibold text-slate-800">{{ Auth::user()->address ?? '-' }}</p>
            </div>

            <div>
                <p class="text-xs text-slate-400 font-sans">{{ __('Joined') }}</p>
                <p class="text-sm font-semibold text-slate-800">{{ Auth::user()->created_at->format('M d, Y') }}</p>
            </div>
        </div>
    </div>
</div>