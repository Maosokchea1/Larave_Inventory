<x-modal name="add-user" max-width="sm" focusable>
    <form action="{{ route('admin.users.store') }}" method="POST" class="p-6 md:p-8 font-khmer" 
        x-data="{ loading: false }" @submit="loading = true">
        @csrf

        <!-- Modal Header -->
        <div class="flex items-center justify-between pb-4 mb-6 border-b border-slate-100">
            <div>
                <h3 class="text-xl font-black text-slate-800 tracking-tight font-english">
                    {{ __('Create User') }}
                </h3>
                <p class="text-xs text-slate-400 mt-0.5 font-english">{{ __('Add a new user from admin panel.') }}</p>
            </div>
            <button type="button" @click="$dispatch('close')" class="w-8 h-8 rounded-full bg-slate-50 hover:bg-slate-100 flex items-center justify-center text-slate-400 hover:text-slate-600 transition-colors cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div class="space-y-4 max-h-[65vh] overflow-y-auto pr-1">
            @if ($errors->any())
                <div class="p-3 bg-rose-50 border border-rose-200 text-xs text-rose-600 rounded-xl font-english">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Name Field -->
            <div>
                <label for="name" class="block text-xs font-extrabold text-slate-600 uppercase tracking-wider mb-1.5 font-english">
                    {{ __('Name') }} <span class="text-rose-500">*</span>
                </label>
                <input 
                    id="name"
                    name="name"
                    type="text"
                    value="{{ old('name') }}"
                    class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-800 text-sm focus:ring-2 focus:ring-primary focus:border-primary transition-all font-medium font-english"
                    required
                    autofocus
                    placeholder="{{ __('Enter user name...') }}"
                />
            </div>

            <!-- Email Field -->
            <div>
                <label for="email" class="block text-xs font-extrabold text-slate-600 uppercase tracking-wider mb-1.5 font-english">
                    {{ __('Email') }} <span class="text-rose-500">*</span>
                </label>
                <input 
                    id="email"
                    name="email"
                    type="email"
                    value="{{ old('email') }}"
                    class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-800 text-sm focus:ring-2 focus:ring-primary focus:border-primary transition-all font-medium font-english"
                    required
                    placeholder="{{ __('Enter email address...') }}"
                />
            </div>

            <!-- Password Field -->
            <div>
                <label for="password" class="block text-xs font-extrabold text-slate-600 uppercase tracking-wider mb-1.5 font-english">
                    {{ __('Password') }} <span class="text-rose-500">*</span>
                </label>
                <input 
                    id="password"
                    name="password"
                    type="password"
                    class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-800 text-sm focus:ring-2 focus:ring-primary focus:border-primary transition-all font-medium font-english"
                    required
                    placeholder="{{ __('Enter password...') }}"
                />
            </div>

            <!-- Confirm Password Field -->
            <div>
                <label for="password_confirmation" class="block text-xs font-extrabold text-slate-600 uppercase tracking-wider mb-1.5 font-english">
                    {{ __('Confirm Password') }} <span class="text-rose-500">*</span>
                </label>
                <input 
                    id="password_confirmation"
                    name="password_confirmation"
                    type="password"
                    class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-800 text-sm focus:ring-2 focus:ring-primary focus:border-primary transition-all font-medium font-english"
                    required
                    placeholder="{{ __('Confirm password...') }}"
                />
            </div>
        </div>

        <!-- Buttons Footer -->
        <div class="flex items-center justify-end gap-3 pt-5 mt-6 border-t border-slate-100">
            <button type="button" @click="$dispatch('close')" class="px-5 py-2.5 text-xs font-extrabold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl transition-all cursor-pointer font-english">
                {{ __('Cancel') }}
            </button>

            <button type="submit" class="px-6 py-2.5 text-xs font-extrabold text-white bg-primary hover:bg-primary-700 shadow-md shadow-primary/20 rounded-xl transition-all cursor-pointer font-english inline-flex items-center justify-center min-w-[100px]" :disabled="loading">
                <span x-show="!loading">{{ __('Save') }}</span>
                <span x-show="loading" class="flex items-center gap-1.5" style="display: none;">
                    <svg class="animate-spin -ml-1 h-3.5 w-3.5 text-white" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    {{ __('Saving...') }}
                </span>
            </button>
        </div>
    </form>
</x-modal>