<x-guest-layout>
    <div class="fixed inset-0 z-50 overflow-y-auto bg-primary/40 backdrop-blur-xs font-sans">
        <div class="flex min-h-screen items-center justify-center px-4 py-10 sm:px-6">
            
            <div class="w-full max-w-5xl min-h-[550px] rounded-2xl bg-white shadow-xl shadow-slate-200/60 overflow-hidden flex flex-col md:flex-row">
                
                <!-- LEFT SIDE -->
                <div class="w-full md:w-1/2 p-6 sm:p-8 flex flex-col justify-center relative bg-cover bg-center bg-no-repeat" 
                     style="background-image: url('https://i.pinimg.com/736x/57/56/7d/57567d72d5bd14fd5a038b5003fb0e16.jpg');">
                    
                    <div class="absolute inset-0 bg-white/85 backdrop-blur-sm"></div>
                    
                    <div class="relative z-10">
                        <div class="mb-6 text-center">
                            <h1 class="text-2xl font-bold tracking-tight text-slate-900">{{ __('Reset Password') }}</h1>
                            <p class="mt-2 text-sm text-slate-500">
                                {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link.') }}
                            </p>
                        </div>

                        <!-- Session Status -->
                        <x-auth-session-status class="mb-5 rounded-lg bg-emerald-50 px-4 py-3 text-sm text-emerald-700" :status="session('status')" />

                        <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
                            @csrf

                            <!-- Email Address -->
                            <div>
                                <x-input-label for="email" :value="__('Email Address')" class="mb-1.5 text-sm font-medium text-slate-700" />
                                <div class="relative flex items-center">
                                    <div class="absolute left-0 flex items-center pl-3.5 pointer-events-none">
                                        <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <x-text-input id="email" class="block w-full rounded-lg border-slate-300 py-2.5 pl-11 pr-4 text-sm shadow-sm focus:border-blue-600 focus:ring-blue-600" type="email" name="email" :value="old('email')" required autofocus placeholder="name@pp.bbu.edu.kh" />
                                </div>
                                <x-input-error :messages="$errors->get('email')" class="mt-1" />
                            </div>

                            <div class="pt-2">
                                <button type="submit" class="w-full justify-center rounded-lg bg-blue-700 hover:bg-blue-800 py-3 text-sm font-semibold text-white shadow-md shadow-blue-700/30 transition flex items-center">
                                    {{ __('Email Password Reset Link') }}
                                </button>
                            </div>
                        </form>

                        <!-- Back to Login Link -->
                        <p class="mt-5 text-center text-sm text-slate-500">
                            {{ __('Remembered your password?') }}
                            <a href="{{ route('login') }}" class="font-semibold text-blue-700 hover:text-blue-800 underline">{{ __('Sign in') }}</a>
                        </p>
                    </div>
                </div>

                <!-- RIGHT SIDE -->
                <div class="hidden md:flex md:w-1/2 bg-slate-50 items-center justify-center overflow-hidden">
                    <img src="https://bbu-webiste-space.sgp1.cdn.digitaloceanspaces.com/campus/pp/logo/20250816071156_bd0691f6fd091331c1bd902546ed881652946d43cc827c9d0c408c4b96cd8ffe.webp" 
                        alt="BBU Forgot Password" 
                        class="h-full w-full object-cover">
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>