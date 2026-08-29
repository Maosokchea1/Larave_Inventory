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
                            <h1 class="text-2xl font-bold tracking-tight text-slate-900">{{ __('Verify Your Email') }}</h1>
                            <p class="mt-2 text-sm text-slate-500">
                                {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
                            </p>
                        </div>

                        @if (session('status') == 'verification-link-sent')
                            <div class="mb-5 rounded-lg bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700 text-center">
                                {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                            </div>
                        @endif

                        <div class="space-y-4 pt-2">
                            <form method="POST" action="{{ route('verification.send') }}">
                                @csrf
                                <button type="submit" class="w-full justify-center rounded-lg bg-blue-700 hover:bg-blue-800 py-3 text-sm font-semibold text-white shadow-md shadow-blue-700/30 transition flex items-center">
                                    {{ __('Resend Verification Email') }}
                                </button>
                            </form>

                            <div class="text-center pt-2">
                                <form method="POST" action="{{ route('logout') }}" class="inline">
                                    @csrf
                                    <button type="submit" class="text-sm font-semibold text-slate-600 hover:text-slate-900 underline">
                                        {{ __('Log Out') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- RIGHT SIDE -->
                <div class="hidden md:flex md:w-1/2 bg-slate-50 items-center justify-center overflow-hidden">
                    <img src="https://bbu-webiste-space.sgp1.cdn.digitaloceanspaces.com/campus/pp/logo/20250816071156_bd0691f6fd091331c1bd902546ed881652946d43cc827c9d0c408c4b96cd8ffe.webp" 
                        alt="BBU Verify Email" 
                        class="h-full w-full object-cover">
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>