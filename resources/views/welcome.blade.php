<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="https://i.pinimg.com/736x/55/dc/f7/55dcf734bd22f4277d10444622b2b825.jpg" type="image/x-icon">
    <title>{{ __('Inventory') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-12px); }
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-float { animation: float 4s ease-in-out infinite; }
        .animate-fade-in-up {
            animation: fadeInUp 0.7s ease-out forwards;
            opacity: 0;
        }
        .delay-100 { animation-delay: 0.1s; }
        .delay-200 { animation-delay: 0.2s; }
        .delay-300 { animation-delay: 0.3s; }
        .delay-400 { animation-delay: 0.4s; }
    </style>
</head>
<body class="antialiased bg-gradient-to-br from-slate-50 via-white to-indigo-50/40 text-slate-800 min-h-screen flex flex-col font-sans">

    <!-- Simple Background Accent -->
    <div class="fixed inset-0 -z-10 overflow-hidden pointer-events-none">
        <div class="absolute -top-32 -right-32 w-96 h-96 bg-indigo-200/20 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-32 -left-32 w-96 h-96 bg-purple-200/15 rounded-full blur-3xl"></div>
    </div>

    <!-- ====== NAVBAR ====== -->
    <header class="relative w-full max-w-6xl mx-auto px-6 py-5 flex justify-between items-center">
        <!-- Logo -->
        <a href="/" class="flex items-center gap-3 group">
            <div class="w-10 h-10 rounded-xl bg-indigo-600 flex items-center justify-center shadow-md shadow-indigo-200 transition group-hover:shadow-indigo-300">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 6.75l-4.5 2.25-4.5-2.25M16.5 6.75l-4.5-2.25-4.5 2.25M16.5 6.75v7.5l-4.5 2.25M12 9v7.5l-4.5-2.25M12 9l-4.5-2.25" />
                </svg>
            </div>
            <div>
                <span class="text-xl font-extrabold text-slate-800">Inventory<span class="text-indigo-600">Pro</span></span>
                <span class="block text-[9px] font-bold text-slate-400 tracking-[0.2em] uppercase -mt-0.5">Management</span>
            </div>
        </a>

        <!-- Nav Links -->
        <nav class="flex items-center gap-3">
            @auth
                <a href="{{ url('/dashboard') }}" class="px-5 py-2 text-sm font-semibold text-slate-600 hover:text-indigo-600 transition">
                    Dashboard
                </a>
            @else
                <a href="{{ route('login') }}" class="px-5 py-2 text-sm font-medium text-slate-600 hover:text-indigo-600 transition">
                    Log in
                </a>
                <a href="{{ route('register') }}" class="px-6 py-2.5 text-sm font-bold text-white bg-indigo-600 rounded-xl hover:bg-indigo-700 hover:shadow-lg hover:shadow-indigo-200 transition-all">
                    Get Started
                </a>
            @endauth
        </nav>
    </header>

    <!-- ====== HERO ====== -->
    <main class="flex-grow flex items-center">
        <div class="max-w-6xl mx-auto px-6 w-full grid grid-cols-1 lg:grid-cols-2 gap-14 items-center py-8">

            <!-- Left: Content -->
            <div class="space-y-6">
                <!-- Badge -->
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-indigo-50 border border-indigo-100 text-indigo-700 text-xs font-bold uppercase tracking-wider animate-fade-in-up">
                    <span class="w-1.5 h-1.5 rounded-full bg-indigo-500 animate-pulse"></span>
                    Build Bright University
                </div>

                <!-- Heading -->
                <h1 class="text-5xl sm:text-6xl font-extrabold text-slate-900 leading-[1.1] animate-fade-in-up delay-100">
                    Manage Your<br/>
                    <span class="text-indigo-600">Perfect System</span>
                </h1>

                <!-- Description -->
                <p class="text-lg text-slate-500 max-w-md leading-relaxed animate-fade-in-up delay-200">
                    Professional inventory management for modern institutions. Clean, fast, and intuitive.
                </p>

                <!-- CTA Buttons -->
                <div class="flex flex-wrap gap-4 pt-2 animate-fade-in-up delay-300">
                    <a href="{{ route('register') }}" class="group px-8 py-3.5 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-700 hover:shadow-lg hover:shadow-indigo-200 transition-all flex items-center gap-2">
                        Get Started
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75" />
                        </svg>
                    </a>
                    <a href="{{ route('login') }}" class="px-8 py-3.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:border-indigo-300 hover:shadow-md transition-all">
                        Sign In
                    </a>
                </div>

                <!-- Trust Badges -->
                <div class="flex items-center gap-6 pt-4 animate-fade-in-up delay-400">
                    <div class="flex -space-x-2">
                        <div class="w-8 h-8 rounded-full bg-indigo-100 border-2 border-white flex items-center justify-center text-[10px] font-bold text-indigo-600">A</div>
                        <div class="w-8 h-8 rounded-full bg-purple-100 border-2 border-white flex items-center justify-center text-[10px] font-bold text-purple-600">B</div>
                        <div class="w-8 h-8 rounded-full bg-emerald-100 border-2 border-white flex items-center justify-center text-[10px] font-bold text-emerald-600">C</div>
                    </div>
                    <span class="text-sm text-slate-500">Trusted by <strong class="text-slate-700">500+</strong> users</span>
                </div>
            </div>

            <!-- Right: Image -->
            <div class="relative animate-fade-in-up delay-200">
                <div class="relative rounded-2xl overflow-hidden shadow-2xl shadow-indigo-100/50 border border-white/50">
                    <img src="https://bbu-webiste-space.sgp1.cdn.digitaloceanspaces.com/campus/pp/logo/20250816071156_bd0691f6fd091331c1bd902546ed881652946d43cc827c9d0c408c4b96cd8ffe.webp" 
                         alt="BBU Campus" 
                         class="w-full h-[320px] sm:h-[400px] object-cover">
                    <!-- Overlay -->
                    <div class="absolute inset-0 bg-gradient-to-t from-indigo-900/10 via-transparent to-transparent"></div>
                </div>

                <!-- Floating Card -->
                <div class="absolute -bottom-5 -left-5 bg-white/90 backdrop-blur-sm p-4 rounded-xl shadow-xl border border-white/50 flex items-center gap-3 animate-float">
                    <div class="p-2.5 bg-emerald-50 text-emerald-600 rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-bold text-sm text-slate-800">100% Secure</p>
                        <p class="text-xs text-slate-500">Enterprise grade</p>
                    </div>
                </div>

                <!-- Small floating badge top-right -->
                <div class="absolute -top-3 -right-3 bg-white/90 backdrop-blur-sm px-4 py-2 rounded-xl shadow-lg border border-white/50 text-xs font-bold text-indigo-600 animate-float" style="animation-delay: 2s;">
                    ⚡ Fast & Reliable
                </div>
            </div>
        </div>
    </main>

    <!-- ====== FOOTER ====== -->
    <footer class="relative w-full max-w-6xl mx-auto px-6 py-6 flex flex-col sm:flex-row justify-between items-center gap-3 border-t border-slate-200/50">
        <p class="text-sm text-slate-400">
            &copy; {{ date('Y') }} InventoryPro. {{ __('All rights reserved.') }}
        </p>
        <div class="flex items-center gap-5 text-sm text-slate-400">
            <a href="#" class="hover:text-indigo-600 transition">Privacy</a>
            <a href="#" class="hover:text-indigo-600 transition">Terms</a>
            <a href="#" class="hover:text-indigo-600 transition">Support</a>
        </div>
    </footer>

</body>
</html>