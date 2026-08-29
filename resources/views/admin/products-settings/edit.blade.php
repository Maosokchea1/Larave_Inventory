<x-modal name="edit-setting-{{ $setting->id }}" focusable>
    <form action="{{ route('products-settings.update', $setting->id) }}" method="POST" class="p-6 md:p-8 font-khmer" 
        x-data="{ loading: false }" @submit="loading = true">
        @csrf
        @method('PUT')

        <!-- Modal Header -->
        <div class="flex items-center justify-between pb-4 mb-6 border-b border-slate-100">
            <div>
                <h2 class="text-xl font-black text-slate-800 tracking-tight font-english">
                    {{ __('Edit Product Setting') }}
                </h2>
                <p class="text-xs text-slate-400 mt-0.5 font-english">{{ __('Update configuration setting details.') }}</p>
            </div>
            <button type="button" x-on:click="$dispatch('close')" class="w-8 h-8 rounded-full bg-slate-50 hover:bg-slate-100 flex items-center justify-center text-slate-400 hover:text-slate-600 transition-colors cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div class="space-y-4 max-h-[65vh] overflow-y-auto pr-1">
            <!-- Type Field -->
            <div>
                <label for="type-{{ $setting->id }}" class="block text-xs font-extrabold text-slate-600 uppercase tracking-wider mb-1.5 font-english">
                    {{ __('Type') }} <span class="text-rose-500">*</span>
                </label>
                <input 
                    type="text" 
                    name="type" 
                    id="type-{{ $setting->id }}" 
                    class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-800 text-sm focus:ring-2 focus:ring-primary focus:border-primary transition-all font-medium font-english" 
                    required 
                    placeholder="{{ __('e.g., Brand, Size, Color...') }}" 
                    value="{{ old('type', $setting->type) }}">
                <x-input-error class="text-xs mt-1.5" :messages="$errors->get('type')" />
            </div>

            <!-- Name Field -->
            <div>
                <label for="name-{{ $setting->id }}" class="block text-xs font-extrabold text-slate-600 uppercase tracking-wider mb-1.5 font-english">
                    {{ __('Name') }} <span class="text-rose-500">*</span>
                </label>
                <input 
                    type="text" 
                    name="name" 
                    id="name-{{ $setting->id }}" 
                    class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-800 text-sm focus:ring-2 focus:ring-primary focus:border-primary transition-all font-medium font-english" 
                    required 
                    placeholder="{{ __('Enter setting name...') }}" 
                    value="{{ old('name', $setting->name) }}">
                <x-input-error class="text-xs mt-1.5" :messages="$errors->get('name')" />
            </div>
        </div>

        <!-- Buttons Footer -->
        <div class="flex items-center justify-end gap-3 pt-5 mt-6 border-t border-slate-100">
            <button type="button" x-on:click="$dispatch('close')" class="px-5 py-2.5 text-xs font-extrabold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl transition-all cursor-pointer font-english">
                {{ __('Cancel') }}
            </button>
            <button type="submit" class="px-6 py-2.5 text-xs font-extrabold text-white bg-primary hover:bg-primary-700 shadow-md shadow-primary/20 rounded-xl transition-all cursor-pointer font-english inline-flex items-center justify-center min-w-[120px]" ::disabled="loading">
                <span x-show="!loading">{{ __('Update Setting') }}</span>
                <span x-show="loading" class="flex items-center gap-1.5" style="display: none;">
                    <svg class="animate-spin -ml-1 h-3.5 w-3.5 text-white" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    {{ __('Updating...') }}
                </span>
            </button>
        </div>
    </form>
</x-modal>