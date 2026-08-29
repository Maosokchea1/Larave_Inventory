<div class="bg-white rounded-2xl shadow-xl overflow-hidden max-w-3xl w-full mx-auto">
    <!-- Header Red Background -->
    <div class="bg-red-700 p-6 text-white relative">
        <button @click="open = false" class="absolute top-4 right-4 text-white/80 hover:text-white bg-black/10 hover:bg-black/20 rounded-full p-1.5 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 rounded-full overflow-hidden bg-white/25 flex items-center justify-center border-2 border-white/40 shadow-md shrink-0">
                @if(Auth::user()->image ?? false)
                    <img src="{{ asset('storage/' . Auth::user()->image) }}" alt="Profile Image" class="w-full h-full object-cover">
                @else
                    <span class="text-2xl font-bold text-white">{{ substr(Auth::user()->name, 0, 1) }}</span>
                @endif
            </div>
            <div>
                <p class="text-xs uppercase tracking-wider text-white/80 font-semibold">EDIT PROFILE SETTINGS</p>
                <h2 class="text-xl font-sans text-white">{{ Auth::user()->name }}</h2>
                <p class="text-sm text-white/90">{{ Auth::user()->email }}</p>
            </div>
        </div>
    </div>

    <!-- Edit Form -->
    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6 bg-slate-50/50">
        @csrf
        @method('PATCH')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Account Information Section -->
            <div class="bg-white p-5 rounded-xl border border-slate-100 shadow-sm space-y-4">
                <h3 class="text-red-700 font-sans border-b pb-2 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                    Account Information
                </h3>

                <div>
                    <label class="block text-xs text-slate-500 font-sans mb-1">{{ __('Name') }}</label>
                    <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}" class="w-full text-sm border-slate-200 rounded-lg focus:border-red-700 focus:ring-red-700" required>
                </div>

                <div>
                    <label class="block text-xs text-slate-500 font-sans mb-1">{{ __('Email') }}</label>
                    <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}" class="w-full text-sm border-slate-200 rounded-lg focus:border-red-700 focus:ring-red-700" required>
                </div>

                <div>
                    <label class="block text-xs text-slate-500 font-sans mb-1">{{ __('Profile Image') }}</label>
                    <input type="file" name="image" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100">
                </div>
            </div>

            <!-- Contact Details Section -->
            <div class="bg-white p-5 rounded-xl border border-slate-100 shadow-sm space-y-4">
                <h3 class="text-red-700 font-semibold border-b pb-2 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.3-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    Contact Details
                </h3>

                <div>
                    <label class="block text-xs text-slate-500 font-sans mb-1">{{ __('Phone') }}</label>
                    <input type="text" name="phone" value="{{ old('phone', Auth::user()->phone ?? '') }}" class="w-full text-sm border-slate-200 rounded-lg focus:border-red-700 focus:ring-red-700" placeholder="{{ __('Enter phone number') }}">
                </div>

                <div>
                    <label class="block text-xs text-slate-500 font-sans mb-1">{{ __('Address') }}</label>
                    <input type="text" name="address" value="{{ old('address', Auth::user()->address ?? '') }}" class="w-full text-sm border-slate-200 rounded-lg focus:border-red-700 focus:ring-red-700" placeholder="{{ __('Enter address') }}">
                </div>
            </div>
        </div>

        <!-- Save Button -->
        <div class="flex justify-end gap-3 pt-2">
            <button type="submit" class="px-6 py-2.5 bg-red-700 hover:bg-red-800 text-white font-sans text-sm rounded-xl shadow-md transition">
                {{ __('Save Changes') }}
            </button>
        </div>
    </form>
</div>