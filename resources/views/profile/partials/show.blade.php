<div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-white via-white to-secondary/5 shadow-2xl shadow-primary/5 border border-white/50 transition-all duration-300 hover:shadow-2xl hover:shadow-primary/10">

    <!-- Decorative Background Shapes -->
    <div class="absolute -top-32 -right-32 h-96 w-96 rounded-full bg-gradient-to-br from-primary/5 to-secondary/5 blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-32 -left-32 h-80 w-80 rounded-full bg-gradient-to-tr from-accent/5 to-primary/5 blur-3xl pointer-events-none"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 h-64 w-64 rounded-full bg-gradient-to-r from-primary/5 via-secondary/5 to-accent/5 blur-3xl pointer-events-none"></div>

    <!-- Profile Header with Gradient -->
    <div class="relative bg-primary from-primary via-primary-600 to-primary-700 px-8 py-8 text-white overflow-hidden">
        <!-- Decorative elements in header -->
        <div class="absolute top-0 right-0 h-48 w-48 rounded-full bg-white/5 blur-2xl pointer-events-none"></div>
        <div class="absolute bottom-0 left-1/3 h-32 w-32 rounded-full bg-white/5 blur-2xl pointer-events-none"></div>
        
        <div class="relative flex items-center gap-6">
            <!-- Avatar with Glow Effect -->
            <div class="group relative shrink-0">
                <div class="absolute -inset-1 rounded-full bg-gradient-to-r from-white/30 to-white/10 blur-md opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                <div class="relative">
                    @if(auth()->user()->image)
                        <img src="{{ asset('storage/' . auth()->user()->image) }}" 
                             alt="{{ auth()->user()->name }}" 
                             class="h-20 w-20 rounded-full object-cover border-3 border-white/30 shadow-xl shadow-black/10 transition-all duration-300 group-hover:scale-105 group-hover:border-white/60">
                    @else
                        <div class="flex h-20 w-20 items-center justify-center rounded-full bg-white/20 text-3xl font-sans text-white shadow-xl shadow-black/10 backdrop-blur-sm border border-white/20 transition-all duration-300 group-hover:scale-105 group-hover:bg-white/30 group-hover:border-white/40">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                    @endif
                    <!-- Online Status Badge -->
                    <div class="absolute bottom-0 right-0 h-5 w-5 rounded-full bg-emerald-400 border-2 border-white shadow-md shadow-emerald-400/30"></div>
                </div>
            </div>

            <!-- User Info -->
            <div class="min-w-0 flex-1">
                <div class="flex flex-wrap items-center gap-3">
                    <p class="text-xs font-semibold uppercase tracking-widest text-white/70 font-sans">
                        {{ __('My Profile') }}
                    </p>
                    <span class="px-3 py-0.5 text-[10px] font-sans uppercase tracking-wider bg-white/20 rounded-full text-white/90 border border-white/10 backdrop-blur-sm">
                        {{ auth()->user()->role ?? 'Admin' }}
                    </span>
                </div>
                <h3 class="truncate text-2xl font-sans text-white mt-1 tracking-tight">
                    {{ auth()->user()->name }}
                </h3>
                <div class="flex items-center gap-2 mt-0.5">
                    <svg class="h-4 w-4 text-white/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    <p class="truncate text-sm text-white/80 font-sans">
                        {{ auth()->user()->email }}
                    </p>
                </div>
            </div>

       
        </div>
    </div>

    <!-- Profile Details Content -->
    <div class="relative grid grid-cols-1 gap-6 p-8 md:grid-cols-2">
        
        <!-- Account Information Card -->
        <div class="group rounded-2xl bg-gradient-to-br from-white to-slate-50/80 p-6 shadow-lg shadow-slate-200/50 border border-slate-200/60 transition-all duration-300 hover:shadow-xl hover:shadow-primary/5 hover:-translate-y-1 hover:border-primary/20">
            <div class="flex items-center gap-3 border-b border-slate-200/60 pb-4 mb-5">
                <div class="p-2.5 rounded-xl bg-gradient-to-br from-primary/10 to-primary/5 text-primary shadow-sm">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="2" y="5" width="20" height="14" rx="2" />
                        <path d="M2 10h20" />
                    </svg>
                </div>
                <span class="text-sm font-bold text-slate-700 font-sans tracking-wide">{{ __('Account Information') }}</span>
            </div>

            <div class="space-y-4">
                <div class="flex items-start gap-3">
                    <div class="mt-0.5 p-1.5 rounded-lg bg-slate-100/80 text-slate-400">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-semibold uppercase tracking-wider text-slate-400 font-sans">{{ __('Name') }}</p>
                        <p class="text-sm font-bold text-slate-800 mt-0.5">{{ auth()->user()->name }}</p>
                    </div>
                </div>

                <div class="flex items-start gap-3">
                    <div class="mt-0.5 p-1.5 rounded-lg bg-slate-100/80 text-slate-400">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-semibold uppercase tracking-wider text-slate-400 font-sans">{{ __('Email') }}</p>
                        <p class="text-sm font-bold text-slate-800 mt-0.5">{{ auth()->user()->email }}</p>
                    </div>
                </div>

                <div class="flex items-start gap-3">
                    <div class="mt-0.5 p-1.5 rounded-lg bg-slate-100/80 text-slate-400">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-semibold uppercase tracking-wider text-slate-400 font-sans">{{ __('Role') }}</p>
                        <p class="text-sm font-bold text-slate-800 mt-0.5">
                            <span class="px-2.5 py-0.5 rounded-full bg-primary/10 text-primary text-xs font-semibold border border-primary/20">
                                {{ auth()->user()->role ?? 'Admin' }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Details Card -->
        <div class="group rounded-2xl bg-gradient-to-br from-white to-slate-50/80 p-6 shadow-lg shadow-slate-200/50 border border-slate-200/60 transition-all duration-300 hover:shadow-xl hover:shadow-secondary/5 hover:-translate-y-1 hover:border-secondary/20">
            <div class="flex items-center gap-3 border-b border-slate-200/60 pb-4 mb-5">
                <div class="p-2.5 rounded-xl bg-gradient-to-br from-secondary/10 to-secondary/5 text-secondary shadow-sm">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z" />
                    </svg>
                </div>
                <span class="text-sm font-bold text-slate-700 font-sans tracking-wide">{{ __('Contact Details') }}</span>
            </div>

            <div class="space-y-4">
                <div class="flex items-start gap-3">
                    <div class="mt-0.5 p-1.5 rounded-lg bg-slate-100/80 text-slate-400">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-semibold uppercase tracking-wider text-slate-400 font-sans">{{ __('Phone Number') }}</p>
                        <p class="text-sm font-bold text-slate-800 mt-0.5">
                            {{ auth()->user()->phone ?? '-' }}
                        </p>
                    </div>
                </div>

                <div class="flex items-start gap-3">
                    <div class="mt-0.5 p-1.5 rounded-lg bg-slate-100/80 text-slate-400">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-semibold uppercase tracking-wider text-slate-400 font-sans">{{ __('Address') }}</p>
                        <p class="text-sm font-bold text-slate-800 mt-0.5">
                            {{ auth()->user()->address ?? '-' }}
                        </p>
                    </div>
                </div>

                <div class="flex items-start gap-3">
                    <div class="mt-0.5 p-1.5 rounded-lg bg-slate-100/80 text-slate-400">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-semibold uppercase tracking-wider text-slate-400 font-sans">{{ __('Joined') }}</p>
                        <p class="text-sm font-bold text-slate-800 mt-0.5">
                            {{ auth()->user()->created_at ? auth()->user()->created_at->format('M d, Y') : '-' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

   
    </div>
</div>